<?php

namespace Belca\File\Http\Controllers;

use Belca\File\Contracts\FileRepository;
//use Belca\File\Contracts\DownloadController as DownloadControllerInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Belca\File\Http\Requests\FileRequest;
use Belca\Support\Config;
use Belca\GeName\GeName;

/**
 * Базовая загрузка файлов.
 */
class DownloadController //implements DownloadControllerInterface
{
    public function __invoke($request)
    {
        // TODO должен получить URL
        // обработать URL
        // проверить на разрешенность скачивания: ограничения по IP, по количесту,
        // по принадлежности и т.п.
        // выполнить обработку: подсчет скачиваний, изменение имени, определение формата,
        // подмена файла, проверка на доступ
        // вернуть файл для скачивания

        dd($request);
    }
}
