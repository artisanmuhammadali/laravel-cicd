<div class="modal fade pt-3 site-modal" id="checkoutModal" role="dialog" aria-modal="true">
    <div class="modal-dialog mt-5 modal-lg">
        <div class="modal-content">
            <div class="row modal-header text-center p-0">
                <div class="row justify-content-end">
                    <div class="col-11 d-flex justify-content-center text-center">
                        <h4 class="pt-5 text-site-primary">Delivery Address Confirmation</h4>
                        <div class="circle_xsm login-btn-margin close_btn_reset me-sm-0 me-2">
                            <i class="fa fa-close close_icon" data-bs-dismiss="modal" aria-label="Close"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body px-0">
                <div class="login-form py-0">
                    <form action="{{route('checkout')}}" method="POST" class="text-center checkout_form">
                        @csrf
                        <input type="hidden" name="total" value="{{$total}}">
                        <input type="hidden" name="final_total" value="{{$final_total}}">
                        <input type="hidden" name="complete_total" value="{{$complete_total}}">
                        <input type="hidden" name="platform_fee" value="{{$platformFee}}">
                        <input type="hidden" name="ref_credit" value="{{$refCredit}}">
                        <input type="hidden" name="ref_credit_fee" value="{{$refCredPlatformFee}}">
                        <label class="mb-2">Select Address where you want to deliever this order</label>
                        <div class="row justify-content-around">
                            @foreach($auth->address as $address)
                            <div class="border px-2 py-3 col-md-5 my-2">
                                <div class="form-check row">
                                    <div class="col-1">
                                    <input class="form-check-input col-1" type="radio" name="address_id"
                                        id="addressRadio{{$address->id}}" value="{{$address->id}}" {{$loop->iteration -1 == 0 ? "checked" : "" }}>
                                    </div>
                                    <div class="col-11">
                                        <label class="form-check-label text-start col-11" for="addressRadio{{$address->id}}">
                                            <div class="d-flex justify-content-between mb-2">
                                                <p class="fs-6 fw-bold m-0">{{$address->name}}</p>
                                                @if($address->type == "primary")
                                                <span class="badge bg-site-primary">{{$address->type}}</span>
                                                @endif
                                            </div>
                                            <p class="fs-6 m-0">{{$address->street_number}}</p>
                                            <p class="fs-6 m-0">{{$address->city}}</p>
                                            <p class="fs-6 m-0">{{$address->postal_code}}</p>
                                            <p class="fs-6 m-0">{{$address->country}}</p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button class="btn btn-site-primary mt-4 checkout_btn" type="submit">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
