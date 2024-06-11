@extends('user.layout.app')
@section('title','Interest')
@push('css')
@endpush
@section('content')
<div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
    <div class="content-body">
        <section class="app-user-app-user-view-account d-flex justify-content-center-account justify-content-center overflow-hidden">
            <div class="row w-100">
                <div class="col-xl-4 col-lg-5 col-md-5 ">
                    @include('user.components.userCard')
                </div>
                <div class="col-xl-8 col-lg-7 col-md-7">
                    @include('user.components.action-list')
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h4 class="card-title text-capitalize text-site-primary fw-bolder">You have {{$auth->type == "business" ? "Business" : ""}} {{$auth->role}} account</h4>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="loader d-none position-absolute" style="top: 200px;">
                                <div class="spinner-grow text-secondary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div class="spinner-grow text-secondary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div class="spinner-grow text-secondary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div class="spinner-grow text-secondary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-1">
                            @if($orders == 0)
                            <form action="{{route('user.mangopay.details')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <label class="card-title m-0" for="account-old-password">Do you want to Change your Account type?</label>
                                    @if($auth->role != "buyer")
                                    <div class="alert alert-warning mt-1 alert-validation-msg" role="alert">
                                        <div class="alert-body d-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info me-50"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                            <span>Your cannot change your account type back but you can still buy and sell things on our platform.</span>
                                        </div>
                                    </div>
                                    @endif
                                    @if($auth->role != "business")
                                    <label class="form-check-label fs-5 mt-50 fw-bolder" for="">Select Your Account Type</label>
                                    <div class="col-12 col-sm-12 mb-1 mt-50 d-sm-flex justify-content-center">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input seller" type="radio" name="role" id="seller" value="seller" checked>
                                            <label class="form-check-label" for="seller">Seller</label>
                                        </div>
                                        <div class="form-check form-check-inline type mt-sm-0 mt-1">
                                            <input class="form-check-input" type="radio" name="role" id="business" value="business" {{$auth->role == 'business' ? "checked" : ""}}>
                                            <label class="form-check-label" for="business">Business</label>
                                            <div class="alert alert-info col-sm-10 col-12 alert-validation-msg" role="alert">
                                                <div class="alert-body d-flex align-items-center">
                                                    <div class="me-25">
                                                        <i data-feather='alert-circle' style="width: 15px; height:20px;margin-bottom:20px;"></i>
                                                    </div>
                                                    <div>
                                                        <span><strong>Business Account</strong> are for those who   have registered company and shop in UK for cards sale/purchase</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @error('role')
                                            <p class="text-danger mb-25">{{ $message }}</p>
                                        @enderror
                                    </div>
                                        <div class="d-flex justify-content-end">
                                            <button  class="btn btn-primary me-1 waves-effect waves-float waves-light submit" title="Submit">Submit</button>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </form>
                            @else
                            <div class="d-flex">
                                <div class="alert alert-danger w-100 alert-validation-msg" role="alert">
                                    <div class="alert-body d-flex align-items-center">
                                        <div class="me-25">
                                            <i data-feather='alert-circle' style="width: 15px; height:20px;"></i>
                                        </div>
                                        <div>
                                            <span>You cannot change your account type until you have completed any open orders.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
        </section>
    </div>
</div>
@endsection
