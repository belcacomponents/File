@extends(component_path('app'))

@section('title', 'Загрузка файл')

@section('content')
  @component(component_path('workspace'))
    {{-- Breadcrumbs --}}
    @include(component_path('breadcrumbs'), [
      'breadcrumbs' => [
        ['link' => '/system', 'label' => 'Главная'],
        ['link' => route('file_tools.files.index'), 'label' => __('belca-file::files.files')],
        ['label' => __('belca-file::files.upload_file_title')]
      ]
    ])

    {{-- Container --}}
    @component(component_path('container'))
      @component(component_path('heading'))
        @lang('belca-file::files.upload_file_title')
      @endcomponent

      {{-- Form --}}
      @component(component_path('form'), [
        'attributes' => [
          'action' => route('file_tools.files.store'),
          'method' => 'post',
          'enctype' =>'multipart/form-data'
        ]
      ])

        {{-- Control panel --}}
        @component(component_path('control_panel'))
          {{-- Section: Buttons --}}
          @section('buttons')
            @component(component_path('button'), [
              'type' => 'primary',
              'attributes' => [
                'type' => 'submit'
              ]
            ])
              @lang('belca-file::files.save_file')
            @endcomponent
          @show

          @component(component_path('link_button'), [
            'attributes' => [
              'href' => route('file_tools.files.index')
            ]
          ])
            Назад
          @endcomponent
        @endcomponent
        {{-- End Control panel --}}

        {{-- Alerts --}}
        @include(config('file.alerts_component'))

        {{-- Errors --}}
        @if ($errors->any())
          @component(component_path('alert'), ['type' => 'danger'])
            @slot('title')
              Ошибка
            @endslot

            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
          @endcomponent
        @endif

        {{-- Groups --}}
        @component(component_path('groups'))

          {{-- Section: Groups --}}
          @section('groups')
            {{-- Group - Main --}}
            @component(component_path('group'))
              @component(component_path('heading'), ['type' => 'h2'])
                @lang('belca-file::files.file_information')
              @endcomponent

              {{-- Section: File selection --}}
              @section('fileSelection')
                @component(component_path('filecustom'), [
                  'attributes' => [
                    'name' => 'file'
                  ]
                ])
                  @lang('belca-file::files.select_file')
                @endcomponent
              @show

              {{-- Section: Input fields --}}
              @section('inputFields')
                {{-- Input - Title --}}
                @component(component_path('input_field'), [
                  'attributes' => [
                    'name' => 'title',
                    'value' => old('title'),
                    'placeholder' => __('belca-file::files.filename')
                  ]
                ])
                  @slot('label')
                    @lang('belca-file::files.filename')
                  @endslot
                @endcomponent

                {{-- Textarea - Description --}}
                @component(component_path('textarea_field'), ['attributes' => ['name' => 'description', 'value' => old('description'), 'placeholder' => __('belca-file::files.file_description')]])
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

  @push('footer')
    <script type="text/javascript">
      file.addEventListener('change', function () {
          //if (title.value == '') {
              title.value = this.files[0].name;
          //}
      });
    </script>
  @endpush
@endsection
