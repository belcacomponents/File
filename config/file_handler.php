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
                'image/jpeg' => \Dios\SimpleImageHandler\SimpleImageHandlerFGenModule::class,
                'image/png' => \Dios\SimpleImageHandler\SimpleImageHandlerFGenModule::class,
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
                        'image/jpeg' => [
                            'thumbnail',
                            'resize' => ['xxsmall', 'xsmall', 'small', 'medium', 'large'],
                            //'signature',
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
                'image/jpeg' => [
                    'resize' => [
                        // 'xxsmall' => [
                        //     'width' => 128,
                        //     'compression' => 80,
                        //     'reduce' => true,
                        //     'directory_prefix_pattern' => '{sourceDirectory}',
                        //     'directory_pattern' => 'image/resize/{date<format:Y-m-d>}',
                        //     'filename_pattern' => 'resize/{string<length:25>}_resize_xxsmall.{extension<default:jpg>}',
                        // ],
                        // 'xsmall' => [
                        //     'width' => 256,
                        //     'compression' => 90,
                        //     'reduce' => true,
                        //     'directory_prefix_pattern' => '{sourceDirectory}',
                        //     'directory_pattern' => 'image/resize/{date<format:Y-m-d>}',
                        //     'filename_pattern' => 'resize/{string<length:25>}_resize_xsmall.{extension<default:jpg>}',
                        // ],
                        'small' => [
                            'width' => 480,
                            'compression' => 90,
                            'reduce' => true,
                            'directory_prefix_pattern' => '{sourceDirectory}',
                            'directory_pattern' => 'image/resize/{date<format:Y-m-d>}',
                            'filename_pattern' => 'resize/{string<length:25>}_resize_small.{extension<default:jpg>}',
                        ],
                        'medium' => [
                            'width' => 720,
                            'compression' => 90,
                            'reduce' => true,
                            'directory_pattern' => 'image/resize/{date<format:Y-m-d>}',
                            'filename_pattern' => 'resize/{string<length:25>}_resize_medium.{extension<default:jpg>}',
                        ],
                        'large' => [
                            'width' => 1280,
                            'compression' => 90,
                            'reduce' => true,
                            'directory_pattern' => 'image/resize/{date<format:Y-m-d>}',
                            'filename_pattern' => 'resize/{string<length:25>}_resize_large.{extension<default:jpg>}',
                        ],
                    ],
                    'thumbnail' => [
                        'small' => [
                            'width' => 400,
                            'height' => 300,
                            'compression' => 75,
                            'directory_pattern' => 'image/thumbnail/{date<format:Y-m-d>}',
                            'filename_pattern' => 'thumbnail/{string<length:25>}_thumbnail_small.{extension<default:jpg>}',
                        ],
                        'xsmall' => [
                            'width' => 100,
                            'height' => 100,
                            'compression' => 75,
                            'directory_pattern' => 'image/thumbnail/{date<format:Y-m-d>}',
                            'filename_pattern' => 'thumbnail/{string<length:25>}_thumbnail_xsmall.{extension<default:jpg>}',
                        ],
                    ],
                    'signature' => [
                        // 'small' => [
                        //     'mark_filename' => public_path('/images/signature_black.png'),
                        //     'mark_position' => 'bottom-right',
                        //     'mark_size' => 175,
                        //     'mark_offset' => 10,
                        //     'width' => 600,
                        //     'compression' => 85,
                        //     'directory_pattern' => 'image/signature/{date<format:Y-m-d>}',
                        //     'filename_pattern' => 'signature/{string<length:25>}_signature_small.{extension<default:jpg>}',
                        // ],
                        'medium' => [
                            'mark_filename' => public_path('/images/signature_black.png'),
                            'mark_position' => 'bottom-right',
                            'mark_size' => '35%',
                            'mark_offset' => '2.5%',
                            'width' => 1200,
                            'compression' => 90,
                            'directory_pattern' => 'image/signature/{date<format:Y-m-d>}',
                            'filename_pattern' => 'signature/{string<length:25>}_signature_medium.{extension<default:jpg>}',
                        ],
                    ],
                ],
                'image/png' => [
                    'thumbnail' => [
                        'small' => [
                            'width' => 200,
                            'height' => 150,
                            'compression' => 75,
                            'directory_pattern' => 'image/thumbnail/{date<format:Y-m-d>}',
                            'filename_pattern' => '{string<length:25>}_thumbnail_small.{extension<default:png>}',
                        ],
                        // 'xsmall' => [
                        //     'width' => 100,
                        //     'height' => 100,
                        //     'compression' => 80,
                        //     'directory_pattern' => 'image/thumbnail/{date<format:Y-m-d>}',
                        //     'filename_pattern' => '{string<length:25>}_thumbnail_xsmall.{extension<default:png>}',
                        // ],
                    ],
                    'resize' => [
                        // 'xsmall' => [
                        //     'width' => 400,
                        //     'height' => null,
                        //     'crop' => false,
                        //     'compression' => 85,
                        //     'directory_pattern' => '/image/resize/{date<format:Y-m-d>}',
                        //     'filename_pattern' => '{string<length:25>}_resize_xsmall.{extension<default:png>}',
                        // ],
                        'small' => [
                            'width' => 600,
                            'height' => null,
                            'crop' => false,
                            'compression' => 85,
                            'directory_pattern' => '/image/resize/{date<format:Y-m-d>}',
                            'filename_pattern' => '{string<length:25>}_resize_small.{extension<default:png>}',
                        ],
                        'medium' => [
                            'width' => 1200,
                            'height' => null,
                            'crop' => false,
                            'compression' => 90,
                            'directory_pattern' => '/image/resize/{date<format:Y-m-d>}',
                            'filename_pattern' => '{string<length:25>}_resize_medium.{extension<default:png>}',
                        ],
                    ],
                    'signature' => [
                        // 'small' => [
                        //     // Логика действий
                        //     'signature_filename' => '/images/signature_black.png',
                        //     'position' => 'bottom-right',
                        //     'signature_size' => 150,
                        //     'offset' => 10,
                        //     'width' => 600,
                        //     'height' => null,
                        //     'crop' => false,
                        //     'compression' => 85,
                        //     'directory_pattern' => '/image/signature/{date<format:Y-m-d>}',
                        //     'filename_pattern' => '{string<length:25>}_signature_small.{extension<default:png>}',
                        // ],
                        'normal' => [
                            'signature_filename' => '/images/signature_black.png',
                            'position' => 'bottom-right',
                            'signature_size' => '30%',
                            'offset' => '2.5%',
                            'width' => 1200,
                            'height' => null,
                            'crop' => false,
                            'directory_pattern' => '/image/signature/{date<format:Y-m-d>}',
                            'filename_pattern' => '{string<length:25>}_signature_normal.{extension<default:png>}',
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

        'fgen_original' => [
            'rules' => [
                'image/jpeg' => [
                    // 'original' => [
                    //     'changed' => [
                    //         '_method' => 'resize',
                    //         'width' => 1920,
                    //         'compression' => 95,
                    //         'reduce' => true,
                    //     ]
                    // ],
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
            'properties' => [
                // FInfo
                'finfo.mime', 'finfo.size', 'finfo.created' => 'created_at',

                // FGen
                'fgen.size', 'fgen.mime', 'fgen.handler', 'fgen.handler_mode',
                'fgen.driver', 'fgen.extension',

                // FGenOriginal
                'fgen.size', 'fgen.mime', 'fgen.handler', 'fgen.handler_mode',
                'fgen.driver', 'fgen.extension',
            ],

            // Исключить свойства из сохраняемых свойств
            'exclude_properties' => [
                'fgen.fullname', 'fgen.final_directory', 'fgen.source_directory',
                'fgen.original_file',

                'fgen_original.fullname', 'fgen_original.final_directory',
                'fgen_original.source_directory', 'fgen_original.original_file',
            ],

            // Выполняемые обработчики и их настройки
            'handlers' => [

                'finfo' => [
                     // TODO список извлекаемых свойств
                ],

                'fgen' => [
                    // Сделать миниатюру
                    // Поставить водяной знак
                ],

                'fgen_original' => [
                    // Сжать файл
                ],
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
        // Заменяет оригинальный файл
        //'fgen_original' => \Belca\File\FileHandlers\FGenOriginalHandler::class,
    ],
];
