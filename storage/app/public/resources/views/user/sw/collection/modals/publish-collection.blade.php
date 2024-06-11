<div class="modal fade" id="publishCollection" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            @if($auth->store && $auth->store->kyc_payment == 0)
            <div class="card-header border-bottom">
                <h1 class="address-title text-center card-title fw-bolder" id="addNewAddressTitle">
                    £{{$auth->role == "business" ?  '5.5' : '1.5'}} Payment for Kyc Verification</h1>
            </div>
            <div class="card-body pt-1">
                <p>
                    <b>Fee Explation : </b> {{$auth->role == "business" ?  '£5 KYB check fee' : '£1 KYC check fee'}} ,  {{$auth->role == "business" ?  '£0.27 service charges' : '£0.22 service charges'}} ,
                    {{$auth->role == "business" ?  '£0.23 credit to your wallet' : '£0.28 credit to your wallet'}}
                </p>
                <p>
                    This KYC check fee will be fully refunded out of your first sales. This is a mandatory
                    payment from our PSP, Mangopay, for AML checks, and it deters scammers from joining
                    our platform.
                </p>
            </div>
            <form action="{{route('user.payments.payin')}}" method="POST">
                @csrf
                <input type="hidden" name="table_name" value="users">
                <div class="modal-body px-sm-4 mx-50 pb-2">

                    <div class="col-12 text-center position-relative">
                        <input type="hidden" class="form-control" name="amount"
                            value="{{$auth->role == "seller" ? 0.28 : 0.23}}">
                        <input type="hidden" class="form-control" name="fee"
                            value="{{$auth->role == "seller" ? 1.22 : 5.27}}">
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        @if($auth->store->kyc_payment == 0 && $auth->store->kyc_payment_id )
                        <p>Please wait your payment is processing.</p>
                        @else
                        <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light">Proceed
                            to Payment</button>
                        @endif
                    </div>
                </div>
            </form>
            @else
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Publish Collection</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>
                    All the selected items will be listed for sale.
                </p>
            </div>
            <div class="modal-footer">
                <form action="{{route('user.collection.sw.save')}}" method="POST">
                    @csrf
                    <button data-form="publish" data-publish="1" data-link="{{route('user.collection.sw.save')}}" type="button" class="submit_collection_formm btn btn-primary waves-effect waves-float waves-light">Sure</button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
</div>
