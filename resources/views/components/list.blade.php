{{-- /resources/views/components/list.blade.php --}}
{{-- List - displays a list of files --}}
@component(config('system_theme.entity-list'))
  @if (isset($files) && $files->count() > 0)
    @foreach ($files as $item)
      @component(config('systemtheme.thumbnail'), ['link' => route('files.edit', $item->id), 'title' => $item->title])
        @include(config('file.inside_thumbnail_component'), ['link' => route('files.edit', $item->id), 'src' => \Storage::url($item->path), 'title' => $item->title, 'mime' => $item->mime])
      @endcomponent
    @endforeach
  @else
    <p>Файлы не найдены.</p>
  @endif
@endcomponent
