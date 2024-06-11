@extends('admin.layout.app')
@section('title','Dashboard')
@push('css')
<link rel="stylesheet" href="{{ asset('admin/assets/dashboard/css/dataTables.bootstrap4.min.css') }}" />
@endpush
@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section id="row-grouping-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom d-flex justify-content-between">
                                <h4 class="card-title text-capitalize">Expansions</h4>
                                <div class="">
                                    {{-- @if($type != "new_arrival") --}}
                                    <a  href="{{route('admin.sw.expansion.create')}}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Add Expansions">Add
                                        Expansion</a>
                                    {{-- @endif --}}
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
