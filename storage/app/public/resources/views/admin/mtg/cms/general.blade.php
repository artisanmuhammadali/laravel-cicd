@extends('admin.layout.app')
@section('title','Dashboard')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">

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
                    <div class="card ">
                        <div class="card-header card-header-primary card-header-icon">
                            <h5 class="card-title">Web Configuration - <span class="config">{{vfsWebConfig() ? "Live" : "Countdown"}}</span></h5>
                            <div class="d-flex">
                                <div class="form-check form-switch">
                                    <input class="form-check-input chekbox_status m-auto my-50 mx-2" {{vfsWebConfig() ? "checked" : ""}} type="checkbox" role="switch" id="flexSwitchCheckChecked">
                                    <input type="hidden" class="web_config" name="web_config" value="{{vfsWebConfig() ? "on" : "off"}}">
                                </div>
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                        </div>
                    </div>
                        @include('admin.mtg.cms.components.general.logos')
                        @include('admin.mtg.cms.components.general.general_info')
                        {{--@include('admin.mtg.cms.components.general.search_info')--}}
                        {{--@include('admin.mtg.cms.components.general.expansion_banner')--}}
                        @include('admin.mtg.cms.components.general.social_media')
                        @include('admin.mtg.cms.components.general.footer')
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@push('js')
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
    $(document).on('change','.chekbox_status',function()
    {
        var text = $(this).is(':checked') ? "Live" : "Countdown"; 
        var value = $(this).is(':checked') ? "on" : "off"; 
        $('.web_config').val(value);
        $('.config').text(text);
    })
</script>
@endpush
