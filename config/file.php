<?php

return [
    // TODO контроллеры, обработчики, маршруты, ограничения БД и т.п.
    'repository' => Belca\File\Repositories\FileRepositoryEloquent::class,

    // Components | Includes
    // TODO в системную тему
    'alerts_component' => 'belca-file::components.alerts',

    'list_component' => 'belca-file::components.list',

    'inside_thumbnail_component' => 'belca-file::components.inside-thumbnail',

    'thumbnail_image_component' => 'belca-file::components.thumbnail-image',

    'thumbnail_mime_component' => 'belca-file::components.thumbnail-mime',

    // Поддерживаемые типы миниатюр - файлы, которые могут отображаться в браузере
    'supported_thumbnails' => ['image/jpeg', 'image/png', 'image/svg'],


    // Контроллеры
    // TODO сделать статическими и часть контроллеров должны быть расширяемые
    // Либо весь пакет можно заменить
    'index_method' => '\Belca\File\Http\Controllers\FileController@index',

    'create_method' => '\Belca\File\Http\Controllers\FileController@create',

    'store_method' => '\Belca\File\Http\Controllers\FileController@store',

    'edit_method' => '\Belca\File\Http\Controllers\FileController@edit',

    'update_method' => '\Belca\File\Http\Controllers\FileController@update',

    'show_method' => '\Belca\File\Http\Controllers\FileController@show',

    'delete_method' => '\Belca\File\Http\Controllers\FileController@delete',

    'destroy_method' => '\Belca\File\Http\Controllers\FileController@destroy',

    // URL Prefix
    'url_prefix_download' => 'download',

    // Middlewares
    // Посредники скачивания файлов
    'download_middleware' => ['web'],

    // Посредники управления файлами: веб, авторизованные, роли и определенные пользователи
    'middlewares' => ['web', 'auth' /*, 'roles:root,admin', 'users:dios'*/],


    // Правило генерации имени для загружаемого файла
    'filename_pattern' => '{mime<value:group>}/{date<format:Y-m-d>}/{string<length:25>}.{extension}',

    // Ограничения по загрузке файлов
    'allowed_file_types' => [],

    'max_filesize' => 99999999,

    // Ограничения по slug (исключения)

    // Подтверждение удаления файла и модификаций
    'confirm_file_deletion' => true,
];
