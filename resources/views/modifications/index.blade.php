{{-- TODO Шаблон для темы по умолчанию. Должен расширяться вставкой секциями или пушем --}}
@extends(component_path('app'))

@section('title', 'Модификации файлов')

@section('content')
  {{-- Workspace --}}
  @component(component_path('workspace'))
    {{-- Breadcrumbs --}}
    @include(component_path('breadcrumbs'), [
      'breadcrumbs' => [
        ['link' => '/system', 'label' => 'Главная'],
        ['link' => route('file_tools.files.index'), 'label' => 'Файлы'],
        ['label' => 'Модификации файлов']
      ]
    ])

    {{-- Container --}}
    @component(component_path('container'))

      {{-- Heading --}}
      @component(component_path('heading'))
        Модификации файлов
      @endcomponent

      {{-- Form --}}
      @component(component_path('form'), [
        'attributes' => [
          'action' => route('file_tools.mods.index'),
          'method' => 'get'
        ]
      ])
        {{-- Control panel --}}
        @component(component_path('control_panel'))

          {{--
          @component(component_path('button'), ['attributes' => ['type' => 'submit']])
            Мультизагрузка
          @endcomponent
          --}}

          {{-- TODO расширение: добавление кнопок или полная замена --}}

          @slot('additional')
            <div class="uk-inline uk-width-1-1 uk-width-1-2@m">
              <button type="submit" class="uk-form-icon uk-form-icon-flip" href="" uk-icon="icon: search"></button>
              <input name="title" value="{{ old('title', $title ?? '') }}" class="uk-input" placeholder="Поиск файлов по названию">
            </div>

            <button class="uk-button uk-button-default" type="submit">Поиск</button>
          @endslot

          {{--
          @slot('hidden')
            Дополнительные элементы фильтрации файлов
          @endslot
          --}}
        @endcomponent
      @endcomponent

      {{-- Files --}}
      <div class="uk-margin">
        @component(component_path('entity-list'))
          @if (isset($files) && $files->count() > 0)
            @foreach ($files as $item)
              @component(component_path('thumbnail'), ['link' => route('file_tools.mods.edit', $item->id), 'title' => $item->title])
                @include(config('file.inside_thumbnail_component'), ['link' => route('file_tools.mods.edit', $item->id), 'src' => \Storage::url($item->path), 'title' => $item->title, 'mime' => $item->mime])
              @endcomponent
            @endforeach
          @else
            <p>Файлы не найдены.</p>
          @endif
        @endcomponent
      </div>

      {{-- Pagination --}}
      <div class="uk-margin">
        {{ $files->links(component_path('pagination')) }}
      </div>
    @endcomponent
  @endcomponent
@endsection
