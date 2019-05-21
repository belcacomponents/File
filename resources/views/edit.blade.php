{{-- /resources/views/edit.blade.php --}}
{{-- Страница правки информации о файле --}}
{{-- TODO Должен иметь возможность расширения c помощью секций, компонентов и стеков --}}
@extends(config('systemtheme.app'))

@section('title', 'Правка файла: '.$file->title.' ['.$file->id.']')

@section('content')
  @component(config('systemtheme.workspace'))
    {{-- Breadcrumbs --}}
    @include(config('systemtheme.breadcrumbs'), ['breadcrumbs' => [['link' => '/system', 'label' => 'Главная'], ['link' => route('files.index'), 'label' => 'Файлы'], ['label' => 'Правка файла']]])

    {{-- Container --}}
    @component(config('systemtheme.container'))

      {{-- Heading --}}
      @component(config('systemtheme.heading'))
        Правка файла: {{ $file->title }}
      @endcomponent

      {{-- Delete form  --}}
      @component(config('systemtheme.form'), ['crud' => 'delete','attributes' => ['action' => route('files.destroy', $file->id), 'id' => 'deleteForm']])
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

          @component(config('systemtheme.button'), ['styleModifier' => 'danger', 'attributes' => ['form' => 'deleteForm', 'type' => 'submit', 'id' => 'delete']])
            Удалить
          @endcomponent

          @component(config('systemtheme.buttonlink'), ['attributes' => ['href' => $back ?? route('files.index')]])
            Назад
          @endcomponent

          {{-- TODO рашсиряется / заменяется через section и внутренние элементы --}}
        @endcomponent

        {{-- Alerts --}}
        @include(config('file.alerts_component'))

        {{-- Zones --}}
        @component(config('systemtheme.zones'))
          @component(config('systemtheme.zone'), ['type' => 'basic'])
            {{-- Groups --}}
            @component(config('systemtheme.groups'))

              {{-- Group - Main --}}
              @component(config('systemtheme.group'))
                @component(config('systemtheme.heading'), ['type' => 'h2'])
                  @lang('belca-file::files.file_information')
                @endcomponent

                {{-- Input - Title --}}
                @component(config('systemtheme.textinput'), ['attributes' => ['name' => 'title', 'value' => $file->title, 'placeholder' => __('belca-file::files.filename')]])
                  @slot('label')
                    @lang('belca-file::files.filename')
                  @endslot
                @endcomponent

                {{-- TODO дополняется, например, категория, диск --}}

                {{-- Textarea - Description --}}
                @component(config('systemtheme.multilineinput'), ['attributes' => ['name' => 'description', 'placeholder' => __('belca-file::files.file_description')]])
                  @slot('label')
                    @lang('belca-file::files.file_description')
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
                @component(config('systemtheme.textinput'), ['attributes' => ['name' => 'slug', 'value' => $file->slug, 'placeholder' => 'ЧПУ файла', 'value' => $file->slug ?? '']])
                  @slot('label')
                    ЧПУ
                  @endslot
                @endcomponent

                @component(config('systemtheme.linkoutput'), ['open' => true, 'copy' => true, 'prefix' => config('file.url_prefix_download'), 'attributes' => ['id' => 'link', 'placeholder' => 'Ссылка для скачивания файла', 'value' => ! empty($file->slug) ? route('files.download', $file->slug) : '']])
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
                @component(config('systemtheme.linkoutput'), ['open' => true, 'copy' => true, 'attributes' => ['value' => \Storage::url($file->path), 'placeholder' => 'Прямая ссылка для загрузки файла', 'readonly' => true]])
                  @slot('label')
                    Прямая ссылка на оригинальный файл
                  @endslot
                @endcomponent

                {{-- Disk / Storage --}}
                @component(config('systemtheme.staticvalue'))
                  @slot('label')
                    Путь к хранилищу (<b>{{ $file->disk }}</b>)
                  @endslot

                  {{ \Storage::disk($file->disk)->getAdapter()->getPathPrefix() }}
                @endcomponent

                {{-- Input - Relative file path --}}
                @component(config('systemtheme.linkoutput'), ['copy' => true, 'attributes' => ['value' => $file->path, 'placeholder' => 'Путь к файлу относительно хранилища', 'readonly' => true]])
                  @slot('label')
                    Путь к файлу относительно хранилища
                  @endslot
                @endcomponent
              @endcomponent
            @endcomponent
          @endcomponent

          @component(config('systemtheme.zone'), ['type' => 'additional', 'class' => 'padding_left_small@s'])
            @component(config('systemtheme.groups'))

              {{-- Group - Additional --}}
              @component(config('systemtheme.group'))
                @component(config('systemtheme.heading'), ['type' => 'h2'])
                  Дополнительные сведения
                @endcomponent

                {{-- Cover --}}
                @if (in_array($file->mime, config('file.supported_thumbnails')))
                  @component(config('systemtheme.filecover'), ['attributes' => ['src' => \Storage::url($file->path)]])
                    @slot('label')
                      Миниатюра файла
                    @endslot
                  @endcomponent
                @endif

                {{-- Upload date --}}
                @component(config('systemtheme.staticvalue'))
                  @slot('label')
                    Дата загрузки
                  @endslot

                  {{ $file->created_at }}
                @endcomponent

                {{-- User --}}
                @isset($file->user_id)
                  @component(config('systemtheme.staticvalue'))
                    @slot('label')
                      Пользователь
                    @endslot

                    {{ $file->user->full_name }}
                  @endcomponent
                @endisset

                {{-- Extension --}}
                @isset($file->extension)
                  @component(config('systemtheme.staticvalue'))
                    @slot('label')
                      Расширение
                    @endslot

                    {{ $file->extension }}
                  @endcomponent
                @endisset

                {{-- MIME --}}
                @component(config('systemtheme.staticvalue'))
                  @slot('label')
                    Тип MIME
                  @endslot

                  {{ $file->mime }}
                @endcomponent

                {{-- Modifications --}}
                @component(config('systemtheme.staticvalue'))
                  @slot('label')
                    Модификаций:
                  @endslot

                  {{ $file->modifications()->count() }}
                @endcomponent
              @endcomponent

            @endcomponent
          @endcomponent
        @endcomponent

    @endcomponent

    @endcomponent
  @endcomponent

  {{-- Config file deletion --}}
  @if (config('file.confirm_file_deletion'))
    @push('footer')
      <script type="text/javascript">
        UIkit.util.on('#delete', 'click', function (e) {
             e.preventDefault();
             e.target.blur();
             UIkit.modal.confirm('Вы действительно хотите удалить файл? Вместе с файлом будут удалены его модификации. Если файл и/или его модификации используются на сайте, то их удаление может привести к нерабочим ссылкам и ошибкам загрузки данных! Перед удалением файла убедитесь что файл и его модификации нигде не используется.').then(function () {
                 deleteForm.submit();
             });
         });
      </script>
    @endpush
  @endif
@endsection
