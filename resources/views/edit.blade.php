{{-- /resources/views/edit.blade.php --}}
{{-- Страница правки информации о файле --}}
{{-- TODO Должен иметь возможность расширения c помощью секций, компонентов и стеков --}}
@extends(config('systemtheme.app'))

@section('content')
  @component(config('systemtheme.workspace'))
    @component(config('systemtheme.heading'))
      Правка файла: {{ $file->title }}
    @endcomponent

    {{-- Form --}}
    @component(config('systemtheme.form'), ['crud' => 'put','attributes' => ['action' => route('files.update', $file->id)]])

      {{-- Control panel --}}
      @component(config('systemtheme.control-panel'))
        @component(config('systemtheme.button'), ['styleModifier' => 'primary', 'attributes' => ['type' => 'submit']])
          Сохранить
        @endcomponent

        @component(config('systemtheme.buttonlink'), ['attributes' => ['href' => route('files.show', $file->id), 'target' => '_blank']])
          Открыть файл
        @endcomponent

        @component(config('systemtheme.button'), ['styleModifier' => 'danger', 'attributes' => ['form' => 'deleteForm', 'type' => 'submit']])
          Удалить
        @endcomponent

        @component(config('systemtheme.buttonlink'), ['attributes' => ['href' => $back ?? route('files.index')]])
          Назад
        @endcomponent

        {{-- TODO рашсиряется / заменяется через section и внутренние элементы --}}
      @endcomponent

      {{-- Alert --}}
      @if (session('status') == 'updated')
        <div class="uk-alert-success" uk-alert>
          <a class="uk-alert-close" uk-close></a>
          <h3>Обновлено</h3>
          <p>Информация о файле успешно обновлена.</p>
        </div>
      @endif

      {{-- Groups --}}
      @component(config('systemtheme.groups'))

        {{-- Group - Main --}}
        @component(config('systemtheme.group'))
          @component(config('systemtheme.heading'), ['type' => 'h2'])
            Сведения о файле
          @endcomponent

          {{-- Input - Title --}}
          @component(config('systemtheme.inputfield'), ['attributes' => ['name' => 'title', 'value' => $file->title, 'placeholder' => 'Заголовок файла']])
            @slot('label')
              Заголовок файла
            @endslot
          @endcomponent

          {{-- TODO дополняется, например, категория, диск --}}

          {{-- Textarea - Description --}}
          @component(config('systemtheme.textareafield'), ['attributes' => ['name' => 'description', 'placeholder' => 'Описание файла']])
            @slot('label')
              Описание файла
            @endslot

            {{ $file->description ?? '' }}
          @endcomponent
        @endcomponent

        {{-- Group - Published --}}
        @component(config('systemtheme.group'))
          @component(config('systemtheme.heading'), ['type' => 'h2'])
            Публикация файла
          @endcomponent

          @component(config('systemtheme.description'))
            <p>
              Загружаемые файлы можно скачать без публикации. Но каждому
              загружаемому файлу присваивается уникальное труднозапоминаемое имя.
            </p>
            <p>
              Опубликованный файл можно скачать по уникальной ссылке, которую
              можно запонить. На разные файлы можно указать одинаковую ссылку, но
              доступна для скачивания будет только одна.
            </p>
          @endcomponent

          @component(config('systemtheme.checkboxfield'), ['attributes' => ['name' => 'published', 'checked' => $file->published ?? false]])
            Файл разрешен для скачивания по прямой ссылке
          @endcomponent

          {{-- Input - Slug --}}
          @component(config('systemtheme.inputfield'), ['attributes' => ['name' => 'slug', 'value' => $file->slug, 'placeholder' => 'ЧПУ файла', 'value' => $file->slug ?? '']])
            @slot('label')
              ЧПУ
            @endslot
          @endcomponent

          @component(config('systemtheme.linkfield'), ['open' => true, 'copy' => true, 'prefix' => config('file.url_prefix_download'), 'attributes' => ['id' => 'link', 'placeholder' => 'Ссылка для скачивания файла', 'value' => ! empty($file->slug) ? route('files.download', $file->slug) : '']])
            @slot('label')
              Ссылка на файл
            @endslot
            @slot('note')
              (заполняется при вводе ЧПУ)
            @endslot
          @endcomponent

          {{-- TODO добавление элементов или полная замена секции, например, добавление кнопки поделиться в соцсетях или через почту --}}
        @endcomponent

        {{-- TODO расширяется секция --}}
        {{-- Group - Storage --}}
        @component(config('systemtheme.group'))
          @component(config('systemtheme.heading'), ['type' => 'h2', 'attributes' => ['class' => 'f']])
            Хранение файла
          @endcomponent

          @component(config('systemtheme.description'))
            <p>
              Загружаемые файлы можно скачать без публикации. Но каждому
              загружаемому файлу присваивается уникальное труднозапоминаемое имя.
            </p>
            <p>
              Опубликованный файл можно скачать по уникальной ссылке, которую
              можно запонить. На разные файлы можно указать одинаковую ссылку, но
              доступна для скачивания будет только одна.
            </p>
          @endcomponent

          {{-- Input - Direct file link --}}
          @component(config('systemtheme.linkfield'), ['open' => true, 'copy' => true, 'attributes' => ['value' => \Storage::url($file->path), 'placeholder' => 'Прямая ссылка для загрузки файла', 'readonly' => true]])
            @slot('label')
              Прямая ссылка на оригинальный файл
            @endslot
          @endcomponent

          {{-- TODO используемый диск --}}

          {{-- Input - Relative file path --}}
          @component(config('systemtheme.linkfield'), ['copy' => true, 'attributes' => ['value' => $file->path, 'placeholder' => 'Путь к файлу относительно хранилища', 'readonly' => true]])
            @slot('label')
              Путь к файлу относительно хранилища (диска)
            @endslot
          @endcomponent
        @endcomponent
      @endcomponent

    @endcomponent
  @endcomponent
@endsection