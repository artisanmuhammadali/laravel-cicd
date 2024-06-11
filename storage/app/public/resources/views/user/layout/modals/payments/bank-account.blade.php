<div class="modal fade" id="bankAccount" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg " data-select2-id="37">
        <div class="modal-content" data-select2-id="36">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @if($auth->verified)
            <form action="{{route('user.payments.bank')}}" method="POST">
                @csrf
                <input type="hidden" name="table_name" value="users">
                <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Enter Account Details</h1>
                <div class="modal-body pb-5 px-sm-4 mx-50">
                    <div class="col-12">
                        <label>IBAN</label>
                        <input type="text" class="form-control" placeholder="FR7630004000031234567890143" min="34" name="iban" required>
                    </div>
                    <div class="col-12">
                        <label>BIC</label>
                        <input type="text" class="form-control" placeholder="BNPAFRPP" name="bic" min="8" required>
                    </div>
                    <button type="submit" class="btn btn-primary me-1 mt-2 waves-effect waves-float waves-light">Submit</button>
                </div>
            </form>
            @else
            <div class="px-5 py-3">
                <h1 class="text-primary">Sorry</h1>
                <p>
                    Your Kyc Verification is in process after verification you can Withdraw Funds to your wallet. 
                </p>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
            @endif
        </div>
    </div>
</div>