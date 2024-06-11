<div class="modal fade" id="orderdispatch" role="dialog" aria-modal="true">
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
                    <input name="status" type="hidden" value="dispatched">
                    <h3 class="text-site-primary">Mark Order as Dispatch</h3>
                    <!-- <p>
                        Your cancellation will mark your account negatively and
                        you won't receive commission back
                    </p> -->
                    <label class="fw-bold mt-2" for="tracking_id">Tracking Id</label>
                    <input class="form-control" type="text" name="tracking_id" id="tracking_id" required>
                    <div class="text-end mt-2">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
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
