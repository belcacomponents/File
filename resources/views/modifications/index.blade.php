{{-- /resources/views/index.blade.php --}}
{{-- Страница со списком файлов --}}
{{-- TODO Шаблон для темы по умолчанию. Должен расширяться вставкой секциями или пушем --}}
@extends(config('systemtheme.app'))

@section('title', 'Модификации файлов')

@section('content')
  {{-- Workspace --}}
  @component(config('systemtheme.workspace'))
    {{-- Breadcrumbs --}}
    @include(config('systemtheme.breadcrumbs'), ['breadcrumbs' => [['link' => '/system', 'label' => 'Главная'], ['link' => route('files.index'), 'label' => 'Файлы'], ['label' => 'Модификации файлов']]])

    {{-- Container --}}
    @component(config('systemtheme.container'))

      {{-- Heading --}}
      @component(config('systemtheme.heading'))
        Модификации файлов
      @endcomponent

      {{-- Form --}}
      @component(config('systemtheme.form'), ['attributes' => ['action' => route('files.index'), 'method' => 'get']])
        {{-- Control panel --}}
        @component(config('systemtheme.control-panel'))

          {{--
          @component(config('systemtheme.button'), ['attributes' => ['type' => 'submit']])
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
        @component(config('systemtheme.entity-list'))
          @if (isset($files) && $files->count() > 0)
            @foreach ($files as $item)
              @component(config('systemtheme.thumbnail'), ['link' => route('files.mods.edit', $item->id), 'title' => $item->title])
                @include(config('file.inside_thumbnail_component'), ['link' => route('files.mods.edit', $item->id), 'src' => \Storage::url($item->path), 'title' => $item->title, 'mime' => $item->mime])
              @endcomponent
            @endforeach
          @else
            <p>Файлы не найдены.</p>
          @endif
        @endcomponent
      </div>

      {{-- Pagination --}}
      <div class="uk-margin">
        {{ $files->links(config('systemtheme.pagination')) }}
      </div>
    @endcomponent
  @endcomponent
@endsection
