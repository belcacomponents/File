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

    /**
     * Сохраняет переданные значения.
     *
     * @param  mixed  $attributes   Все данные полей ввода
     * @param  array  $guarded      Защищенные поля разрешенные для заполнения
     * @return mixed
     */
    public function createWithGuardedFields($attributes, $guarded = [])
    {
        if (empty($guarded)) {
            if (! empty($this->guarded) && is_array($this->guarded)) {
                $guarded = $this->guarded;
                // Получить значения из общего массива защищенных полей.
                // Они определяеются при инициализации класса, задавая статически в
                // классе или извлекаются из модели.
            }
        }

        $model = $this->model->newInstance($attributes);
        $model->forceFill(array_only($attributes, $guarded));
        $model->fill($attributes);
        $model->save();
        $this->resetModel();

        return $this->parserResult($model);
    }

    public function createWithGuardedValues($attributes, $guardedValues = [])
    {
        // TODO защищенные поля и значения
    }

    /**
     * Создает модификации в таблице на основе ID родителя и данных о модификациях.
     *
     * @param  integer $id ID родительской записи (файла)
     * @param  mixed $files      Массив данных о модификациях
     * @return [type]           [description]
     */
    public function createModifications($id, $files = [])
    {
        if (is_array($files) && count($files)) {
            foreach ($files as $file) {
                // TODO задать parent_id
                $this->model->create($file);
            }
        }
    }


    public function deleteModifications($id, $except = true, $modifications = [])
    {

    }

    public function getModifications($id)
    {

    }

    public function findWithModifications($id, $column)
    {

    }

    // TODO удаление связанных данных: действите: удалить, опусташить, каждому свое

}
