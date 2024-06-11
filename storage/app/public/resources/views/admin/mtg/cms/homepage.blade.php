@extends('admin.layout.app')
@section('title','Dashboard')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">
@include('admin.components.timepikerStyle')
@push('css')
@endpush
@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <form action="{{route('admin.mtg.cms.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        @include('admin.mtg.cms.components.homepage.banner')
                        @include('admin.mtg.cms.components.homepage.product_range')
                        @include('admin.mtg.cms.components.homepage.why_with_us')
                        @include('admin.mtg.cms.components.homepage.article')
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
@include('admin.components.timepikerScript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<script>
    $('.dropify').dropify({
        messages: {
            'default': '',
            'replace': '',
            'remove': 'Remove',
            'error': 'Ooops, something wrong happended.'
        }
    });

</script>
@endpush
