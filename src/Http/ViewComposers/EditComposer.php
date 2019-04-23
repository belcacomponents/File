<?php

namespace Belca\File\Http\ViewComposers;

use Illuminate\View\View;
use Belca\File\Repositories\FileRepository;

class EditComposer
{
    /**
     * The file repository implementation.
     *
     * @var FileRepository
     */
    protected $files;

    /**
     * Create a new edit composer.
     *
     * @param  FileRepository  $files
     * @return void
     */
    public function __construct(FileRepository $files)
    {
        // Dependencies automatically resolved by service container...
        $this->files = $files;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
      // Загрузка данных об обработке изображения - через композер
      // Загрузка данных об использовании изображений - через композер
      // Загрузка данных о доступе к изображению и скачивании - через композер и/или репозиторий
      // 
        // TODO либо манипулировать данными репозитория,
        // либо создать очередного композера и подключить его
        //$view->with('count', $this->users->count());
    }
}
