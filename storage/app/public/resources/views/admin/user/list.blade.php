@extends('admin.layout.app')
@section('title','Users')
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
            <section class="invoice-preview-wrapper">
                <div class="row invoice-preview">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title text-capitalize">{{$status ?? $type}} Users</h4>
                                <div class="">
                                @if($type != null && $type != 'marketing-users')
                                    <button data-bs-toggle="modal" data-bs-target="#sendInvite" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Manage User Referral">Manage User Referral</button>
                                @endif
                                </div>
                            </div>
                            <div class="card-body">
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
@include('admin.user.components.referal-manage')
@endsection

@push('js')
@include('admin.components.datatablesScript')
@endpush
