<!doctype html>
@php($layout = session('layout') ?? 'sun')
<html lang="en" class="{{$layout == 'sun' ? 'light-layout' : ' dark-layout'}} light-layout">

<head>
    @include('admin.layout.include.head')
    @stack('css')
</head>

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">


<!--start wrapper-->
<div class="wrapper">
   @include('admin.layout.include.header')
   @include('admin.layout.include.sidebar')
   @yield('content')
   @include('admin.layout.include.footer')
   @include('admin.layout.include.script')

   <form id="logout-form" action="{{ route('logout') }}" class="submit_form" method="POST"
      style="display: none;">
    @csrf
  </form>

  <form id="delete-form" action="" method="POST"
      style="display: none;">
    @csrf
    @method('delete')
  </form>

  <div class="modal fade CustomTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog CustomTypeBody" role="document">

      </div>
  </div>
  <div class="d-flex justify-content-center">
    <div class="sipnner d-none position-absolute" style="top: 100px; z-index:9999">
        <div class=" rotate  " style="transform: rotate(270deg);">
            <div class="spinner-grow text-secondary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-grow text-secondary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-grow text-secondary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-grow text-secondary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
</div>
</div>
<!--end wrapper-->
<script>
  @if(session('message'))
    toastr.success("{{ session('message') }}");
    @elseif(session('error'))
    toastr.error("{{ session('error') }}");
    @endif
</script>
<script>
  function logout(){
    $('.submit_form').submit();
  }
</script>

@stack('js')
<script>
  $(document).ready(function(){
    $('.fa-file-excel-o').removeClass('fa-file-excel-o').addClass('fa-file-excel');
    $('.buttons-excel').addClass('btn btn-icon btn-outline-success waves-effect')
  })
</script>


</body>
</html>
