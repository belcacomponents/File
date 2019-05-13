<?php

namespace Belca\File\Http\Controllers;

use Belca\File\Contracts\FileRepository;
use Belca\File\Contracts\FileController as FileControllerInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Belca\File\Http\Requests\FileRequest;
use Belca\Support\Config;
use Belca\FileHandler\FileHandler;
use Belca\GeName\GeName;

/**
 * Базовая загрузка файлов и управление ими.
 */
class FileController implements FileControllerInterface
{
    /**
     * Массив отношений между названиями представлений (индексов) и их индексом
     * в конфигурации (путь к шаблону в конфигурации).
     *
     * @var array
     */
    protected $viewConfig = [
        'index' => 'file.index_view',
        'create' => 'file.create_view',
        'show' => 'file.show_view',
        'edit' => 'file.edit_view',
        'delete' => 'file.delete_view',
    ];

    /**
     * Соотношение имен представлений и их шаблонами.
     *
     * @var array
     */
    protected $views = [];

    /**
     * Массив отношений между названиями редиректов (названия методов вызывающих
     * ридеректы) и их индексом в конфигурации (имя маршрута в конфигурации).
     *
     * @var array
     */
    protected $redirectConfig = [
        'store' => 'file.store_redirect',
        'store_error' => 'file.store_error_redirect',
        'update' => 'file.update_redirect',
        'update_error' => 'file.update_redirect',
        'destory' => 'file.destory_redirect',
    ];

    /**
     * Соотношение имен методов и их редиректами.
     *
     * @var array
     */
    protected $redirects = [];

    protected $disk = 'public';

    protected $filenamePattern;

    public function __construct(FileRepository $files)
    {
        $this->files = $files;

        $this->views = Config::getConfigArrayByConfigKeys($this->viewConfig);

        $this->redirects = Config::getConfigArrayByConfigKeys($this->redirectConfig);

        $this->filenamePattern = config('file.filename_pattern');
    }

    /**
     * Отображает страницу с файлами и форму для фильтрации результата
     *
     * @param  mixed $request Условия фильтрации
     * @return View
     */
    public function index(Request $request)
    {
        // TODO Должна быть сортировка, фильтрация, поиск по названю, поиск по другим критериям
        // По умолчанию сортировка latest
        $files = $this->files->filter($request->input())/*->sort($request->input())*/->latest()->paginate(20);

        return view($this->views['index'] ?? 'belca-file::index', compact('files'));
    }

    /**
     * Отображает форму загрузки нового файла.
     *
     * @return View
     */
    public function create()
    {
        return view($this->views['create'] ?? 'belca-file::create');
    }

