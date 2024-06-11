<div class="modal fade" id="orderDispute" role="dialog" aria-modal="true">
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
                    <input name="status" type="hidden" value="dispute">
                    <h3 class="text-site-primary">Open Dispute for this Order</h3>
                    <label for="reason">Reason</label>
                    <textarea name="reason" class="form-control" required></textarea>
                    <div class="text-end mt-2">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary submit_btn">
                            Submit
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