@extends('belca-defaultsystemtheme::system.admin.app')

{{-- Шаблон для темы по умолчанию. Должен расширяться вставкой секциями или пушем --}}

@section('content')
  <h1>Файлы</h1>

  <div uk-margin>
    <a href="{{ route('files.create') }}" class="uk-button uk-button-primary">Новый файл</a>
    <a href="#" class="uk-button uk-button-default">Мультизагрузка</a>
    Кнопки Загрузка / Загрузка мульти / Пульти (добавлять/расширятьб/заменить)
  </div>

  <form action="{{ route('files.index') }}" method="get">
    <div class="uk-inline uk-width-1-2@s">
      <button type="submit" class="uk-form-icon uk-form-icon-flip" href="" uk-icon="icon: search"></button>
      <input name="title" value="{{ old('title') }}" class="uk-input" placeholder="Поиск файлов по названию">
    </div>

    Фильтрация (можно добавлять/расширять или заменить)
  </form>

  <div class="">
    Контент (можно заменить шаблон отображения или дополнить блоки отображения/заменить)

    @if (isset($files) && $files->count() > 0)
      @foreach ($files as $item)
        <div class="">
          <a href="{{ route('files.edit', $item->id) }}">{{ $item->title }}</a>
        </div>
      @endforeach
    @endif
  </div>


  <div class="">
    Навигация (заменить)

    <ul class="uk-pagination" uk-margin>
        <li><a href="#"><span uk-pagination-previous></span></a></li>
        <li><a href="#">1</a></li>
        <li class="uk-disabled"><span>...</span></li>
        <li><a href="#">4</a></li>
        <li><a href="#">5</a></li>
        <li><a href="#">6</a></li>
        <li class="uk-active"><span>7</span></li>
        <li><a href="#">8</a></li>
        <li><a href="#">9</a></li>
        <li><a href="#">10</a></li>
        <li class="uk-disabled"><span>...</span></li>
        <li><a href="#">20</a></li>
        <li><a href="#"><span uk-pagination-next></span></a></li>
    </ul>

    Дополнить
  </div>

  Может предоставляться как цельная страница или как компонент страницы (часть страницы)
@endsection
