<div class="modal fade" id="AddCard" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg " data-select2-id="37">
        <div class="modal-content" data-select2-id="36">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @if($auth->verified  || $auth->role == "buyer" )
            <form action="{{route('user.payments.register.card')}}" method="POST" class="add_card_form">
                @csrf
                <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Enter Card Details</h1>
                <div class="modal-body pb-5 px-sm-4 mx-50 row">
                    <div class="col-sm-4">
                        <label>Card Type</label>
                        <select name="card_id" class="form-control">
                            @foreach(paymentCards() as $pCard)
                            <option value="{{$pCard->id}}">{{$pCard->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-8">
                        <label>Card Number</label>
                        <input type="text" class="form-control" placeholder="4242 4242 4242 4242" name="card_no" required>
                    </div>
                    <div class="col-sm-6">
                        <label>Expire Date</label>
                        <input type="text" class="form-control" placeholder="MMYY" name="exp_date" min="4" required>
                    </div>
                    <div class="col-sm-6">
                        <label>Cvv</label>
                        <input type="text" class="form-control" placeholder="123" name="cvv" min="3" required>
                    </div>
                    <button type="submit" class="btn btn-primary me-1 mt-2 waves-effect waves-float waves-light">Submit</button>
                </div>
            </form>
            @else
            <div class="px-5 py-3">
                <h1 class="text-primary">Sorry</h1>
                <p>
                    Your Kyc Verification is in process after verification you can Add Card. 
                </p>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
            @endif
        </div>
    </div>
</div>