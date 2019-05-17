<?php

namespace Belca\File\Http\Controllers;

use Belca\File\Contracts\FileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Belca\FileHandler\FileHandler;
use Belca\GeName\GeName;

/**
 * Управление модификациями файлов.
 */
class ModificationController //extends AnotherClass
{
    /**
     * Массив отношений между названиями представлений (индексов) и их индексом
     * в конфигурации (путь к шаблону в конфигурации).
     *
     * @var array
     */
    protected $viewConfig = [
        /*'index' => 'file.index_view',
        'create' => 'file.create_view',
        'show' => 'file.show_view',
        'edit' => 'file.edit_view',
        'delete' => 'file.delete_view',*/
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
        /*'store' => 'file.store_redirect',
        'store_error' => 'file.store_error_redirect',
        'update' => 'file.update_redirect',
        'update_error' => 'file.update_redirect',
        'destory' => 'file.destory_redirect',*/
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

        /*$this->views = Config::getConfigArrayByConfigKeys($this->viewConfig);

        $this->redirects = Config::getConfigArrayByConfigKeys($this->redirectConfig);*/

        $this->filenamePattern = config('file.filename_pattern');
    }

    public function index(Request $request, $id = null)
    {
        if (empty($id)) {
            $files = $this->files->filter($request->input())/*->sort($request->input())*/->latest()->paginate(20);
        } else {
            // Или загружает файлы принадлежащие одной модификации
            $files = $this->files->find($id);
            //$files = $this->files->
        }


        // Или отображает сгрупированный список модификаций
        // TODO значек "открыть модификации можно вынести на основную форму"
        // Нажимая на который будет отображены файлы модификаций и оригинал.

        return view($this->views['index'] ?? 'belca-file::modifications.index', compact('files'));
    }

    // TODO мы тут сразу можем сделать метод загрузки модификации или добавить настройки к какому-нибудь из них
    // чтобы загрузать модификации изображения напрямую или заменять их
    // просматривать список модификаций, редактировать их данные
    // изменять назначения модификаций
    // короче все вручную, а доп пакетом расширить

    /**
     * Отображает страницу загрузки модификации файла.
     *
     * @param  integer $id ID оригинального файла
     * @return View
     */
    public function create($id)
    {
        $file = $this->files->original()->find($id);

        if (empty($file)) {
            dd('Указанный файл не найден или не является оригинальным');
        }

        return view($this->views['create'] ?? 'belca-file::modifications.create', compact('file'));

        // Страница создания модификации
        // Содержит путь или ссылку на оригинальный файл
        // Описание модификации на основе оригинала
        //
        // Данные о файле (тип модификации или возможные типы. Для каждого файла
        // оригинала будут свои типы модификации, хоть они могут совпадать) - передается через composer
        // Берется из настроек или какого-то класса. С бибилотекой генерации должна оттуда загружаться.
        // Возможно должен быть какой-то интерфейс для загрузки списка модификаций на основе типа или тп.
        // У списка модификаций должны быть переводы
    }

    public function store(Request $request, $id)
    {
        $fileinfo = [
            'filename' => $request->file('file')->getClientOriginalName(),
            'title' => pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME),
            'mime' => $request->file('file')->getMimeType(),
            'extension' => $request->file('file')->clientExtension() ?? pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_EXTENSION),
        ];

        $disk = $this->disk;
        $directory = Storage::disk($disk)->getAdapter()->getPathPrefix();

        $gename = new GeName();
        $gename->setPattern($this->filenamePattern);
        $gename->setInitialData([
            'mime' => $fileinfo['mime'],
            'extension' => $fileinfo['extension'],
            'filename' => $fileinfo['filename'],
        ]);
        $gename->setDirectory($directory);
        $filename = $gename->generateName();

        // TODO здесь либо отдельный обработчик, либо отдельные настройки
        $fileHandler = new FileHandler(config('filehandler.handlers'), config('filehandler.rules'));
        $fileHandler->setOriginalFile($request->file('file')->getPathName(), $fileinfo);
        $fileHandler->setDirectory($directory);

        if (! $fileHandler->save($filename)) {
            return redirect()->route($this->redirects['store_error'])->with(['status' => 'notSaved', 'file' => $fileinfo]);
        }

        $basicFileinfo = $fileHandler->getBasicFileProperties();
        $additionalFileinfo = $fileHandler->getAdditionalFileProperties();

        $systemInfo = [
            'disk' => $disk,
            'author_id' => 1,
            'path' => $filename,
            'parent_id' => $id,
        ];

        $file = $this->files->createWithGuardedFields(array_merge($request->input(), $fileinfo, $systemInfo, $basicFileinfo, ['options' => $additionalFileinfo]));

        return redirect()->route($this->redirects['store'], $file->id)->with(['status' => 'saved', 'file' => $file]);
    }

    /**
     * Отображает страницу редактирования модификации файла.
     *
     * Страница содержит информацию только о модификации. Отсюда можно
     * открыть страницу загрузки замены файла.
     *
     * @param  integer $id
     * @return
     */
    public function edit($id)
    {
        $file = $this->files->find($id);

        return view($this->views['edit'] ?? 'belca-file::modifications.edit', compact('file'));
    }

    /**
     * Обновляет данные модификации.
     *
     * @param  FileRequest $request Данные формы
     * @param  integer     $id      ID файла
     * @return Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $file = $this->files->update($request->input(), $id);

        return redirect()->route($this->redirects['update'], compact('file'))->with('status', 'updated');
    }

    public function replace($id)
    {
        // страница загрузки нового файла модификации (заменяет файл)
    }

    public function overwrite(Request $request, $id)
    {
        // Заменяет файл удаляя или перезаписывая старый файл
        // В зависимости от настроек выполняется обработка или нет. По умолчанию нет
    }

    public function delete($id)
    {
        // Открывает страницу удаления модификации
    }

    /**
     * Удаляет указанный файл (модификацию).
     *
     * @param  Request $request
     * @param  integer $id      
     * @return Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $file = $this->files->find($id);

        if (empty($file)) {
            return redirect()->route($this->redirects['destroy_error'])->with(['alert' => ['status' => 'noFile', 'id' => $id]]);
        }

        Storage::disk($file->disk)->delete($file->path);
        $file->delete();

        return redirect()->route($this->redirects['destroy'])->with(['alert' => ['status' => 'deleted', 'file' => $file]]);
    }
}
