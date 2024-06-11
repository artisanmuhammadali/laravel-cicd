<!doctype html>
@php($layout = session('layout') ?? 'sun')
<html lang="en" class="{{$layout == 'sun' ? 'light-layout' : ' dark-layout'}} light-layout">

<head>
    @include('user.layout.include.head')
    @stack('css')
</head>

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">


<!--start wrapper-->
<div class="wrapper">
   @include('user.layout.include.header')
   @include('user.layout.include.sidebar')
   <div class="app-content pt-2 content px-0">
    <div class="content-overlay"></div>
    @include('user.components.rarity-icon')
    @include('user.layout.include.alerts')
    @yield('content')
    <div class="footer-border"></div>
    <div class="footer_section ">
      @include('user.layout.include.footer')
    </div>
  </div>

   <div class="modal fade GeneralModal" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg GeneralModalBody" data-select2-id="37">
    </div>
   </div>

   <!-- <div class="full_page_loading hide">Loading&#8230;</div> -->
   {{-- User Basic Information modals --}}




   @include('user.layout.include.script')

   <form id="logout-form" action="{{ route('logout') }}" method="POST"
      style="display: none;">
    @csrf
  </form>
  <form id="delete-form" action="" method="GET"
      style="display: none;">
    @csrf
</form>

</div>

<!--end wrapper-->
<script>
  @if(session('success'))
  toastr.success("{{ session('success') }}");
  @elseif(session('error'))
  toastr.error("{{ session('error') }}");
  @elseif(session('info'))
  toastr.info("{{ session('info') }}");
  @endif
</script>
<script>
$(document).ready(function(){
  var body = document.body,
    html = document.documentElement;
var margin_top = $(window).height()/3;
$('.footer-border').css('margin-bottom',margin_top);
})
</script>


@stack('js')
</body>
</html>
