@extends('admin.layout.app')
@section('title','Withdraw Detail')
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
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 col-12 px-50 mb-2 py-auto">
                                <div class="card py-auto h-100">
                                    <div class="card-header">
                                        <h4 class="card-title">Withdraw Detail</h4>
                                    </div>
                                    <hr>
                                    <div class="card-body h-100">
                                        <div class="row">
                                            <div class="col-md-4 col-6">
                                                <p class="fw-bold">User:</p>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <p>{{$item->user->user_name ?? 'User'}}</p>
                                            </div>
                                            <div class="col-md-4 col-6">
                                                <p class="fw-bold">Status:</p>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <span class="bagde {{$bg}} text-white p-25 rounded text-capitalize" >{{$item->status ?? 'pending'}}</span>
                                            </div>
                                            <div class="col-md-4 col-6">
                                                <p class="fw-bold">Transaction id:</p>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <p>{{$item->transaction_id ?? 'N/A'}}</p>
                                            </div>
                                            <div class="col-md-4 col-6">
                                                <p class="fw-bold">Amount:</p>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <p>£ {{$item->amount}}</p>
                                            </div>
                                            <div class="col-md-4 col-6">
                                                <p class="fw-bold">Updated By:</p>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <p>{{$item->updated_by ? $item->admin->user_name : 'N/A'}}</p>
                                            </div>
                                            @if($item->status == "rejected")
                                            <div class="col-md-4 col-6">
                                                <p class="fw-bold">Reason:</p>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <p>{{$item->reason ?? 'N/A'}}</p>
                                            </div>
                                            @endif
                                            <div class="col-md-4 col-6">
                                                <p class="fw-bold">Created at:</p>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <p>{{$item->created_at->format('Y/m/d')}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                @if($item->status == "pending")
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Withdraw Action</h4>
                                    </div>
                                    <hr>
                                    <div class="card-body">
                                        <form action="{{route('admin.account.withdraw.update')}}" method="post" enctype="multipart/form-data" class="submit_form">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$item->id ?? ""}}">
                                            <div class="modal-body">
                                                <label>Amount</label>
                                                <input class="form-control title_box" name="name" value="{{$item->amount ?? ""}}" readonly type="text">
                                                <label>Status</label>
                                                <select name="status" class="form-select payoutOption" required>
                                                    <option class="form-control" value="approved">Approve</option>
                                                    <option class="form-control" value="rejected">Reject</option>
                                                </select>
                                                <div class="payoutBody"></div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-6 col-12 px-50 mb-md-0 mb-2 py-auto">
                                <div class="card py-auto h-100">
                                    <div class="card-header">
                                        <h4 class="card-title">User Wallets</h4>
                                    </div>
                                    <hr>
                                    <div class="card-body h-100">
                                        <div class="row">
                                            <div class="col-md-6 col-6">
                                                <p class="fw-bold">Mangopay Wallet Amount:</p>
                                            </div>
                                            <div class="col-md-6 col-6">
                                                <p>£ {{$walletAmount}}</p>
                                            </div>
                                            <div class="col-md-6 col-6">
                                                <p class="fw-bold">Referral Wallet Amount:</p>
                                            </div>
                                            <div class="col-md-6 col-6">
                                                <p>£ {{$user->store ? $user->store->vfs_wallet : 0}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 px-50 mb-md-0 mb-2 py-auto">
                                <div class="card py-auto h-100">
                                    <div class="card-header">
                                        <h4 class="card-title">User Bank Detail</h4>
                                    </div>
                                    <hr>
                                    <div class="card-body h-100">
                                        <div class="row">
                                            <div class="col-md-4 col-6">
                                                <p class="fw-bold">Account IBAN:</p>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <p>{{$bank->Details->IBAN ?? ""}}</p>
                                            </div>
                                            <div class="col-md-4 col-6">
                                                <p class="fw-bold">Account BIC:</p>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <p>{{$bank->Details->BIC ?? ""}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 px-50 mb-md-0 mb-2 py-auto">
                                <div class="card py-auto h-100">
                                    <div class="card-header">
                                        <h4 class="card-title">User Transactions</h4>
                                    </div>
                                    <hr>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                        {{ $dataTable->table(['class' => 'table text-center table-striped w-100'],true) }}
                                        </div>
                                    </div>
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
<script>
    $(document).on('change', '.payoutOption', function () {
        var val =$(this).val(); 
        $('.payoutBody').empty();
        $('label[for="reason"], input[name="reason"]').remove();
        var reason = `
            <label for="reason">Reason</label>
            <textarea name="reason" class="form-control" cols="40" rows="5" required></textarea>
            `;

        val == 'rejected' ? $('.payoutBody').append(reason) : '';
    })

</script>
@endpush
