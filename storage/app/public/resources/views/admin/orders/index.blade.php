@extends('admin.layout.app')
@section('title','Orders')
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
                                <h4 class="card-title">Orders</h4>
                            </div>
                            <div class="card-body">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        @if($type != 'dispute-orders')
                                        @foreach($navs as $nav)
                                        <a href="{{ route('admin.orders.index',$nav) }}" class="nav-link text-capitalize {{$nav == $type ? "active" : ""}}" type="button" >{{$nav}}
                                            <span class="ms-25 {{$nav == $type ? "bg-primary" : 'bg-secondary' }} badge rounded-pill cart-span">
                                                {{getAllOrderCount($nav)}}
                                            </span>
                                        </a>
                                        @endforeach
                                        @endif
                                    </div>
                                </nav>
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