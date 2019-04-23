<?php

namespace Belca\File\Enum;

use Belca\Support\AbstractEnum;

/**
 * Источники загрузки файлов.
 *
 * Используются для выбора обработки файлов или способов хранения данных.
 */
class FileUploadSource extends AbstractEnum
{
    const DEFAULT = self::USER_DEVICE;

    /**
     * Пользовательское устройство.
     *
     * К пользовательскому устройству относятся компьютеры, смартфоны, планшеты
     * и другие стационарные или мобильные устройства, которыми владеет
     * один или несколько пользователей.
     */
    const USER_DEVICE = 'user-device';
}
