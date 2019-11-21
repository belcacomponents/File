<?php

namespace Belca\File\Http\Services;

use Belca\File\Contracts\FileRepository;
use Illuminate\Support\Facades\Storage;

/**
 * Бизнес-логика для работы с файлами.
 */
class FileService
{

    public function __construct(FileRepository $files)
    {
        $this->files = $files;
    }

    /**
     * Возвращает список файлов по указанным критериям.
     *
     * @param  boolean $original
     * @param  mixed   $attributes
     * @param  boolean $paginate
     * @param  integer $count
     * @return mixed
     */
    public function getFiles($original = true, $attributes, $paginate = true, $count = 20)
    {
        // TODO Должна быть сортировка, фильтрация, поиск по названю, поиск по другим критериям
        // По умолчанию сортировка latest

        $files = $original ? $this->files->original() : $this->files;

        $files->filter($attributes)/*->sort($request->input())*/->latest();

        if (isset($attributes['count']) && is_integer($attributes['count']) && $attributes['count'] > 1) {
            $count = $attributes['count'];
        }

        return $paginate ? $files->get() : $files->paginate($count);
    }

    /**
     * Возвращает файл, если он существует, иначе null. Если $original - true,
     * то осуществляет поиск оригинального файла.
     *
     * @param  integer  $id
     * @param  boolean  $original
     * @return \Belca\File\Models\File
     */
    public function getFile($id, $original = true)
    {
        return $original ? $this->files->original()->find($id) : $this->files->find($id);
    }

    /**
     * Возвращает оригинальный файл с модификациями.
     *
     * @param  integer $id
     * @return \Belca\File\Models\File
     */
    public function getFileWithModifications($id)
    {
        return $this->files->findWithModifications($id);
    }

    /**
     * Сохраняет файл и создает запись в БД.
     *
     * @param  string             $disk            Хранилище файла
     * @param  string             $filenamePattern Шаблон имени файла
     * @param  UploadFile|string  $file            Загруженный файл
     * @param  mixed              $attributes      Данные файла (заголовок, описание и т.п.)
     * @param  mixed              $handlers        Обработчики файла
     * @param  mixed              $rules           Правила обработки файла
     * @param  integer            $parent          Родительский файл
     * @param  integer            $author          Автор файла
     * @return \Belca\File\Models\File
     */
    public function createFile($disk, $filenamePattern, $file, $attributes, $handlers, $rules, $parent = 0, $author = 1)
    {
        if (true) { // TODO проверка на интерфейс/класс UploadFile
            $fileinfo = [
                'filename' => $file->getClientOriginalName(),
                'title' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'mime' => $file->getMimeType(),
                'extension' => $file->clientExtension() ?? pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION),
            ];

            $originalFile = $file->getPathName();
        } else {
            // TODO на основе файла определить mime, extension, заголовок либо из атрибутов, либо рандом
            // для этого можно выделить отдельный метод
            $originalFile = $file;
        }

        $directory = Storage::disk($disk)->getAdapter()->getPathPrefix();

        $gename = new GeName();
        $gename->setPattern($this->filenamePattern);
        $gename->setInitialData([
            'mime' => $fileinfo['mime'],
            'extension' => $fileinfo['extension'],
            'filename' => $fileinfo['filename'],
        ]);
        $gename->setDirectory($directory);
        $filename = $gename->generateName();

        $fileHandler = new FileHandler($handlers, $rules);
        $fileHandler->setOriginalFile($originalFile, $fileinfo);
        $fileHandler->setDirectory($directory);

        if (! $fileHandler->save($filename)) {
            return null;
        }

        $basicFileinfo = $fileHandler->getBasicFileProperties();
        $additionalFileinfo = $fileHandler->getAdditionalFileProperties();

        $systemInfo = [
            'disk' => $disk,
            'author_id' => $author,
            'path' => $filename,
            'parent_id' => $parent,
        ];

        return $this->files->createWithGuardedFields(array_merge($request->input(), $fileinfo, $systemInfo, $basicFileinfo, ['options' => $additionalFileinfo]));
    }

    /**
     * Создает файл и модификации файла.
     *
     * @return [type] [description]
     */
    public function createFileWithModifications($disk, $filenamePattern, $file, $attributes, $author = 1)
    {

    }

    /**
     * Обновляет информацию о файле. При успешном обновлении возвращает
     * экземпляр модели.
     *
     * @param  integer $id
     * @param  mixed   $attributes
     * @return \Belca\File\Models\File
     */
    public function updateFileInfo($id, $attributes)
    {
        return $this->files->update($attributes, $id);
    }

    /**
     * Удаляет файл и запись из БД. При успешном удалении возвращает информацию
     * о файле, иначе null.
     *
     * @return array
     */
    public function deleteFile($id)
    {
        $file = $this->files->find($id);

        if (empty($files)) {
            return null;
        }

        Storage::disk($file->disk)->delete($file->path);
        $file->delete();

        return $file->toArray();
    }

    /**
     * Удаляет файл и его модификации с записями из БД. При успешном удалении
     * возвращает массив с числом удаленных файлов и список удаленных объектов.
     * Иначе возвращает null.
     *
     * @return mixed
     */
    public function deleteFileWithModifications($id)
    {
        // Изменение состояний связанных объектов - отдельный класс
        // Удаление файлов - отдельный класс, т.к. нужно удалять связанные данные из других таблиц
        // Можно удаление пустых папок - в предыдущем

        $files = $this->files->findWithModifications($id);

        if (empty($files)) {
            return null;
        }

        foreach ($files as $file) {
            Storage::disk($file->disk)->delete($file->path);
        }

        return [
            'count' => $this->files->deleteWithModifications($id),
            'original' => current($files),
            //'objects' => $files,
        ];
    }

    // TODO создать модификации, пересоздать модификации, заменить модификацию
}
