{{-- /resources/views/components/thumbnail-mime.blade.php --}}
{{-- Thumbnail MIME | MIME icon --}}
<a href="{{ $link }}">
  <div class="belca-file-card-body">
    {{-- gray, выравнить по центру и по высоте, с учетом возможных увеличений других блоков --}}
    <span class="belca-file-card-text">{{ $item->mime }}</span>
  </div>
</a>
