<?php

return [
    // TODO контроллеры, обработчики, маршруты, ограничения БД и т.п.
    'repository' => Belca\File\Repositories\FileRepositoryEloquent::class,

    // Представления
    'index_view' => 'belca-file::index',

    'create_view' => 'belca-file::create',

    'edit_view' => 'belca-file::edit',

    'show_view' => 'belca-file::show',

    'delete_view' => 'belca-file::delete',

    'modification_index_view' => 'belca-file::modification.index',

    'modification_create_view' => 'belca-file::modification.create',

    'modification_replace_view' => 'belca-file::modification.replace',

    'modification_edit_view' => 'belca-file::modification.edit',

    'modification_delete_view' => 'belca-file::modification.delete',

    'modification_show_view' => 'belca-file::modification.show',

    // Components | Includes

    'list_component' => 'belca-file::components.list',

    'inside_thumbnail_component' => 'belca-file::components.inside-thumbnail',

    'thumbnail_image_component' => 'belca-file::components.thumbnail-image',

    'thumbnail_mime_component' => 'belca-file::components.thumbnail-mime',

    // Поддерживаемые типы миниатюр - файлы, которые могут отображаться в браузере
    'supported_thumbnails' => ['image/jpeg', 'image/png', 'image/svg'],

    // Редиректы при совершении действий (имена маршрутов)
    'store_redirect' => 'files.edit',

    // Переадресация при ошибке
    'store_error_redirect' => 'files.store',

    'update_redirect' => 'files.edit',

    'destory_redirect' => 'files.index',

    'modification_store_redirect' => 'files.modifications.edit',

    'modification_update_redirect' => 'files.modifications.update',

    'modification_destroy_redirect' => 'files.modifications.destroy',

    'modification_overwrite_redirect' => 'files.modifications.overwrite',

    // Контроллеры
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
    // Посредники загрузки файлов
    'download_middleware' => ['web'],

    // Посредники управления файлами: веб, авторизованные, роли и определенные пользователи
    'file_management_middleware' => ['web'/*, 'auth' , 'roles:root,admin', 'users:dios'*/],

    // Правило генерации имени для загружаемого файла
    'filename_pattern' => '{mime<value:group>}/{date<format:Y-m-d>}/{string<length:25>}.{extension}',

    // Ограничения по загрузке файлов

    // Ограничения по slug (исключения)
];
