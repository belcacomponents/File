{{-- /resources/views/modifications/create.blade.php --}}
{{-- Страница загрузки модификации файла --}}
@extends(component_path('app'))

@section('title', 'Загрузка модификации файла ['.$file->id.']')

@section('content')
  @component(component_path('workspace'))
    {{-- Breadcrumbs --}}
    @include(component_path('breadcrumbs'), [
      'breadcrumbs' => [
        ['link' => '/system', 'label' => 'Главная'],
        ['link' => route('file_tools.files.index'), 'label' => 'Файлы'],
        ['link' => route('file_tools.mods.index'), 'label' => 'Модификации'],
        ['link' => route('file_tools.mods.edit', $file->id), 'label' => 'Оригинал ['.$file->id.']'],
        ['label' => 'Загрузка модификации файла']]
    ])

    {{-- Container --}}
    @component(component_path('container'))
      @component(component_path('heading'))
        Загрузка модификации файла [{{ $file->id }}]: {{ $file->title }}
      @endcomponent

      {{-- Form --}}
      @component(component_path('form'), [
        'attributes' => [
          'action' => route('file_tools.mods.store', $file->id),
          'method' => 'post',
          'enctype' =>'multipart/form-data'
        ]
      ])

        {{-- Control panel --}}
        @component(component_path('control_panel'))
          @component(component_path('button'), [
            'type' => 'primary',
            'attributes' => [
              'type' => 'submit'
            ]
          ])
            Сохранить
          @endcomponent

          @component(component_path('link_button'), [
            'attributes' => [
              'href' => route('file_tools.mods.edit', $file->id)
            ]
          ])
            Назад
          @endcomponent

          {{-- TODO рашсиряется / заменяется через section и внутренние элементы --}}
        @endcomponent

        {{-- Groups --}}
        @component(component_path('groups'))

          {{-- Group - Main --}}
          @component(component_path('group'))
            @component(component_path('heading'), ['type' => 'h2'])
              Сведения о файле
            @endcomponent

            @component(component_path('filecustom'), [
              'attributes' => [
                'name' => 'file'
              ]
            ])
              Выбрать файл
            @endcomponent

            {{-- Input - Title --}}
            @component(component_path('input_field'), [
              'attributes' => [
                'name' => 'title',
                'value' => old('title', $file->title),
                'placeholder' => 'Заголовок файла'
              ]
            ])
              @slot('label')
                Заголовок файла
              @endslot
            @endcomponent

            {{-- Textarea - Description --}}
            @component(component_path('textarea_field'), [
              'attributes' => [
                'name' => 'description',
                'placeholder' => 'Описание файла'
              ]
            ])
              @slot('label')
                Описание файла
              @endslot

              {{ old('description', $file->description) }}
            @endcomponent

            {{-- TODO полностью заменяется --}}
            @component(component_path('input_field'), [
              'attributes' => [
                'name' => 'handler',
                'value' => old('handler', 'manual'),
                'placeholder' => 'Обработчик'
              ]
            ])
              @slot('label')
                Название обработчика
              @endslot
            @endcomponent

            @component(component_path('input_field'), [
              'attributes' => [
                'name' => 'handler_mode',
                'value' => old('handler_mode', 'default'),
                'placeholder' => 'Режим обработчика'
              ]
            ])
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
