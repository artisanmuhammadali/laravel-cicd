@extends('user.layout.app')
@section('title','Dashboard')
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
                        <div class="card-body pt-1">
                            <div class="card-header px-0 border-bottom pb-75 pt-0">
                                <h4 class="fw-bolder my-2">Wallet</h4>
                                <div>
                                    <button data-bs-toggle="modal" data-bs-target="#payin" class="btn btn-primary mb-md-0 mb-1" title="Add Funds">Add Funds</button>
                                    <button data-bs-toggle="modal" data-bs-target="#card" class="btn btn-primary mb-md-0 mb-1" title="Add Funds">Add Card</button>
                                    @if($auth->role != 'buyer')
                                    <button data-bs-toggle="modal" data-bs-target="#payout"  class="btn btn-primary" title="Withdraw Funds">Withdraw Funds</button>
                                    @endif
                                </div>
                            </div>
                            <div class="info-container">
                                <ul class="list-unstyled">
                                    <li class="mb-75 justify-content-between d-flex">
                                        <div class="col-9 pt-75">
                                            <span class=" fs-4">Very Friendly Sharks Credit:</span>
                                        </div>
                                        <div class="col-3 d-flex">
                                            <span class="fw-bolder mt-75 font_amount text-white bagde w-100 text-center bg-light-success p-25 rounded-2">£ {{$wallet->Balance->Amount/100}} </span>
                                            
                                        </div>
                                    </li>
                                    <li class="mb-75 justify-content-between d-flex">
                                        <div class="col-sm-9 col-7  pt-75">
                                            <span class=" font_amount">Very Friendly Sharks Referral Credit:</span>
                                        </div>
                                        <div class="col-sm-3 col-5 d-flex">
                                            <span class="fw-bolder mt-75 font_amount text-white bagde w-100 text-center bg-light-warning p-25 rounded-2">£ {{$auth->vfs_wallet}} </span>
                                        </div>
                                    </li>
                                    <li class="mb-75 justify-content-between d-flex">
                                        <div class="col-sm-9 col-7 pt-75">
                                            <span class=" font_amount">VFS Referal Credit Used:</span>
                                        </div>
                                        <div class="col-sm-3 col-5 d-flex">
                                            <span class="fw-bolder mt-75 font_amount text-white bagde w-100 text-center bg-light-primary p-25 rounded-2">£ {{$auth->store->vfs_wallet_store ?? 0}} / {{$auth->store->referal_limit}} </span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @if($auth->role != 'buyer')
                    <div class="card">
                        <div class="card-body pt-1">
                            <div class="d-flex border-bottom justify-content-between pb-1 mb-1">
                                <h4 class="fw-bolder my-auto">Bank Account</h4>
                                @if(!$store->mangopay_account_id || empty($bank->Details->IBAN))
                                <button data-bs-toggle="modal" data-bs-target="#bankAccount" class="btn btn-primary">Attach Bank Account</button>
                                @endif
                            </div>
                            
                            <div class="info-container">
                                <ul class="list-unstyled">
                                    @if((!$store->mangopay_account_id) || empty($bank->Details->IBAN))
                                    <li class="mb-75 justify-content-between d-flex">
                                        <div class="col-12">
                                            <p>Attach your bank account to transfer money from your Very Friendly Sharks website credit to your personal bank account.</p>
                                        </div>
                                    </li>
                                    @else
                                    <li class="mb-75 justify-content-between d-flex">
                                        <div class="col-md-2 col-4">
                                            <span class="fw-bolder">Account IBAN:</span>
                                        </div>
                                        <div class="col-md-10 col-8">
                                            <span class="my-auto">{{$bank->Details->IBAN ?? ""}} </span>
                                        </div>
                                    </li>
                                    <li class="mb-75 justify-content-between d-flex">
                                        <div class="col-md-2 col-4">
                                            <span class="fw-bolder">Account BIC:</span>
                                        </div>
                                        <div class="col-md-10 col-8 view">
                                            <span class="my-auto">{{$bank->Details->BIC ?? ""}} </span>
                                        </div>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>
@include('user.layout.modals.payments.payin')
@include('user.layout.modals.payments.payout')
@include('user.layout.modals.payments.bank-account')

@endsection

@push('js')

@endpush
