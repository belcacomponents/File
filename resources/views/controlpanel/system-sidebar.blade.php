{{-- Загруженные файлы веб-сайта --}}
@component('belca-controlpanel::system-sidebar-group', ['showSubgroups' => true])
  @component('belca-controlpanel::system-sidebar-group-link', ['link' => route('file_tools.files.index')])
    @lang('belca-system::systemtheme.files')
  @endcomponent

  {{-- Может содержать группы, категории и т.п. файлов.
        Расширяется вручную или автоматически. --}}
  @slot('subgroup')
    @isset($sidebarFileGroups)
       {{ $sidebarFileGroups }}
    @endisset
  @endslot

@endcomponent
