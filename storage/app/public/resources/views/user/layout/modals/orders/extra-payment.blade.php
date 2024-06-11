<div class="modal fade" id="extraPayment" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close btn-clear" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-4">
                <form action="{{route('user.order.extra.payment')}}" class="submit_form" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" value="{{$id}}">
                    <input type="hidden" name="type" value="{{$type}}">
                    <h3 class="text-site-primary">{{$type == "buy" ? "Send Extra Payment to Seller" : "Refund to Buyer"}}</h3>
                    @if($type == "sell")
                    <div class="alert alert-warning rounded-0" role="alert">
                        <div class="alert-body d-md-flex justify-content-between align-items-center px-sm-5  px-25 d-block">
                            <p class="font-sm-12"><span class=" fw-bolder"><i class="fa-solid fa-circle-info fs-6 me-25"></i></span>You can initiate a return payment even if your wallet balance is insufficient. This payment will be sourced from the pending amount of your order.</p>
                        </div>
                    </div>
                    @endif
                    <label class="fw-bold mt-2" for="tracking_id">Amount</label>
                    <input class="form-control" type="number" step="any" name="amount" id="amount" required  max="{{$auth->id == $order->buyer_id ? $main->shiping_charges : number_format($seller_amount, 2, '.', '')}}" min="0.01">
                    <div class="text-end mt-2">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-success">
                            Done
                        </button>
                    </div>
                    @error('status')
                    <p class="text-danger text-start">{{ $message }}</p>
                    @enderror
                    @error('tracking_id')
                    <p class="text-danger text-start">{{ $message }}</p>
                    @enderror
                    @error('reason')
                    <p class="text-danger text-start">{{ $message }}</p>
                    @enderror
                </form>
            </div>
        </div>
    </div>
</div>
