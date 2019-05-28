<?php

namespace Belca\File\Repositories;

use Belca\File\Contracts\FileRepository as FileRepositoryInterface;
use Prettus\Repository\Eloquent\BaseRepository;
use Belca\File\Models\File as BaseFile;
use Prettus\Validator\Contracts\ValidatorInterface;

/**
 * Данный класс включает реализацию отношений с модификациями.
 */
class FileRepositoryEloquent extends BaseRepository implements FileRepositoryInterface
{
    protected $guarded = [
        'path', 'source', 'parent_id', 'size', 'disk', 'mime', 'group',
        'dirver', 'handler', 'handler_mode', 'extension', 'options',
    ];

    /**
     * Возвращает название класса модели.
     *
     * @return string
     */
    public function model()
    {
        return BaseFile::class;
    }

    public function original()
    {
        return $this->model->original();
    }

    /**
     * Фильтрует информацию по указанным критериям.
     *
     * @param  array $array Условия фильтрации
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function filter($inputs = [])
    {
        return $this->model->filter($inputs);
        // TODO лучше использовать интерфейс или какой-то класс с наборот функций
        // соотношений данных или конвертаией полей и т.п.
        // Чтобы можно было применять независимо от модели и имен на форме
        // строить свои условия
    }

    public function sort($inputs = [])
    {
        return $this->model;
    }

    /**
     * Сохраняет переданные значения минуя указанные защищенные поля.
     *
     * @param  mixed  $values       Все данные полей ввода
     * @param  array  $guarded      Защищенные поля разрешенные для заполнения
     * @return mixed
     */
    public function createWithoutGuardedFields($values, $guarded = [])
    {
        if (empty($guarded)) {
            if (! empty($this->guarded) && is_array($this->guarded)) {
                $guarded = $this->guarded;
                // Получить значения из общего массива защищенных полей.
                // Они определяеются при инициализации класса, задавая статически в
                // классе или извлекаются из модели.
            }
        }

        $model = $this->model->newInstance($values);
        $model->forceFill(array_only($values, $guarded));
        $model->fill($values);
        $model->save();
        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * Сохраняет значения с защищенными значениями. Разрешенные значения
     * сохраняются при указании их в защищенных полях.
     *
     * @param  array  $values        Любые разрешенные знаения
     * @param  array  $allowedValues Разрешенные значения
     * @param  array  $guarded      Защищенные поля
     * @return [type]                [description]
     */
    public function createWithGuardedValues($values, $allowedValues, $guarded = [])
    {
        // TODO защищенные поля и значения
    }

    /**
     * Создает модификации в таблице на основе ID родителя и данных
     * о модификациях. Возвращает количество созданных модификаций или false,
     * если не найден указанных родитель.
     *
     * @param  integer            $id
     * @param  mixed              $files
     * @return boolean|integer
     */
    public function createModifications($id, $files = [], $guarded = [])
    {
        $parent = $this->model->find($id);

        if (empty($parent)) {
            return false;
        }

        $count = 0;

        if (is_array($files) && count($files)) {
            foreach ($files as $file) {
                // TODO скопировать "публичные" значения родительской записи,
                // если они будут в информации, то будут переопределены
                $this->createWithoutGuardedFields(array_merge(['parent_id' => $parent->id], $file));
                $count++;
            }
        }

        return $count;
    }

    /**
     * Удаляет экземпляр файла вместе с модификациями. Возвращает количество
     * удаленных записей.
     *
     * @param  integer  $id
     * @return integer
     */
    public function deleteWithModifications($id)
    {
        $file = $this->model->find($id);

        $deleted = $file->modifications()->delete();

        $file->delete();

        return ++$deleted;
    }

    /**
     * Возвращает модификации указанного экземпляра файла.
     *
     * @param  integer      $id
     * @return Collection
     */
    public function getModifications($id)
    {
        return $this->model->whereParentId($id)->get();
    }

    /**
     * Возвращает экземпляр файла и его модификации в виде одно массива.
     *
     * @param  integer $id
     * @return array
     */
    public function findWithModifications($id/*, $wrapper*/)
    {
        $files = [];
        $file = $this->model->original()->find($id);

        if (! empty($file)) {
            $files[] = $file;
            $files = array_merge($files, $this->getModifications($file->id)->all());
        }

        return $files;
    }

    // TODO удаление связанных данных: действите: удалить, опусташить, каждому свое

}
