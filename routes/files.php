<?php

Route::middleware('web')->name('file_tools.')->group(function () {

  // По умолчанию, доступ через посредника 'web' или всем
  Route::middleware(config('file.download_middleware') ?? [])
       ->get((config('file.url_prefix_download') ?? 'download').'/{slug}', config('file.download_method') ?? '\Belca\File\Http\Controllers\DownloadController')
       ->name('download');

  Route::prefix('system/file-tools')->group(function () {

      Route::get('/', function () {
          return redirect()->route('file_tools.files.index');
      });

      // По умолчанию, доступ только для администраторов (root, admin) или посредника 'web'
      Route::middleware(config('file.file_management_middleware') ?? ['web'])->group(function () {

          // Маршруты для управления модификациями
          Route::prefix('system/files/modifications')->name('mods.')->group(function () {
              Route::get('/{id?}', config('file.modification_index_method') ?? '\Belca\File\Http\Controllers\ModificationController@index')->name('index');
              Route::get('create/{id}', config('file.modification_create_method') ?? '\Belca\File\Http\Controllers\ModificationController@create')->name('create');
              Route::post('create/{id}', config('file.modification_store_method') ?? '\Belca\File\Http\Controllers\ModificationController@store')->name('store');
              Route::get('edit/{file}', config('file.modification_edit_method') ?? '\Belca\File\Http\Controllers\ModificationController@edit')->name('edit');
              Route::put('edit/{file}', config('file.modification_update_method') ?? '\Belca\File\Http\Controllers\ModificationController@update')->name('update');
              Route::get('replace/{file}', config('file.modification_replace_method') ?? '\Belca\File\Http\Controllers\ModificationController@replace')->name('replace');
              Route::patch('replace/{file}', config('file.modification_overwrite_method') ?? '\Belca\File\Http\Controllers\ModificationController@overwrite')->name('overwrite');
              Route::delete('{file}', config('file.modification_destroy_method') ?? '\Belca\File\Http\Controllers\ModificationController@destroy')->name('destroy');
          });

          // Маршруты для управления основными файлами
          Route::prefix('system/files')->name('files.')->group(function () {
              Route::get('/', config('file.index_method') ?? '\Belca\File\Http\Controllers\FileController@index')->name('index');
              Route::get('create', config('file.create_method') ?? '\Belca\File\Http\Controllers\FileController@create')->name('create');
              Route::post('create', config('file.store_method') ?? '\Belca\File\Http\Controllers\FileController@store')->name('store');
              Route::get('{file}', config('file.edit_method') ?? '\Belca\File\Http\Controllers\FileController@edit')->name('edit');
              Route::put('{file}', config('file.update_method') ?? '\Belca\File\Http\Controllers\FileController@update')->name('update');
              Route::get('{file}/show', config('file.show_method') ?? '\Belca\File\Http\Controllers\FileController@show')->name('show');
              Route::delete('{file}', config('file.destroy_method') ?? '\Belca\File\Http\Controllers\FileController@destroy')->name('destroy');
          });

          Route::apiResource('system/files-api', '\Belca\File\Http\Controllers\API\FileController');
      });
  });
});
