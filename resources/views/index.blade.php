{{-- /resources/views/index.blade.php --}}
{{-- Страница со списком файлов --}}
@extends(config('systemtheme.app'))

@section('title', __('belca-file::files.files'))

@section('content')
  {{-- Workspace --}}
  @component(config('systemtheme.workspace'))
    {{-- Breadcrumbs --}}
    @include(config('systemtheme.breadcrumbs'), ['breadcrumbs' => [['link' => '/system', 'label' => 'Главная'], ['label' => __('belca-file::files.files')]]])

    {{-- Container --}}
    @component(config('systemtheme.container'))

      {{-- Heading --}}
      @component(config('systemtheme.heading'))
        @lang('belca-file::files.files')
      @endcomponent

      {{-- Form --}}
      @component(config('systemtheme.form'), ['attributes' => ['action' => route('files.index'), 'method' => 'get']])
        {{-- Control panel --}}
        @component(config('systemtheme.control-panel'))
          {{-- Section: Buttons --}}
          @section('buttons')
            @component(config('systemtheme.buttonlink'), ['styleModifier' => 'primary', 'attributes' => ['href' => route('files.create')]])
              @lang('belca-file::files.upload_file')
            @endcomponent

            {{-- TODO добавить мультизагрузку
            @component(config('systemtheme.button'), ['attributes' => ['type' => 'submit']])
              Мультизагрузка
            @endcomponent
            --}}
          @show

          @component(config('systemtheme.buttonlink'), ['attributes' => ['href' => route('files.mods.index')]])
            @lang('belca-file::files.modifications')
          @endcomponent

          {{-- Section: Additional --}}
          @section('additional')
            @slot('additional')
              <div class="uk-inline uk-width-1-1 uk-width-1-2@m">
                <button type="submit" class="uk-form-icon uk-form-icon-flip" href="" uk-icon="icon: search"></button>
                <input name="title" value="{{ old('title', $title ?? '') }}" class="uk-input" placeholder="{{ __('belca-file::files.search_by_title') }}">
              </div>

              <button class="uk-button uk-button-default" type="submit">
                @lang('belca-file::files.search')
              </button>
            @endslot
          @show

          {{-- Section: Hidden --}}
          @yield('hidden')

        @endcomponent
      @endcomponent

      {{-- Alerts --}}
      @include(config('file.alerts_component'))

      {{-- Section: Fles --}}
      @section('files')
        {{-- Files --}}
        <div class="uk-margin">
          {{-- List of files --}}
          @component(config('systemtheme.entity-list'))
            @if (isset($files) && $files->count() > 0)
              @foreach ($files as $item)
                @component(config('systemtheme.thumbnail'), ['link' => route('files.edit', $item->id), 'title' => $item->title])
                  @include(config('file.inside_thumbnail_component'), ['link' => route('files.edit', $item->id), 'src' => \Storage::url($item->path), 'title' => $item->title, 'mime' => $item->mime])
                @endcomponent
              @endforeach
            @else
              <p>@lang('belca-file::files.files_not_found')</p>
            @endif
          @endcomponent
        </div>
      @show

      {{-- Pagination --}}
      <div class="uk-margin">
        {{ $files->links(config('systemtheme.pagination')) }}
      </div>
    @endcomponent
  @endcomponent
@endsection
