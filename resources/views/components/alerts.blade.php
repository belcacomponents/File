{{-- Сообщения о действиях с файлом --}}
@if(session('alert'))
  @php
    switch (session('alert.status')) {
      case 'deleted':
          $type = 'primary';
        break;
      case 'updated':
          $type = 'success';
        break;
      case 'noFiles':
      case 'fileNotSaved':
          $type = 'danger';
        break;
    }
  @endphp
  @component(component_path('alert'), ['type' => $type ?? null])

    @switch (session('alert.status'))
      @case('deleted')
        @slot('title')
          Удалено
        @endslot
      @break

      @case('fileNotSaved')
        @slot('title')
          Не удалось сохранить файл
        @endslot
      @break

      @case('noFiles')
        @slot('title')
          Файл не найден
        @endslot
      @break

      @case('updated')
        @slot('title')
          Обновлено
        @endslot
      @break
    @endswitch

    <p>@lang('belca-file::alerts.'.session('alert.status'))</p>
  @endcomponent
@endif
