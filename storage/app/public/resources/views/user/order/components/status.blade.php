@php($conditoin_for_seller=$order->status == "dispatched" && $auth->id ==
$order->seller->id)

@if($order->status == "pending" && !$conditoin_for_seller)
<div class="row">
    @if($type == "sell")
    <div class="alert alert-danger px-1 mt-1" role="alert">
        Before dispatching, please remember to get tracking id of this order to share with your customer.
      </div>
    @endif
    <div class="col-12 d-flex justify-content-center mt-3">
        <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#ordercancel">
            Cancel
        </button>
    </div>
    @if($type == "sell")
    <div class="col-12 d-flex justify-content-center mt-1">
        <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#orderdispatch">
            Dispatch
        </button>
    </div>
    @endif
</div>
@endif
@if($order->status == "dispatched" && !$conditoin_for_seller)
<div class="col-12">
    @if($btn_show_condition <= 0)
    <div class="alert alert-info rounded-0" role="alert">
        <div class="alert-body d-flex justify-content-between align-items-center">
            <p class="font-sm-12"><span class=" fw-bolder"><i class="fa-solid fa-circle-info fs-6 me-25"></i></span>Order Status update option will be available after 24 hours from the dispatch of the order.</p>
        </div>
    </div>
    @else
    <label>Mark Order as</label>
    <div class="d-flex justify-content-center gap-2 mt-3">
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#orderDispute">
            Dispute
        </button>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#orderComplete">
            Complete
        </button>
    </div>
    @endif
</div>
@endif
<button type="submit" class="btn btn-primary float-end mt-2 waves-effect waves-float waves-light SubmitBtn d-none">Submit</button>