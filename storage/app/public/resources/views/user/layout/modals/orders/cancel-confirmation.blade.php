<div class="modal fade" id="ordercancel" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close btn-clear" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-4">
                <form action="{{route('user.order.update')}}" class="submit_form" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$id}}">
                    <input type="hidden" name="type" value="{{$type}}">
                    <input name="status" type="hidden" value="cancelled">
                    <h3 class="text-site-primary">Mark Order as Cancelled</h3>
                    <p>Your cancellation will have a negative impact on your account {{$auth->id == $order->seller_id ? "" : ", and you will not receive a commission refund until the seller has not dispatched the order within 7 days"}}.</p>
                    <div class="text-end mt-2">
                        <button type="submit" class="btn btn-success submit_btn">
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
