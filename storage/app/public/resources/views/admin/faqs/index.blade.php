@extends('admin.layout.app')
@section('title','Dashboard')
@push('css')
<link rel="stylesheet" href="{{ asset('admin/assets/dashboard/css/dataTables.bootstrap4.min.css') }}" />
@endpush
@section('content')
<div class="app-content content ">
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
                            <div class="card-body mt-2">
                                <form action="{{ route('admin.mtg.cms.store') }}" method="POST" >
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-10 mt-1">
                                            <div class="form-group">
                                                <label>FAQ Title</label>
                                                <input rows="4" name="faqs_title" value="{{$setting['faqs_title'] ?? ''}}" class="form-control w-100"
                                                    placeholder="Ttile">
                                            </div>
                                        </div>
                                        <div class="col-lg-2 " style="margin-top: 35px;">
                                            <div class="form-group ">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header border-bottom d-flex justify-content-between">
                                <h4 class="card-title text-capitalize">FAQ’s</h4>
                                <div class="">
                                    <a href="{{route('admin.mtg.cms.faqs.create')}}" class="btn btn-primary">Add</a>
                                </div>
                            </div>
                            <div class="card-body mt-2">
                                <div class="table-responsive">
                                    {{ $dataTable->table(['class' => 'table text-center table-striped w-100'],true) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

@endsection

@push('js')
@include('admin.components.datatablesScript')
@endpush
