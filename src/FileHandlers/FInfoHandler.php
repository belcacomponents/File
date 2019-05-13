<?php

namespace Belca\File\FileHandlers;

use Belca\FInfo\Fileinfo;
use Belca\FileHandler\FileHandlerAdapterAbstract;

/**
 * Обработчик извлекающий информацию о файле.
 */
class FInfoHandler extends FileHandlerAdapterAbstract
{
    public function __construct($rules = null, $scripts = null)
    {
        if (! empty($rules['handlers'])) {
            foreach ($rules['handlers'] as $key => $className) {
                Fileinfo::addClass($className);
            }
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
        // Если не указаны возвращаемые поля, то вернуть все поля, если иное не определено в настройках.
        $this->info = Fileinfo::file($this->getFile());
    }
}
