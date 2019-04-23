Кнопки Загрузка / Загрузка мульти / Пульти (добавлять/расширятьб/заменить)
Фильтрация (можно добавлять/расширять или заменить)

Контент (можно заменить шаблон отображения или дополнить блоки отображения/заменить)

Навигация (заменить)

Дополнить

Может предоставляться как цельная страница или как компонент страницы (часть страницы)

<form class="" action="{{ route('files.index') }}" method="get">
  <input type="text" name="title" value="">
  <input type="submit" name="" value="">
</form>

@if (isset($files) && $files->count() > 0)
  @foreach ($files as $item)
    <div class="">
      <a href="{{ route('files.edit', $item->id) }}">{{ $item->title }}</a>
    </div>
  @endforeach
@endif
