@extends('user.layout.app')
@section('title','Banking')
@push('css')
    <link rel="stylesheet" href="{{ asset('user/css/dataTables.bootstrap5.min.css') }}"/>
@endpush
@section('content')
<div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
    <div class="content-body">
        <section class="app-user-app-user-view-account d-flex justify-content-center-account justify-content-center overflow-hidden  ps-md-2">
            <div class="row w-100" id="table-hover-row">
                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-body pt-1">
                            <div class="card-header px-0 border-bottom pb-75 pt-0">
                                <h4 class="fw-bolder my-2">Wallet</h4>
                                <div>
                                    @if(vfsWebConfig())
                                    <button data-bs-toggle="modal" data-bs-target="#payin" class="btn btn-primary mb-sm-0 mb-1" title="Add Funds" onclick="gatherBrowserInfo()">Add Funds</button>
                                        @if($auth->role != 'buyer' && getOrderCount('completed' , 'sell') >= 1)
                                        <button data-bs-toggle="modal" data-bs-target="#payout"  class="btn btn-primary mb-sm-0 mb-1" title="Withdraw Funds">Withdraw Funds</button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="info-container">
                                <ul class="list-unstyled">
                                    <li class="mb-75 justify-content-between d-flex">
                                        <div class="col-sm-9 col-7 pt-75">
                                            <span class=" font_amount">Very Friendly Sharks Credit</span>
                                        </div>
                                        <div class="col-sm-3 col-5 d-flex">
                                            <span class="fw-bolder mt-75 font_amount text-white bagde w-100 text-center bg-light-success p-25 rounded-2 d-flex align-items-center">£ {{getUserWallet()}} </span>

                                        </div>
                                    </li>
                                    <li class="mb-75 justify-content-between d-flex">
                                        <div class="col-sm-9 col-7  pt-75">
                                            <span class=" font_amount">Very Friendly Sharks Referral Credit</span>
                                        </div>
                                        <div class="col-sm-3 col-5 d-flex">
                                            <span class="fw-bolder mt-75 font_amount text-white bagde w-100 text-center bg-light-warning p-25 rounded-2 d-flex align-items-center">£ {{$auth->store->vfs_wallet ?? 0}} </span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    @if($auth->role != 'buyer')
                    <div class="card">
                        <div class="card-body pt-1">
                            <div class="d-flex border-bottom justify-content-between pb-1 mb-1">
                                <h4 class="fw-bolder my-auto">Bank Account</h4>
                                @if(!$store->mangopay_account_id || empty($bank->Details->IBAN) && vfsWebConfig())
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
                @if(count($withdraw_request) > 0)
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Withdrawal Request</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover datatables">
                                    <thead>
                                        <tr>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Reason</th>
                                            <th>Created on</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($withdraw_request as $item)
                                        <tr>
                                            <td>
                                                £ {{$item->amount}}
                                            </td>
                                            <td>
                                                @if($item->status == "pending")
                                                <span class="badge bg-primary text-capitalize">{{$item->status}}</span>
                                                @endif
                                                @if($item->status == "rejected")
                                                <span class="badge bg-danger text-capitalize">{{$item->status}}</span>
                                                @endif
                                                @if($item->status == "approved")
                                                <span class="badge bg-success text-capitalize">{{$item->status}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <p class="text-capitalize">
                                                    {{$item->status == 'rejected' ? $item->reason : $item->status}}
                                                </p>
                                            </td>
                                            <td>
                                                {{$item->created_at->format('Y/m/d')}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                {{-- <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Transactions</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover datatables">
                                    <thead>
                                        <tr>
                                            <th>Transaction Id</th>
                                            <th>Amount</th>
                                            <th>Platform Fee</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Created on</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transactions as $item)
                                        <tr>
                                            <td>
                                                {{$item->Id}}
                                            </td>
                                            <td>
                                                £ {{$item->CreditedFunds->Amount/100}}
                                            </td>
                                            <td>
                                                £ {{$item->Fees->Amount/100}}
                                            </td>
                                            <td>
                                                @if($item->Type == "PAYIN")
                                                   <span class="badge bg-warning">{{$item->Type}}</span>
                                                @else
                                                   <span class="badge bg-primary">{{$item->Nature == "REFUND" ? "REFUND": $item->Type}}{{$item->Nature != "REFUND" ? ($item->CreditedUserId == $auth->store->mango_id ? "-CREDIT" : "-DEBIT") : ''}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->Status == "FAILED")
                                                    <span class="badge bg-danger">FAILED</span>
                                                @else
                                                    <span class="badge {{$item->Status == "SUCCEEDED" ? 'bg-success' : 'bg-primary'}}">{{$item->Status}}</span>
                                                @endif
                                            </td>

                                            <td>
                                                @php($date=dateFromTimestamp($item->CreationDate)->format('d/m/Y'))
                                                {{$date}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </section>
    </div>
</div>
@php($charges = paymentCharges())
@include('user.layout.modals.payments.payin')
@include('user.layout.modals.payments.register-card')
@include('user.layout.modals.payments.add-card')
@include('user.layout.modals.payments.payout')
@include('user.layout.modals.payments.bank-account')
@endsection

@push('js')
<script src="{{asset('user/js/jquery.dataTable.min.js')}}"></script>
<script>
    let ip , userAgent , language , javaEnable , colorDepth , screenHeight , screenWidth , timeZone , JavaScriptEnable = false;
    $(document).ready(function(){

           // Datatable Initalized
           var table = $('.datatables').DataTable({
               "sort": false,
               "ordering": false,
               "pagingType": "full_numbers",
               responsive: true,
               language: {
                   search: "_INPUT_",
                   searchPlaceholder: "Search records",
               }
           });
       });
       $(document).on('keyup','.first_payin_amt',function(){
            var val = parseFloat($(this).val());
            if(!isNaN(val))
            {
                var serviceCharges = {!! json_encode($charges) !!};
                var charges = (val/100)*(serviceCharges.percentage)+(serviceCharges.additional);
                var n = val+parseFloat(charges);
                n= n.toFixed(2);
                $('.final_payin_amt').val(n);
            }
        });
</script>
@endpush
