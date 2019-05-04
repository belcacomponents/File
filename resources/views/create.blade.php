{{-- Должен быть основан на теме по умолчанию и иметь возможность расширения
с помощью секций, компонентов и стеков --}}

<form class="" action="{{ route('files.store') }}" method="post" enctype="multipart/form-data">
  {{ csrf_field() }}
  <input type="text" name="title" value="" placeholder="title">
  <input type="text" name="path" value="" placeholder="path">
  <input type="text" name="source" value="user-device" placeholder="source">

  <input type="file" name="file" value="">

  <input type="submit" name="" value="">
</form>
