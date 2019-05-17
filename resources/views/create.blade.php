{{-- /resources/views/create.blade.php --}}
{{-- Страница загрузки файла --}}
@extends(config('systemtheme.app'))

@section('title', 'Загрузка файл')

@section('content')
  @component(config('systemtheme.workspace'))
    {{-- Breadcrumbs --}}
    @include(config('systemtheme.breadcrumbs'), ['breadcrumbs' => [['link' => '/system', 'label' => 'Главная'], ['link' => route('files.index'), 'label' => __('belca-file::files.files')], ['label' => __('belca-file::files.upload_file_title')]]])

    {{-- Container --}}
    @component(config('systemtheme.container'))
      @component(config('systemtheme.heading'))
        @lang('belca-file::files.upload_file_title')
      @endcomponent

      {{-- Form --}}
      @component(config('systemtheme.form'), ['attributes' => ['action' => route('files.store'), 'method' => 'post', 'enctype' =>'multipart/form-data']])

        {{-- Control panel --}}
        @component(config('systemtheme.control-panel'))
          {{-- Section: Buttons --}}
          @section('buttons')
            @component(config('systemtheme.button'), ['styleModifier' => 'primary', 'attributes' => ['type' => 'submit']])
              @lang('belca-file::files.save_file')
            @endcomponent
          @show

          @component(config('systemtheme.buttonlink'), ['attributes' => ['href' => $back ?? route('files.index')]])
            Назад
          @endcomponent
        @endcomponent
        {{-- End Control panel --}}

        {{-- Alerts --}}
        @include(config('file.alerts_component'))

        {{-- Errors --}}
        @if ($errors->any())
          @component(config('systemtheme.alert'), ['type' => 'danger'])
            @slot('title')
              Ошибка
            @endslot

            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
          @endcomponent
        @endif

        {{-- Groups --}}
        @component(config('systemtheme.groups'))

          {{-- Section: Groups --}}
          @section('groups')
            {{-- Group - Main --}}
            @component(config('systemtheme.group'))
              @component(config('systemtheme.heading'), ['type' => 'h2'])
                @lang('belca-file::files.file_information')
              @endcomponent

              {{-- Section: File selection --}}
              @section('fileSelection')
                @component(config('systemtheme.filecustom'), ['attributes' => ['name' => 'file']])
                  @lang('belca-file::files.select_file')
                @endcomponent
              @show

              {{-- Section: Input fields --}}
              @section('inputFields')
                {{-- Input - Title --}}
                @component(config('systemtheme.textinput'), ['attributes' => ['name' => 'title', 'value' => old('title'), 'placeholder' => __('belca-file::files.filename')]])
                  @slot('label')
                    @lang('belca-file::files.filename')
                  @endslot
                @endcomponent

                {{-- Textarea - Description --}}
                @component(config('systemtheme.multilineinput'), ['attributes' => ['name' => 'description', 'value' => old('description'), 'placeholder' => __('belca-file::files.file_description')]])
                  @slot('label')
                    @lang('belca-file::files.file_description')
                  @endslot

                  {{ old('description') }}
                @endcomponent
              @show
            @endcomponent
          @show

        @endcomponent
        {{-- End Groups --}}
      @endcomponent
      {{-- End Form --}}
    @endcomponent
  @endcomponent
@endsection
