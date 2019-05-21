<?php

namespace Belca\File\FileHandlers;

use Belca\FGen\FGen;
use Belca\FileHandler\FileHandlerAdapterAbstract;

/**
 * Обработчик извлекающий информацию о файле.
 */
class FGenHandler extends FileHandlerAdapterAbstract
{
    protected $instance;

    public function __construct($rules = null, $scripts = null)
    {
        $this->instance = new \Belca\FGen\FGen;

        if (! empty($rules['handlers'])) {
            $this->instance->addHandlers($rules['handlers']);
        }

        if (! empty($rules['rules'])) {
            $this->instance->addRules($rules['rules']);
        }

        if (! empty($rules['relations'])) {
            $this->instance->addRelations($rules['relations']);
        }
    }

    public static function mergeRules($method, ...$rules)
    {

    }

    /**
     * Объединяет переданные скрипты указанным методом слияния и возвращает их.
     *
     * @param  string $method
     * @param  mixed  $scripts
     * @return mixed
     */
    public static function mergeScripts($method, ...$scripts)
    {

    }

    /**
     * Возвращает тип обработчика: порождающий, извлекающий или модифицирующий.
     *
     * @var string
     */
    public static function getHandlerType()
    {
        return self::EXTRACTING;
    }

    /**
     * Запускает обработку файла по указанному сценарию. В случае ошибки,
     * при обработке файла, вернет false.
     *
     * @param  string $script
     * @return boolean
     */
    public function handle($script = null)
    {
        dd($this->instance->file($this->getFile()));
        // TODO должен генерировать значения в зависимости от типа загрузки
        // должен генерировать значения с разными размерами
        // должен генерировать миниатры
        // должен генерировать файлы с водяными знаками
        //$this->info = Fileinfo::file($this->getFile());
    }
}
