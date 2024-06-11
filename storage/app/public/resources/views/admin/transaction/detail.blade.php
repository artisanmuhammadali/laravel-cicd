@extends('admin.layout.app')
@section('title','Transaction Detail')
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
            <section class="invoice-preview-wrapper">
                <div class="row invoice-preview">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-12 px-50 mb-md-0 mb-2 py-auto">
                                <div class="card py-auto h-100">
                                    <div class="card-header">
                                        <h4 class="card-title">Transaction Detail</h4>
                                    </div>
                                    <hr>
                                    <div class="card-body h-100">
                                        <div class="row">
                                            <div class="col-md-4 col-6">
                                                <p class="fw-bold">Transaction id:</p>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <p>{{$item->transaction_id}}</p>
                                            </div>
                                            <div class="col-md-4 col-6">
                                                <p class="fw-bold">Amount:</p>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <p>{{$item->amount}}</p>
                                            </div>
                                            <div class="col-md-4 col-6">
                                                <p class="fw-bold">Type:</p>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <p>{{$item->type}}</p>
                                            </div>
                                            <div class="col-md-4 col-6">
                                                <p class="fw-bold">Created at:</p>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <p>{{$item->created_at}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            csdv
                            <div class="col-md-6 col-12">
                                <div class="row">
                                    @if($item->creditUser)
                                    <div class="col-12 px-50 py-auto">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Credited user</h4>
                                            </div>
                                            <hr>
                                            <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-4 col-6">
                                                            <p class="fw-bold">Name:</p>
                                                        </div>
                                                        <div class="col-md-8 col-6">
                                                            <p>{{$item->creditUser->full_name}}</p>
                                                        </div>
                                                        <div class="col-md-4 col-6">
                                                            <p class="fw-bold">User Name:</p>
                                                        </div>
                                                        <div class="col-md-8 col-6">
                                                            <p>{{$item->creditUser->user_name}}</p>
                                                        </div>
                                                        <div class="col-md-4 col-6">
                                                            <p class="fw-bold">Email:</p>
                                                        </div>
                                                        <div class="col-md-8 col-6">
                                                            <p>{{$item->creditUser->email}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($item->debitUser)
                                    <div class="col-12 px-50 py-auto">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Debiter user</h4>
                                            </div>
                                            <hr>
                                            <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-4 col-6">
                                                            <p class="fw-bold">Name:</p>
                                                        </div>
                                                        <div class="col-md-8 col-6">
                                                            <p>{{$item->debitUser->full_name}}</p>
                                                        </div>
                                                        <div class="col-md-4 col-6">
                                                            <p class="fw-bold">User Name:</p>
                                                        </div>
                                                        <div class="col-md-8 col-6">
                                                            <p>{{$item->debitUser->user_name}}</p>
                                                        </div>
                                                        <div class="col-md-4 col-6">
                                                            <p class="fw-bold">Email:</p>
                                                        </div>
                                                        <div class="col-md-8 col-6">
                                                            <p>{{$item->debitUser->email}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($item->order)
                                    <div class="col-12 px-50 py-auto">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="col-12 d-flex justify-content-between">
                                                    <h4 class="card-title">Order Details</h4>
                                                    <a href="{{route('admin.orders.detail',$item->order->id)}}" class="btn btn-primary waves-effect waves-float waves-light" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Order Detail">
                                                        Order Detail
                                                    </a>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4 col-6">
                                                        <p class="fw-bold">Transaction id:</p>
                                                    </div>
                                                    <div class="col-md-8 col-6">
                                                        <p> {{$item->order->transaction_id}}</p>
                                                    </div>
                                                    <div class="col-md-4 col-6">
                                                        <p class="fw-bold">Buyer:</p>
                                                    </div>
                                                    <div class="col-md-8 col-6">
                                                        <p>{{$item->order->buyer->full_name}}</p>
                                                    </div>
                                                     <div class="col-md-4 col-6">
                                                        <p class="fw-bold">Seller Name:</p>
                                                    </div>
                                                    <div class="col-md-8 col-6">
                                                        <p>{{$item->order->seller->full_name}}</p>
                                                    </div>
                                                    <div class="col-md-4 col-6">
                                                        <p class="fw-bold">Amount:</p>
                                                    </div>
                                                    <div class="col-md-8 col-6">
                                                        <p>{{$item->amount}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-end mb-4">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
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

@endpush
