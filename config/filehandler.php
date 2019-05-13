<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Правила обработки файлов
    |--------------------------------------------------------------------------
    |
    | Правила обработки файлов передаются в адаптер обработчика и могут
    | содержать любые данные, в т.ч. список классов, если это необходимо
    | для используемого обработчика.
    | Правила обработки файлов указываются по правилу "имя обработчика" =>
    | "массив правил".
    |
    */

    'rules' => [
        // 'handlerName' => 'rules',

        // Настройки пакета FGen
        'fgen' => [
            'rules' => [],
            'scripts' => [],
        ],

        'finfo' => [
            'handlers' => [
                'basic' => \Belca\FInfo\BasicFileinfo::class,
            ]
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Сценарии обработки файлов
    |--------------------------------------------------------------------------
    |
    | Сценарии обработки файлов содержат набор исходный правил или имена
    | запускаемых обработчиков и их методов. В частности, это зависит от
    | реализации адаптера обработчика файла.
    |
    | Сценарии обработки файлов указываются по правилу:
    | "название сценария" => [
    |
    |      // Список имен обработчиков в порядке их выполнения
    |     'sequence' => ['имя_обработчика'],
    |
    |     // Имена основных свойств файла
    |     'properties' => ['имя_обработчика.название_ключа_в_массиве'],
    |
    |     // Обработчики и их сценарии/параметры
    |     'handlers' => [
    |         'имя_обработчика' => ['инструкции'],
    |     ],
    | ]
    |
    | Выполняемый сценарий обработки файла может быть переопределен в
    | контроллере, если это реализовано в адаптере обработчика файла.
    | Сценарии обработки не обязательны для обработчиков, если это предусмотрено
    | адаптером обработчика файла.
    |
    */

    'scripts' => [

        // Запускается при загрузке файлов с устройства пользователя (ПК, смартфон, планшет)
        'user-device' => [

            // Порядок выполнения обработчиков
            'sequence' => ['fgen', 'finfo'],

            // Основные свойства файла
            'properties' => ['finfo.mime', 'finfo.size', 'finfo.created' => 'created_at'],

            // Выполняемые обработчики и их настройки
            'handlers' => [

                'finfo' => [
                     // TODO список извлекаемых свойств
                ],

                'fgen' => [
                    // Сжать файл
                ]
            ],
            // Обработчики, которые вернут файлы для последующей обработки
            // Или обработчики, принимающие значения указанных обработчиков
            // или конкретных модификаций
            // Или обрабатывать все сгенерированные файлы
            // Или применить дополнительную модифицирующую или извлекающие обработки
            // для сгенерированных файлоы
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Обработчики файлов
    |--------------------------------------------------------------------------
    |
    | Каждый обработчик файла должен реализовывать методы интерфейса адаптера
    | Belca\FileHandler\Contracts\FileHandlerAdapter.
    | Обработчик файла указывается по правилу "имя обработчика" =>
    | "класс обработчика".
    |
    */
    'handlers' => [
        // 'handlerName' => 'className',

        'finfo' => \Belca\File\FileHandlers\FInfoHandler::class,
    ],
];