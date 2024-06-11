<div class="modal fade" id="payin" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" data-select2-id="37">
        <div class="modal-content" data-select2-id="36">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @if($auth->verified || $auth->role == "buyer" )
            <form action="{{route('user.payments.payin')}}" method="POST" class="add_card_form">
                @csrf
                <input type="hidden" name="table_name" value="users">
                <div class="modal-body pb-5 px-sm-4 mx-50">
                    <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Enter Amount you want to add in your wallet</h1>
                    <h5 class="text-warning">Mangopay Service Charges 1.4% + £0.20</h5>
                    <h5 class="text-info"><span class="bolder">Note:</span> Payin amount cannot be greater then £ 1900</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Payin Amount</label>
                            <input type="number" step="any" max="1900" class="form-control first_payin_amt" name="amount" placeholder="10" required>
                        </div>
                        <div class="col-md-6">
                            <label for="">Amount ( inc Service Charges )</label>
                            <input type="number" step="any" max="1900" class="form-control final_payin_amt" placeholder="10"  readonly>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary me-1 mt-2 waves-effect waves-float waves-light">Submit</button>
                </div>
            </form>
            @else
            <div class="px-5 py-3">
                <h1 class="text-primary">Sorry</h1>
                <p>
                    Your Kyc Verification is in process after verification you can Add Funds to your wallet. 
                </p>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
            @endif
        </div>
    </div>
</div>