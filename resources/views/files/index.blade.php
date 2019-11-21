@extends(component_path('app'))

@section('title', __('belca-file::files.files'))

@section('content')
  {{-- Workspace --}}
  @component(component_path('workspace'))
    {{-- Breadcrumbs --}}
    @include(component_path('breadcrumbs'), [
      'breadcrumbs' => [
        ['link' => '/system', 'label' => 'Главная'],
        ['label' => __('belca-file::files.files')]
      ]
    ])

    {{-- Container --}}
    @component(component_path('container'))

      {{-- Heading --}}
      @component(component_path('heading'))
        @lang('belca-file::files.files')
      @endcomponent

      {{-- Form --}}
      @component(component_path('form'), ['attributes' => ['action' => route('file_tools.files.index'), 'method' => 'get']])
        {{-- Control panel --}}
        @component(component_path('control_panel'))
          {{-- Section: Buttons --}}
          @section('buttons')
            @component(component_path('link_button'), [
              'type' => 'primary',
              'attributes' => [
                'href' => route('file_tools.files.create')
              ]
            ])
              @lang('belca-file::files.upload_file')
            @endcomponent

            {{-- TODO добавить мультизагрузку
            @component(component_path('button'), ['attributes' => ['type' => 'submit']])
              Мультизагрузка
            @endcomponent
            --}}
          @show

          @component(component_path('link_button'), [
            'attributes' => [
              'href' => route('file_tools.mods.index')
            ]
          ])
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
          @component(component_path('entity-list'), ['count' => 5])
            @if (isset($files) && $files->count() > 0)
              @foreach ($files as $item)
                @component(component_path('thumbnail'), ['link' => route('file_tools.files.edit', $item->id), 'title' => $item->title])
                  @include(config('file.inside_thumbnail_component'), ['link' => route('file_tools.files.edit', $item->id), 'src' => \Storage::url($item->path), 'title' => $item->title, 'mime' => $item->mime])
                @endcomponent
              @endforeach
            @else
              <p>@lang('belca-file::files.files_not_found')</p>
            @endif
          @endcomponent
        </div>
      @show

      {{-- Pagination --}}
      @if (isset($files) )
        <div class="uk-margin">
          {{-- {{ $files->links(component_path('pagination')) }} --}}
        </div>
      @endif
    @endcomponent
  @endcomponent
@endsection
