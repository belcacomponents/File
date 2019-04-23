<?php

namespace Belca\File\Contracts;

use Belca\File\Http\Requests\FileRequest;
use Illuminate\Http\Request;

/**
 * Базовая загрузка файлов и управление ими.
 */
interface FileController
{
    public function index(Request $request);

    public function create();

    public function store(FileRequest $request);

    public function show($id);

    public function edit($id);

    public function update(FileRequest $request, $id);

    public function delete($id);

    public function destroy(FileRequest $request, $id);
}
