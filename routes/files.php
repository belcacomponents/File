<?php

Route::get('system/files', config('file.index_method') ?? '\Belca\File\Http\Controllers\FileController@index')->name('files.index');
Route::get('system/files/create', config('file.create_method') ?? '\Belca\File\Http\Controllers\FileController@create')->name('files.create');
Route::post('system/files/create', config('file.store_method') ?? '\Belca\File\Http\Controllers\FileController@store')->name('files.store');
Route::get('system/files/{file}', config('file.edit_method') ?? '\Belca\File\Http\Controllers\FileController@edit')->name('files.edit');
Route::put('system/files/{file}', config('file.update_method') ?? '\Belca\File\Http\Controllers\FileController@update')->name('files.update');
Route::get('system/files/{file}/show', config('file.show_method') ?? '\Belca\File\Http\Controllers\FileController@show')->name('files.show');
Route::get('system/files/{file}/delete', config('file.delete_method') ?? '\Belca\File\Http\Controllers\FileController@delete')->name('files.delete');
Route::delete('system/files/{file}', config('file.destroy_method') ?? '\Belca\File\Http\Controllers\FileController@destroy')->name('files.destroy');
