<div class="modal fade" id="orderComplete" role="dialog" aria-modal="true">
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
                    <input name="status" type="hidden" value="completed">
                    <h3 class="text-site-primary">Mark Your Order As Completed</h3>
                    <p>
                        You must confirm that you have completed and fully understand the following before
                        marking this order as complete:
                        <ol>
                            <li>You've checked that the items are legitimate and not fake or tampered with see
                            our guide <a class="hover-blue" href="{{getPagesRoute('fake-ccgs-tcgs-tampered')}}">here</a>.</li>
                            <li>The seller has provided the correct item you've bought, including all attributes and conditions.</li>
                            <li>You waive your right to open an issue ticket against this order in the future.</li>
                            <li>The seller will be paid in full and your money will not be refundable past this point.</li>
                        </ol>
                    </p>
                    <div class="text-end">
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
