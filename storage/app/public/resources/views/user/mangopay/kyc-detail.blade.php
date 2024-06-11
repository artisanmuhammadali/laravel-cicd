@extends('user.layout.app')
@section('title','KYC')
@push('css')
@endpush
@section('content')
<div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
    <div class="content-body">
        <section
            class="app-user-app-user-view-account d-flex justify-content-center-account justify-content-center overflow-hidden">
            <div class="row w-100">
                <div class="col-xl-4 col-lg-5 col-md-5 ">
                    @include('user.components.userCard')
                </div>
                <div class="col-xl-8 col-lg-7 col-md-7">
                    @include('user.components.action-list')

                    @if(vfsWebConfig())
                    @if($user->store->role_change || count($kycs) == 0)
                    <div id="account-details" class="
                        active dstepper-block" role="tabpanel" aria-labelledby="account-details-trigger">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h1 class="address-title text-center card-title fw-bolder" id="addNewAddressTitle">Kyc
                                    Verification</h1>
                            </div>
                            <div class="card-body pt-1">
                                <p>
                                    Upload your KYC Documents.
                                </p>
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
                            <div class="modal-body px-sm-4 mx-50 pb-2">

                                <div class="col-12 text-center position-relative">
                                    <input type="hidden" class="form-control" name="amount"
                                        value="{{$auth->role == "seller" ? 1 : 5}}">
                                    <input type="hidden" class="form-control" name="fee"
                                        value="{{$auth->role == "seller" ? 1 : 5}}">
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <a href="{{route('user.mangopay.upload.kyc')}}" type="button"
                                        class="btn btn-primary me-1 waves-effect waves-float waves-light">Upload Your
                                        Kyc</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    @else
                    <div class="row">
                        @foreach($kycs as $kyc)
                        @if(kycShowFilter($kyc))
                            @php($item=getKyc($kyc))
                            <div class="col-md-6 h-100">
                                <div class="card {{$item->class}} text-white h-100">
                                    <div class="card-body">
                                        <h4 class="card-title text-white">{{$item->name}}</h4>
                                        <p class="card-text">Created on : {{$item->date->format('Y/m/d')}}</p>
                                        <p class="card-text text-capitalize">Status : {{$item->status}}</p>
                                        @if($item->note !='')
                                        <p class="card-text text-capitalize">Note : {{$item->note}}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        @endforeach
                        @if(checkKycFailed())
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h1 class="address-title text-center card-title fw-bolder" id="addNewAddressTitle">
                                        KYC
                                        Verification</h1>
                                </div>
                                <div class="card-body pt-1">
                                    <p>
                                        Re-Upload your KYC Documents.
                                    </p>
                                </div>
                                <div class="modal-body px-sm-4 mx-50 pb-2">

                                    <div class="col-12 text-center position-relative">
                                        <input type="hidden" class="form-control" name="amount"
                                            value="{{$auth->role == "seller" ? 1 : 5}}">
                                        <input type="hidden" class="form-control" name="fee"
                                            value="{{$auth->role == "seller" ? 1 : 5}}">
                                    </div>
                                    <div class="col-12 d-flex justify-content-center">
                                        <a href="{{route('user.mangopay.reupload.kyc')}}" type="button"
                                            class="btn btn-primary me-1 waves-effect waves-float waves-light">Upload
                                            Your
                                            Kyc</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($user->kyb && $user->kyb->mangopay_response == "Failed")
                        <div class="col-md-6">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <h4 class="card-title text-white">KYB Detail</h4>
                                    <p class="card-text text-capitalize">Status : denied</p>
                                    <form action="{{route('user.mangopay.details')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="role" value="{{$auth->role}}">
                                        <input type="hidden" name="update" value="1">
                                        <button class="btn btn-secondary">Update Detail</button>
                                    </form>
                                    <p class="card-text text-capitalize"></p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($auth->store && $auth->store->kyc_payment == 0)
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h1 class="address-title text-center card-title fw-bolder" id="addNewAddressTitle">
                                        £{{$auth->role == "business" ?  '5.5' : '1.5'}} Payment for Kyc Verification</h1>
                                </div>
                                <div class="card-body pt-1">
                                <p>
                                    <b>Fee Explation : </b> {{$auth->role == "business" ?  '£5 KYB check fee' : '£1 KYC check fee'}} ,  {{$auth->role == "business" ?  '£0.27 service charges' : '£0.22 service charges'}} ,
                                    {{$auth->role == "business" ?  '£0.23 credit to your wallet' : '£0.28 credit to your wallet'}}
                                </p>
                                    <p>
                                    This KYC check fee will be fully refunded out of your first sales. This is a mandatory
                                    payment from our PSP, Mangopay, for AML checks, and it deters scammers from joining
                                    our platform.
                                    </p>
                                </div>
                                @if($user->verified)
                                <form action="{{route('user.payments.payin')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="table_name" value="users">
                                    <div class="modal-body px-sm-4 mx-50 pb-2">

                                    <div class="col-12 text-center position-relative">
                                        <input type="hidden" class="form-control" name="amount"
                                            value="{{$auth->role == "seller" ? 0.28 : 0.23}}">
                                        <input type="hidden" class="form-control" name="fee"
                                            value="{{$auth->role == "seller" ? 1.22 : 5.27}}">
                                    </div>

                                        <div class="col-12 d-flex justify-content-center">
                                            @if($user->store->kyc_payment == 0 && $user->store->kyc_payment_id )
                                            <p>Please wait your payment is processing.</p>
                                            @else
                                            <button type="submit"
                                                class="btn btn-primary me-1 waves-effect waves-float waves-light">Proceed
                                                to Payment</button>
                                            @endif
                                        </div>

                                    </div>
                                </form>
                                @else
                                <div class="card-body">
                                    <p>
                                        Your KYC/KYB verification is in process.
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
                    @else
                    <div id="account-details" class="
                     active dstepper-block" role="tabpanel" aria-labelledby="account-details-trigger">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h1 class="address-title text-center card-title fw-bolder" id="addNewAddressTitle">Kyc
                                    Verification</h1>
                            </div>
                            <div class="card-body pt-1">
                                <p>
                                    KYC verification will start when the website goes live.
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

        </section>
    </div>
</div>
@endsection