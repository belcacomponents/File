{{-- /resources/views/modifications/create.blade.php --}}
{{-- Страница загрузки модификации файла --}}
@extends(config('systemtheme.app'))

@section('title', 'Загрузка модификации файла ['.$file->id.']')

@section('content')
  @component(config('systemtheme.workspace'))
    {{-- Breadcrumbs --}}
    @include(config('systemtheme.breadcrumbs'), ['breadcrumbs' => [['link' => '/system', 'label' => 'Главная'], ['link' => route('files.index'), 'label' => 'Файлы'], ['link' => route('files.mods.index'), 'label' => 'Модификации'], ['link' => route('files.mods.edit', $file->id), 'label' => 'Оригинал ['.$file->id.']'], ['label' => 'Загрузка модификации файла']]])

    {{-- Container --}}
    @component(config('systemtheme.container'))
      @component(config('systemtheme.heading'))
        Загрузка модификации файла [{{ $file->id }}]: {{ $file->title }}
      @endcomponent

      {{-- Form --}}
      @component(config('systemtheme.form'), ['attributes' => ['action' => route('files.mods.store', $file->id), 'method' => 'post', 'enctype' =>'multipart/form-data']])

        {{-- Control panel --}}
        @component(config('systemtheme.control-panel'))
          @component(config('systemtheme.button'), ['styleModifier' => 'primary', 'attributes' => ['type' => 'submit']])
            Сохранить
          @endcomponent

          @component(config('systemtheme.buttonlink'), ['attributes' => ['href' => $back ?? route('files.mods.edit', $file->id)]])
            Назад
          @endcomponent

          {{-- TODO рашсиряется / заменяется через section и внутренние элементы --}}
        @endcomponent

        {{-- Groups --}}
        @component(config('systemtheme.groups'))

          {{-- Group - Main --}}
          @component(config('systemtheme.group'))
            @component(config('systemtheme.heading'), ['type' => 'h2'])
              Сведения о файле
            @endcomponent

            @component(config('systemtheme.filecustom'), ['attributes' => ['name' => 'file']])
              Выбрать файл
            @endcomponent

            {{-- Input - Title --}}
            @component(config('systemtheme.textinput'), ['attributes' => ['name' => 'title', 'value' => old('title', $file->title), 'placeholder' => 'Заголовок файла']])
              @slot('label')
                Заголовок файла
              @endslot
            @endcomponent

            {{-- Textarea - Description --}}
            @component(config('systemtheme.multilineinput'), ['attributes' => ['name' => 'description', 'placeholder' => 'Описание файла']])
              @slot('label')
                Описание файла
              @endslot

              {{ old('description', $file->description) }}
            @endcomponent

            {{-- TODO полностью заменяется --}}
            @component(config('systemtheme.textinput'), ['attributes' => ['name' => 'handler', 'value' => old('handler', 'manual'), 'placeholder' => 'Обработчик']])
              @slot('label')
                Название обработчика
              @endslot
            @endcomponent

            @component(config('systemtheme.textinput'), ['attributes' => ['name' => 'handler_mode', 'value' => old('handler_mode', 'default'), 'placeholder' => 'Режим обработчика']])
              @slot('label')
                Режим обработчика
              @endslot
            @endcomponent

          @endcomponent
        @endcomponent

        {{-- TODO дополняется, например, категория, диск --}}
      @endcomponent
    @endcomponent

  @endcomponent
@endsection
