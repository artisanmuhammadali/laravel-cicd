@extends('user.layout.app')
@section('title','Address')
@push('css')
@endpush
@section('content')
<div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
    <div class="content-header row">
    </div>
    <div class="content-body">
        <section class="app-user-view-app-user-view-account d-flex justify-content-center">
            <div class="row w-100">

                <!-- User Content -->
                <div class="col-xl-12 col-lg-12 col-md-12 order-0 order-md-1">

                    <!-- Address -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-50">Address</h4>
                            <a href="{{route('user.address.loadModal')}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light" title="Add Address">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                <span>Add Address</span>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="added-cards">
                                @foreach($list as $item)
                                <div class="cardMaster border rounded p-2 mb-1">
                                    <div class="d-flex justify-content-between flex-sm-row flex-column">
                                        <div class="card-information">
                                            <div class="d-flex align-items-center mb-50">
                                                <h4 class="fw-bolder">{{$item->name}}</h4>
                                                @if ($item->type == "primary")
                                                    <span class="badge badge-light-primary ms-50">Primary</span>                                                    
                                                @endif
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-7 col-12">
                                                    <dl class="row mb-0">
                                                        <dt class="col-sm-4 fw-bolder mb-1">Address Line 1:</dt>
                                                        <dd class="col-sm-8 mb-1">{{$item->street_number}}</dd>

                                                        {{--<dt class="col-sm-4 fw-bolder mb-1">Address Line 2:</dt>
                                                        <dd class="col-sm-8 mb-1">{{$item->address_2}}</dd>--}}

                                                        <dt class="col-sm-4 fw-bolder mb-1">Country:</dt>
                                                        <dd class="col-sm-8 mb-1">United Kingdom</dd>
        
                                                        <dt class="col-sm-4 fw-bolder mb-1">City:</dt>
                                                        <dd class="col-sm-8 mb-1">{{$item->city}}</dd>
        
                                                        <dt class="col-sm-4 fw-bolder mb-1">Postal Code:</dt>
                                                        <dd class="col-sm-8 mb-1">{{$item->postal_code}}</dd>
                                                    </dl>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column text-start text-lg-end">
                                            <div class="d-flex order-sm-0 order-1 mt-1 mt-sm-0">
                                                <a href="{{route('user.address.loadModal',$item->id)}}" type="button" class="btn btn-icon btn-outline-primary waves-effect me-1" title="Edit">
                                                    <i data-feather='edit-2'></i>
                                                </a>
                                                <button type="button" class="btn btn-icon btn-outline-danger waves-effect " onclick="deleteAlert('{{route('user.address.destroy',$item->id)}}')" title="Delete">
                                                    <i data-feather='trash-2'></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- /Address -->

                </div>
                <!--/ User Content -->
            </div>
        </section>
    </div>
</div>
@endsection

