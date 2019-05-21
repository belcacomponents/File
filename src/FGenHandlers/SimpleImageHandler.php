<?php

namespace Belca\File\FGenHandlers;

use Belca\FGen\FHandler;
use Belca\FileHandler\FileHandlerAdapterAbstract;
use Intervention\Image\ImageManager;

/**
 * Простой обработчик изображений.
 *
 * Основн на Intervention Image:
 *
 * github: https://github.com/Intervention/image
 * website: http://image.intervention.io/
 */
class SimpleImageHandler extends FHandler
{
    protected $manager;

    public function __construct($init = null)
    {
        $this->manager = new ImageManager(array('driver' => 'imagick'));
    }

    public function handle($filename, $method, $options = [])
    {
        if (! is_file($filename)) {
            return false;
        }

        if (/*method_exists($this, $method) && */in_array($method, $this->exceptions) && is_callable([$this, $method])) {
            return $this->$method($filename, $method, $options);
        }

        return false;
    }

    public function resize($filename, $options = [])
    {
        dd('resize');
        $img = $manager->make($filename);

        // Должны получить параметры по умолчанию

        $img->resize(320, 240);

        // Получает опции обработки файла: размеры масштабирования, обрезка файла,
        // сжатие, формат сохраняемого файла, новое имя сохраняемого файла - шаблон,
        // Выполняет действия в зависимости от настроек:
        // создает новый файл или заменяет старый

        if (isset($newFilename) && is_string($newFilename)) {
            $img->save($newFilename);
        } else {
            $img->save($filename);
        }

        // TODO возвращает путь к файлу, примененные опции, тип файла
        //return $img->save($filename);
    }

    public function thumbnail($options)
    {

    }

    public function signature($options)
    {

    }
}
