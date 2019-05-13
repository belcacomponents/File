<?php
Route::name('files.')->group(function () {
    // По умолчанию, доступ через посредника 'web' или всем
    Route::middleware(config('file.download_middleware') ?? [])->get((config('file.url_prefix_download') ?? 'download').'/{slug}', config('file.download_method') ?? '\Belca\File\Http\Controllers\DownloadController')->name('download');

    // По умолчанию, доступ только для администраторов (root, admin) или посредника 'web'
    Route::middleware(config('file.file_management_middleware') ?? ['web'])->group(function () {
        Route::get('system/files', config('file.index_method') ?? '\Belca\File\Http\Controllers\FileController@index')->name('index');
        Route::get('system/files/create', config('file.create_method') ?? '\Belca\File\Http\Controllers\FileController@create')->name('create');
        Route::post('system/files/create', config('file.store_method') ?? '\Belca\File\Http\Controllers\FileController@store')->name('store');
        Route::get('system/files/{file}', config('file.edit_method') ?? '\Belca\File\Http\Controllers\FileController@edit')->name('edit');
        Route::put('system/files/{file}', config('file.update_method') ?? '\Belca\File\Http\Controllers\FileController@update')->name('update');
        Route::get('system/files/{file}/show', config('file.show_method') ?? '\Belca\File\Http\Controllers\FileController@show')->name('show');
        Route::get('system/files/{file}/delete', config('file.delete_method') ?? '\Belca\File\Http\Controllers\FileController@delete')->name('delete');
        Route::delete('system/files/{file}', config('file.destroy_method') ?? '\Belca\File\Http\Controllers\FileController@destroy')->name('destroy');
    });
});
