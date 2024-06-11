@php($typee = $typee ?? null)
<div class="col-lg-12 col-12 order-1 order-lg-2">
    <div class="card">
        <div class="card-header py-2">
            @if($view == "collection")
            <p class="m-0 ms-auto fw-bolder">Active Collection Value : £{{$active_sum ?? 0}}</p>
            <p class="m-0 ms-2 fw-bolder">Inactive Collection Value : £{{$inactive_sum ?? 0}}</p>
            @endif
            @if($view == "referal")
            <p class="m-0 ms-auto fw-bolder">Total Commision Value : £{{$commision_sum ?? 0}}</p>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if($typee == 'transactions')
                 <div class="col-12">
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
                                                   <span class="badge bg-primary">{{$item->Nature == "REFUND" ? "REFUND": $item->Type}}{{$item->Nature != "REFUND" ? ($item->CreditedUserId == $user->store->mango_id ? "-CREDIT" : "-DEBIT") : ''}}</span>
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
                </div> 
                @else
            {{ $dataTable->table(['class' => 'table text-center table-striped w-100'],true) }}
            @endif
            </div>
        </div>
    </div>
</div>