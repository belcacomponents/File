{{-- /resources/views/components/thumbnail-image.blade.php --}}
{{-- Thumbnail image --}}
<div class="uk-card-badge uk-label">{{ $mime }}</div>
<a href="{{ $link }}" class="bc-box bc-box_height_s bc-nolink">
  <div class="bc-cover bc-cover_type_background bc-cover_size_stretchable" style="background-image: url('{{ $src }}')">
  </div>
</a>
