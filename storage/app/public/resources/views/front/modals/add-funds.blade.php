<div class="modal fade" id="payin" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" data-select2-id="37">
        <div class="modal-content" data-select2-id="36">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @if($auth->verified || $auth->role == "buyer" )
            <form action="{{route('user.payments.payin')}}" method="POST" class="PayinForm">
                @csrf
                <input type="hidden" name="table_name" value="users">
                <div class="modal-body pb-5 px-sm-4 mx-50">
                    <h3 class="address-title text-center mb-1" id="addNewAddressTitle">Wallet Ballance is not enough</h3>
                    <h6 class="text-warning">Mangopay Service Charges 1.4% + £0.20</h6>
                    <h6 class="text-info"><span class="bolder">Note:</span> Payin amount cannot be greater then £ 1900</h6>
                    <input type="hidden" name="amount" class="payin_amount">
                    <input type="hidden" name="address_id" value="{{$address->id}}">
                    <div class="row">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td>
                                        <span class="fw-bold">Add £ {{$remainingAmt}} :</span>
                                    </td>
                                    <td class="text-end">
                                        <label class="small">Amount ( inc Service Charges )</label>
                                        <div class="d-flex justify-content-end">
                                            <input type="number" step="any" value="{{$remainingAmtCharge}}" class="form-control w-auto rounded-start rounded-0" placeholder="10"  readonly>
                                            <button class="btn btn-site-primary rounded-end rounded-0 payin_while_checkout" {{$remainingAmtCharge > 1900 ? 'disabled' : ''}} data-amt="{{$remainingAmt}}">Add Fund</button>
                                        </div>
                                    </td>
                                </tr>
                                {{--@foreach(payinSuggestionforCheckout() as $suggestion)
                                @if($suggestion != $remainingAmt)
                                <tr>
                                    <td>
                                        <span class="fw-bold">Add  £{{$suggestion}} :</span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <input type="number" step="any" max="1900" class="form-control w-auto rounded-start rounded-0" placeholder="10" value="{{$suggestion+calculatePayinServiceCharges($suggestion)}}"  readonly>
                                            <button class="btn btn-site-primary rounded-end rounded-0 payin_while_checkout" data-amt="{{$suggestion}}">Add Fund</button>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @endforeach--}}
                            </tbody>
                        </table>
                    </div>
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