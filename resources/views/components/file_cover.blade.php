@isset($attributes['src'])
  <div class="uk-margin">
    @isset($label)
      <label class="uk-form-label">{{ $label }}</label>
    @endisset

    <a href="{{ $attributes['src'] }}" target="_blank" title="Открыть файл" class="width_max_1-4">
      <img src="{{ $attributes['src'] }}" alt="">
    </a>
  </div>
@endisset
