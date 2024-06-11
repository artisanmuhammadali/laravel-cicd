@extends('admin.layout.app')
@section('title','Dashboard')
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
                        @include('admin.mtg.cms.components.detailed_search.body')
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
@endpush
