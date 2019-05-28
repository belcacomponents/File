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
     * Возвращает тип обработчика: порождающий.
     *
     * @var string
     */
    public static function getHandlerType()
    {
        return self::GENERATING;
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
        $this->instance->setDirectory($this->getDirectory());
        // TODO должен генерировать значения в зависимости от типа загрузки
        // и измененных правил обработки/скриптов
        $rawData = $this->instance->file($this->getFilename());

        // Полученный массив приводится к виду для обработки в контроллере
        // FileController и последующего сохранения в БД.
        // Результатом обработки будут модификации файла.
        // По правилам возврата такого метода обработки должен стать массив,
        // где ключи - имена файлов, а значения - данные полученные во время
        // обработки.
        if (is_array($rawData) && is_string(key($rawData))) {
            $driver = key($rawData);
            $rawData = current($rawData);
            $result = [];

            if ($rawData) {
                foreach ($rawData as $handler => $handlingModes) {
                    foreach ($handlingModes as $mode => $handlingData) {
                        $result[$handlingData['relative_filename']] = array_merge([
                            'driver' => $driver,
                            'handler' => $handler,
                            'handler_mode' => $mode,
                        ], $handlingData ?: []);
                    }
                }
            }
        }

        $this->info = $result ?? [];
    }
}
