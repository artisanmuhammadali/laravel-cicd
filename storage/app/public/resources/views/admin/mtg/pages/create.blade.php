@extends('admin.layout.app')
@section('title','Dashboard')
@push('css')
@endpush
@section('content')
<div class="app-content content position-relative">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section id="row-grouping-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom d-flex justify-content-between">
                                <h4 class="card-title">Page</h4>
                            </div>
                            <div class="card-body mt-2">
                                @include('admin.mtg.pages.form',['route' => route('admin.mtg.cms.pages.store'),'method'
                                => 'POST'])
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<input type="text" class="d-none" id="myInput">

@endsection

@push('js')

@endpush
