<?php

namespace Dios\System\File;

use Belca\Support\AbstractEnum;

/**
 * Sources of uploaded files.
 *
 * Используются для выбора обработки файлов или способов хранения данных.
 */
class FileSource extends AbstractEnum
{
    const DEFAULT = self::USER_DEVICE;

    /**
     * User device.
     *
     * К пользовательскому устройству относятся компьютеры, смартфоны, планшеты
     * и другие стационарные или мобильные устройства, которыми владеет
     * один или несколько пользователей.
     */
    const USER_DEVICE = 'user-device';
}
