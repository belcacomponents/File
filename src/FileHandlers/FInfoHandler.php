<?php

namespace Belca\File\FileHandlers;

use Belca\FInfo\Fileinfo;
use Belca\FileHandler\FileHandlerAdapterAbstract;

/**
 * Обработчик извлекающий информацию о файле.
 */
class FInfoHandler extends FileHandlerAdapterAbstract
{
    /**
     * Возвращает тип обработчика: порождающий, извлекающий или модифицирующий.
     *
     * @var string
     */
    public static getHandlerType()
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
        // TODO в конструкторе должна пройти инициализация обрабатываемых классов
        // Здесь должен произойти только вызов и обработка, сохранение ответа и возврат
        Fileinfo::file($this->file);

        // в инфо должна быть возвращена информация

    }
}
