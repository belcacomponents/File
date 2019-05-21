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
        // Simple:
        // 'handlerName' => 'rules',

        // Настройки пакета FGen
        'fgen' => [
            'drivers' => [],
            'handlers' => [
                'image/jpeg' => \Belca\File\FGenHandlers\SimpleImageHandler::class,
            ],
            'relations' => [
                'image/jpeg' => ['image/jpeg', 'image/pjpeg'],
            ],
            'inspectors' => [
                //'driver' => 'class',
            ],
            'scripts' => [
                'user-device' => [
                    //'allow' => [
                        'jpg' => [
                            'original',
                            'thumbnail',
                            'resize' => ['tiny', 'small', 'normal'],
                            'signature',
                        ],
                        'png',
                        'pdf' => [
                            'thumbnail',
                            'preview',
                        ],
                        'mp3' => [
                            'thumbnail'
                        ]
                    //]
                ],
                'manual' => [
                    //'disallow' => '*'
                ],
            ],
            'rules' => [
                'jpg' => [
                    'original' => [
                        'changed' => [
                            '_method' => 'resize',
                            'width' => 1400,
                            'height' => null,
                            'crop' => false,
                            'compression' => 90,
                            //'filename' => '/jpg/',
                        ]
                    ],
                    'resize' => [
                        'tiny' => [
                            'width' => 400,
                            'height' => null,
                            'crop' => false,
                            'compression' => 85,
                        ],
                        'small' => [
                            'width' => 600,
                            'height' => null,
                            'crop' => false,
                            'compression' => 85,
                        ],
                        'normal' => [
                            'width' => 1200,
                            'height' => null,
                            'crop' => false,
                            'compression' => 90,
                        ],
                    ],
                    'thumbnail' => [
                        'tiny' => [
                            'width' => 200,
                            'height' => 150,
                            'crop' => true,
                            'compression' => 75,
                        ],
                        'small' => [
                            'width' => 400,
                            'height' => 300,
                            'crop' => true,
                            'compression' => 80,
                        ],
                    ],
                    'signature' => [
                        'small' => [
                            // Логика действий
                            'signature_filename' => '/images/signature_black.png',
                            'position' => 'bottom-right',
                            'signature_size' => 150,
                            'offset' => 10,
                            'width' => 600,
                            'height' => null,
                            'crop' => false,
                            'compression' => 85,
                        ],
                        'normal' => [
                            'signature_filename' => '/images/signature_black.png',
                            'position' => 'bottom-right',
                            'signature_size' => '30%',
                            'offset' => '2.5%',
                            'width' => 1200,
                            'height' => null,
                            'crop' => false,
                            'compression' => 90,
                        ],
                    ],
                ],
                'png' => [
                    'thumbnail' => [
                        'tiny' => [
                            'width' => 200,
                            'height' => 150,
                            'crop' => true,
                            'compression' => 75,
                        ],
                    ],
                    'resize' => [
                        'tiny' => [
                            'width' => 400,
                            'height' => null,
                            'crop' => false,
                            'compression' => 85,
                        ],
                        'small' => [
                            'width' => 600,
                            'height' => null,
                            'crop' => false,
                            'compression' => 85,
                        ],
                        'normal' => [
                            'width' => 1200,
                            'height' => null,
                            'crop' => false,
                            'compression' => 90,
                        ],
                    ],
                    'signature' => [
                        'small' => [
                            // Логика действий
                            'signature_filename' => '/images/signature_black.png',
                            'position' => 'bottom-right',
                            'signature_size' => 150,
                            'offset' => 10,
                            'width' => 600,
                            'height' => null,
                            'crop' => false,
                            'compression' => 85,
                        ],
                        'normal' => [
                            'signature_filename' => '/images/signature_black.png',
                            'position' => 'bottom-right',
                            'signature_size' => '30%',
                            'offset' => '2.5%',
                            'width' => 1200,
                            'height' => null,
                            'crop' => false,
                            'compression' => 90,
                        ],
                    ],
                ],
                'pdf' => [
                    'thumbnail' => [
                        'tiny' => [
                            'width' => 200,
                            'height' => 150,
                            'crop' => true,
                            'compression' => 75,
                        ],
                    ],
                    'preview' => [
                        'small' => [
                            'width' => 300,
                            'height' => null,
                            'crop' => false,
                            'compression' => 80,
                        ],
                        'normal' => [
                            'width' => 600,
                            'height' => null,
                            'crop' => false,
                            'compression' => 85,
                        ],
                    ]
                ],
            ],
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
                    // Сделать миниатюру
                    // Поставить водяной знак
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
        'fgen' => \Belca\File\FileHandlers\FGenHandler::class,
    ],
];
