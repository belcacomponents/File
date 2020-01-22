<?php

namespace Belca\File\Http\Controllers;

use Belca\File\Contracts\FileRepository;
use Illuminate\Support\Facades\Storage;
use Belca\File\Models\File;

/**
 * Базовая загрузка файлов.
 */
class DownloadController
{
    /*public function __construct(FileRepository $files)
    {
        $this->files = $files;
    }*/

    public function __invoke($request)
    {
        $file = File::wherePublished(true)->whereSlug($request)->firstOrFail();

        return response()->file(Storage::disk($file->disk)->path($file->path));

        // TODO должен получить URL
        // обработать URL
        // проверить на разрешенность скачивания: ограничения по IP, по количесту,
        // по принадлежности и т.п.
        // выполнить обработку: подсчет скачиваний, изменение имени, определение формата,
        // подмена файла, проверка на доступ
        // вернуть файл для скачивания
    }
}
