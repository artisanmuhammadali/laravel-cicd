<div class="modal fade" id="orderRefund" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close btn-clear" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-4">
                <form action="{{route('admin.orders.update',[$order->id,'refunded'])}}" method="Get">
                    @csrf
                    <h4 class="card-title mt-2 text-primary">Order Pricing</h4>
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td class="px-sm-3 px-0">
                                    <span class="fw-bold">Items Price :</span>
                                </td>
                                <td>£ {{$items_price}}</td>
                            </tr>
                            <tr>
                            <td class="d-grid px-sm-3 px-0">
                                <span class="fw-bold">Postage Name :</span>
                                <span class="fw-bold">Postage Service Charges :</span>

                            </td>
                            <td class="px-sm-2 px-1">
                                <div class="d-grid">
                                    <p class="mb-0 text-truncate">
                                        <span>{{$order->postage ? $order->postage->name : "Postage"}}</span>
                                    </p>
                                    <p class="mb-0">
                                        <span> £ {{$main->shiping_charges ?? 0}}</span>
                                    </p>
                                </div>
                            </td>
                            <tr>
                                <td class="px-sm-3 px-0">
                                    <span class="fw-bold">VFS Platform Fee :</span>
                                </td>
                                <td>£ {{$main->fee + $main->referee_credit}} </td>
                            </tr>
                            @if(count($extraPayments) > 0)
                                @foreach($extraPayments as $extra)
                                <tr>
                                    <td class="px-sm-3 px-0">
                                        <span class="fw-bold">{{$extra->credit_user == $order->buyer_id ? "Return Extra Payment To Buyer" : "Send Extra Payment To Seller"}}</span>
                                    </td>
                                    <td>£ {{$extra->amount}}</td>
                                </tr>
                                @endforeach
                            @endif
                            <tr>
                                <td class="px-sm-3 px-0">
                                    <span class="fw-bold">Seller Receive Amount :</span>
                                </td>
                                @php($seller_amount=$main->seller_amount - $main->referee_credit + $extraPrice)
                                <td>£ {{number_format($seller_amount, 2, '.', '')}} {{$main->seller_kyc_return > 0 ?  '( included KYC Return amount )' : ''}}  </td>
                            </tr>
                            <tr>
                                <td class="px-sm-3 px-0">
                                    <span class="fw-bold">Total Order Price :</span>
                                </td>
                                @php($total=$order->total  + $extraPrice)
                                <td>£ {{number_format($total, 2, '.', '')}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d-flex">
                        <div class="d-block col-10">
                            <div class="col-12 mb-2">
                                <label for="refund_with_fee">Refund Complete Amount including Platform Fee</label>
                                <input type="checkbox" id="refund_with_fee" name="refund_with_fee" checked>
                            </div>
                            <div class="col-10">
                                <label>Enter amount for partial refund</label>
                                <input type="number" step="any" min="0.01" max="{{number_format($seller_amount, 2, '.', '')}}" name="refund_amount" class="form-control refund_amount" disabled>
                            </div>
                        </div>
                        <div class="col-2 text-end">
                            <button class="btn btn-primary mt-2"  type="submit">Refund</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>