<div class="modal fade" id="card" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered " data-select2-id="37">
        <div class="modal-content" data-select2-id="36">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('user.payments.register.card')}}" method="POST">
                @csrf
                <input type="hidden" name="table_name" value="users">
                <div class="modal-body pb-5 px-sm-4 mx-50">
                    <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Enter Amount you want to add in your wallet</h1>
                    <h5 class="text-warning">Mangopay Service Charges 1.4% + £0.20</h5>
                    <div class="col-12 text-center position-relative">
                        <input type="text" class="form-control" placeholder="card_no" name="card_no" required>
                        <input type="text" class="form-control" placeholder="exp_date" name="exp_date" required>
                        <input type="text" class="form-control" placeholder="cvs" name="cvs" required>
                    </div>
                    <button type="submit" class="btn btn-primary me-1 mt-2 waves-effect waves-float waves-light">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>