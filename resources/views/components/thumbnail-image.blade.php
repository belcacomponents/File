{{-- /resources/views/components/thumbnail-image.blade.php --}}
{{-- Thumbnail image --}}
<div class="uk-card-badge uk-label">{{ $mime }}</div>
<a href="{{ $link }}">
  <img src="{{ $src }}" alt="{{ $title }}">
</a>