    /**
     * Сохраняет файл на сервере.
     *
     * Вызывает обработку файла и сохраняет информацию
     * в БД. Если при обработке файла были получены модификации или изменена
     * информация об оригинальном файле, то эти данные также вносятся в БД.
     * После сохранения информации вызывается перенаправление на другую страницу
     * и передается статус о действии.
     *
     * @param  FileRequest   $request    Данные формы и загружаемый файл
     * @return Illuminate\Http\RedirectResponse
     */
    public function store(FileRequest $request)
    {
        $fileinfo = [
            'filename' => $request->file('file')->getClientOriginalName(),
            'title' => pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME),
            'mime' => $request->file('file')->getMimeType(),
            'extension' => $request->file('file')->clientExtension() ?? pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_EXTENSION),
        ];

        // TODO: Директорию (диск) для сохранения можно будет выбирать при загрузке файла из конфигурации filesystems
        $disk = $this->disk;
        $directory = Storage::disk($disk)->getAdapter()->getPathPrefix();

        // Генерируем новое имя файла
        $gename = new GeName();
        $gename->setPattern($this->filenamePattern);
        $gename->setInitialData([
            'mime' => $fileinfo['mime'],
            'extension' => $fileinfo['extension'],
            'filename' => $fileinfo['filename'],
        ]);
        $gename->setDirectory($directory);
        $filename = $gename->generateName();

        // Конфигурация хранится в настройках config/filehandler.php
        $fileHandler = new FileHandler(config('filehandler.handlers'), config('filehandler.rules'), config('filehandler.scripts'));
        $fileHandler->setOriginalFile($request->file('file')->getPathName(), $fileinfo);
        $fileHandler->setDirectory($directory);
        $fileHandler->setHandlingScriptByScriptName('user-device');

        // Если файл не сохранен - вернет false и вызовем переадресацию
        // с отображением ошибки на экране.
        if (! $fileHandler->save($filename)) {
            return redirect()->route($this->redirects['store_error'])->with(['status' => 'notSaved', 'file' => $fileinfo]);
        }

        // Со страницы формы может быть передан измененный вариант обработки скрипта
        // Конфигурация задается из файла config/filehandler.php и настройки
        // задаются вручную. Каждый ключ массива соответствует пакету обработки.
        // Настройки обработки файлов переопределяются или задаются с формы
        // в виде массива с именем handler_parameters.<package>.*, где
        // package - название пакета, принимаемое и обрабатываемое
        // в методе handle.
        $fileHandler->handle($request->input('handler_parameters'));

        // Получаем информацию об оригинальном файле и сохраняем ее в БД.
        $basicFileinfo = $fileHandler->getBasicFileProperties();
        $additionalFileinfo = $fileHandler->getAdditionalFileProperties();
        $files = $fileHandler->getFilePaths();
        $basicPropertiesModifications = $fileHandler->getBasicProperties();
        $additinalPropertiesModifications = $fileHandler->getAdditionalProperties();

        // Информация для таблицы файлов
        $systemInfo = [
            'disk' => $disk,
            'author_id' => 1,
            'path' => $filename,
        ];

        $file = $this->files->createWithGuardedFields(array_merge($request->input(), $fileinfo, $systemInfo, $basicFileinfo, ['options' => $additionalFileinfo]));

        if (isset($files) && is_array($files)) {
            $this->files->createModifications($file->id, $files);
        }

        return redirect()->route($this->redirects['store'], $file->id)->with(['status' => 'saved', 'file' => $file]);
    }

    /**
     * Отображает страницу с файлом для загрузки или отображения, также
     * содержит сведения о модификациях.
     *
     * @param  integer $id ID файла
     * @return View
     */
    public function show($id)
    {
        $file = $this->files->findWithModifications($id);

        return view($this->views['show'] ?? 'belca-file::show', compact('file'));
    }

    /**
     * Отображает форму редактирования данных файла.
     *
     * @param  integer $id ID файла
     * @return View
     */
    public function edit($id)
    {
        $file = $this->files->find($id);

        return view($this->views['edit'] ?? 'belca-file::edit', compact('file'));
    }

    /**
     * Обновляет информацию о файле.
     * После обновления информации выполняется перенаправление на другую страницу
     * с возвратом статуса о действии.
     *
     * @param  FileRequest $request Данные формы
     * @param  integer      $id     ID файла
     * @return Illuminate\Http\RedirectResponse
     */
    public function update(FileRequest $request, $id)
    {
        $file = $this->files->update($request->input(), $id);

        return redirect()->route($this->redirects['update'], compact('file'))->with('status', 'updated');
    }

    /**
     * Отображает страницу с данными о файле: связи, зависимости и т.п.
     * Содержит форму удаления файла.
     *
     * @param  integer $id ID файла
     * @return View
     */
    public function delete($id)
    {
        $file = $this->files->findWithModifications($id);

        return view($this->views['delete'] ?? 'belca-file::delete', compact('file'));
    }

    /**
     * Удаляет файл, удаляет модификации, вызывает дополнительную обработку
     * данных, например, удаление связей и удаляет данные из БД.
     * После завершения удаления файлов перенаправляет на другую страницу
     * и возвращает статус удаления.
     *
     * @param  FileRequest $request Данные формы
     * @param  integer $id          ID файла
     * @return Illuminate\Http\RedirectResponse
     */
    public function destroy(FileRequest $request, $id)
    {
        // Изменение состояний связанных объектов - отдельный класс
        // Удаление файлов - отдельный класс
        // Можно удаление пустых папок - в предыдущем

        $file = $this->files->find($id)->toArray();

        $this->files->delete($id); // TODO удаление связанных данных

        return redirect()->route($this->redirects['destroy'], compact('file'))->with('status', 'deleted');
    }
}
