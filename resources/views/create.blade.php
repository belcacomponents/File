{{-- /resources/views/create.blade.php --}}
{{-- Страница загрузки файла --}}
{{-- TODO Должен иметь возможность расширения c помощью секций, компонентов и стеков. Расширяется:
место хранения, способ обработки, категория --}}
@extends(config('systemtheme.app'))

@section('title', 'Загрузка файл')

@section('content')
  @component(config('systemtheme.workspace'))
    {{-- Breadcrumbs --}}
    @include(config('systemtheme.breadcrumbs'), ['breadcrumbs' => [['link' => '/system', 'label' => 'Главная'], ['link' => route('files.index'), 'label' => 'Файлы'], ['label' => 'Загрузка файла']]])

    {{-- Container --}}
    @component(config('systemtheme.container'))
      @component(config('systemtheme.heading'))
        Загрузка нового файла
      @endcomponent

      {{-- Form --}}
      @component(config('systemtheme.form'), ['attributes' => ['action' => route('files.store'), 'method' => 'post', 'enctype' =>'multipart/form-data']])
        {{-- Control panel --}}
        @component(config('systemtheme.control-panel'))
          @component(config('systemtheme.button'), ['styleModifier' => 'primary', 'attributes' => ['type' => 'submit']])
            Сохранить
          @endcomponent

          @component(config('systemtheme.buttonlink'), ['attributes' => ['href' => $back ?? route('files.index')]])
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
            @component(config('systemtheme.textinput'), ['attributes' => ['name' => 'title', 'value' => old('title'), 'placeholder' => 'Заголовок файла']])
              @slot('label')
                Заголовок файла
              @endslot
            @endcomponent

            {{-- Textarea - Description --}}
            @component(config('systemtheme.multilineinput'), ['attributes' => ['name' => 'description', 'value' => old('description'), 'placeholder' => 'Описание файла']])
              @slot('label')
                Описание файла
              @endslot

              {{ old('description') }}
            @endcomponent
          @endcomponent
        @endcomponent

        {{-- TODO дополняется, например, категория, диск --}}
      @endcomponent
    @endcomponent

  @endcomponent
@endsection
