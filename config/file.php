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

    // Редиректы при совершении действий (имена маршрутов)
    'store_redirect' => 'files.edit',

    'update_redirect' => 'files.edit',

    'destory_redirect' => 'files.index',

    'modification_store_redirect' => 'files.modifications.edit',

    'modification_update_redirect' => 'files.modifications.update',

    'modification_destroy_redirect' => 'files.modifications.destroy',

    'modification_overwrite_redirect' => 'files.modifications.overwrite',

    // Контроллеры
    'edit_' => ''

];
