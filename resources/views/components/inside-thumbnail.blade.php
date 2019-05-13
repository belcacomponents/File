@if (in_array($mime, config('file.supported_thumbnails') ?? []))
  @include(config('file.thumbnail_image_component'), ['link' => $link, 'src' => $src, 'title' => $title, 'mime' => $mime])
@else
  @include(config('file.thumbnail_mime_component'), ['link' => $link, 'mime' => $mime])
@endif
