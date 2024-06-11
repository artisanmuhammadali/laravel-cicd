<div class="modal fade" id="payout" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" data-select2-id="37">
        <div class="modal-content" data-select2-id="36">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @if($store->mangopay_account_id)
                @if($count >= 1)
                <div class="modal-body pb-5 px-sm-4 mx-50">
                    <p>Your withdrawal request is currently pending for approval. Please wait for the approval of the withdrawal request, and after that, you can submit another request. Thank you.</p>
                </div>
                @else
                <form action="{{route('user.payments.payout')}}" method="POST">
                    @csrf
                    <input type="hidden" name="table_name" value="users">
                    <div class="modal-body pb-5 px-sm-4 mx-50">
                        <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Enter Amount you want to widthdraw from your vfs wallet to bank account</h1>
                        <h5 class="text-warning">Mangopay Service Charges £{{$payout_fee_msg}} for {{$payout_fee_msg == 2 ? 'non' : ''}} domestic widthdraw</h5>
                        <div class="col-12 text-center position-relative">
                            <input type="number" step="any" max="{{getUserWallet()}}" class="form-control" placeholder="10" name="amount" required>
                        </div>
                        <button type="submit" class="btn btn-primary me-1 mt-2 waves-effect waves-float waves-light">Submit</button>
                    </div>
                </form>
                @endif
            @else
            <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Attach Your Bank Account to Widthdraw ammount from Mangopay Wallet</h1>
            <button  data-bs-target="#bankAccount" data-bs-toggle="modal" data-bs-dismiss="modal" class="btn btn-primary m-auto mb-4" >Attach Bank Account</button>
            @endif
        </div>
    </div>
</div>