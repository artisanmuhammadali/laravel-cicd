@extends('layouts.app')
@section('title','Checkout')
@push('css')
@endpush
@section('content')

<section>
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12 text-center my-3">
                <h1>Order Summary</h1>
            </div>
            <div class="col-md-8">
                <div class="row cart-card">
                    <h4 class="mb-2">Delivery Address</h4>
                    <div class="px-2 py-3 col-md-5 my-2 me-auto col-md-12">
                        <div class="form-check row">
                            <div class="col-12">
                                <label class="form-check-label text-start col-11 w-100" for="addressRadio{{$address->id}}">
                                    <div class="d-flex justify-content-between mb-2">
                                        <div class="d-flex">
                                            <p class="fs-6 fw-bold m-0 me-3">{{$address->name}}</p>
                                            @if($address->type == "primary")
                                            <span class="badge bg-site-primary text-capitalize">{{$address->type}}</span>
                                            @endif
                                        </div>
                                        <div class="d-flex">
                                            <a href="{{route('cart.index')}}" class="me-3  hover-blue">Change</a>
                                        </div>
                                    </div>
                                    <p class="fs-6 m-0">{{$address->street_number}}</p>
                                    <p class="fs-6 m-0">{{$address->city}}</p>
                                    <p class="fs-6 m-0">{{$address->postal_code}}</p>
                                    <p class="fs-6 m-0">{{$address->country}}</p>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row cart-card mt-5">
                    <h4 class="mb-2">Postage Service Detail</h4>
                    @foreach($postages as $postage)
                    @foreach($postage as $key=> $post)
                    <div class="border px-2 py-3 col-md-5 my-2 me-auto col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td>
                                        <span class="fw-bold">For Seller :</span>
                                    </td>
                                    <td>{{getUserName($key)}}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="fw-bold">Service Name :</span>
                                    </td>
                                    <td>{{$post->name}}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="fw-bold">Service Charges :</span>
                                    </td>
                                    <td>£ {{$post->price}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                    @endforeach
                </div>
            </div>
            <div class="col-md-4 px-md-3 pt-md-0 px-0 pt-3">
                <div class="card p-3 cart-card border-0">
                    <h3 class="m-auto bold mb-3">Cart Summary</h3>
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>
                                    <span class="fw-bold">Total Collections :</span>
                                </td>
                                <td>{{$total_collections}}</td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-bold">Total Items :</span>
                                </td>
                                <td>{{$total_items}}</td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-bold">Items Price :</span>
                                </td>
                                <td>£ {{$total}}</td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-bold">Platform Fee :</span>
                                </td>
                                <td>£ {{$platformFee}}</td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-bold">Postage Service :</span>
                                </td>
                                <td>£ {{$postage_price ?? 0}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <h3 class="m-auto bold mb-3">Funds Deduction</h3>
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>
                                    <span class="fw-bold">Your Wallet :</span>
                                </td>
                                <td>{{$actual_wallet == 0 ? 'Funds Not Available' : '£ '.$actual_wallet}}</td>
                            </tr>
                            @if($referal_wallet > 0)
                            <tr>
                                <td>
                                    <span class="fw-bold">Referral Wallet :</span>
                                </td>
                                <td>{{$referal_wallet == 0 ? 'Funds Not Available' : '£ '.$referal_wallet}}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <p class="fs-5 mt-3 fw-bold text-primary">
                        <span class=" text-black">Total Price :</span>
                        £ {{$final_total + $vat}} 
                        {{-- + <span class="fs-5 text-black fw-normal">{{$pspConfig->vat_percentage}}% VAT</span> --}}
                    </p>
                    @if($complete_total <= getUserWallet())
                    <form action="{{route('checkout.proceed')}}" method="POST" class="text-center checkout_form">
                        @csrf
                        <input type="hidden" name="complete_total" value="{{$complete_total}}">
                        <input type="hidden" name="address_id" value="{{$address->id}}">
                        <button class="btn btn-site-primary w-100 checkout_btn" {{$final_total ? "" : "disabled"}} data-bs-toggle="modal"
                        data-bs-target="#checkoutModal">Buy Now</button>
                    </form>
                    @else
                    <button class="btn btn-site-primary w-100" data-bs-toggle="modal" data-bs-target="#payin" {{$final_total ? "" : "disabled"}} >Add Funds</button>
                    @endif
                    <span class="fs-6 mt-3">
                        By placing your order you agree to our <a class="hover-blue" href="{{route('terms')}}">Terms & Conditions</a>
                    </span>
                </div>
            </div>
            <div class="col-md-12 p-0 mt-3">
                <div class="card p-4 cart-card border-0">
                    <h4 class="mb-2">Review Items</h4>
                    <div class="table-responsive">
                        @if(count($data) > 0)
                        @foreach($data as $key => $items)
                        <div class="alert alert-primary rounded-0">Seller Name: {{getUserName($key)}} - <a target="_blank" href="{{route('profile.index',getUserName($key))}}">Visit Seller's Store</a></div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Card</th>
                                    <th scope="col">Lan</th>
                                    <th scope="col">
                                        <span class="d-md-block d-none">Characteristics</span>
                                        <span class="d-block d-md-none">Char</span>
                                    </th>
                                    <th scope="col">Price</th>
                                    <th scope="col" class="d-md-block d-none">Subtotal</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $key=> $item)
                                <tr>
                                    <td>
                                        <div class="d-md-flex d-block">
                                            <img class="px-1 png img_size_hover myDIV h4Btn d-md-block d-none" src="{{$item->collection->card->png_image}}" alt="" width="70">
                                            <i class="fa fa-camera myDIV h4Btn d-md-none d-block pe-1"></i>
                                            <div class="hide hand h4">
                                                <img loading="lazy" src="{{$item->collection->card->png_image}}" class="px-1 png tab_img_hover" width="250" alt="">
                                            </div> 
                                            <p class="mb-0 fs-6 product-listing-mobile-text">{{$item->collection->card->name}}</p>
                                        </div>
                                    </td>
                                    <td>
                                        @if($item->collection->mtg_card_type == "completed")
                                        <div class="d-flex">
                                            <div class="d-block">
                                            @foreach(json_decode($item->collection->language) as $key =>$lang)
                                                    <span class="speechbubble p-1 z6 text-black text-uppercase product-listing-mobile-text">{{$key}}</span>
                                            @endforeach
                                            </div>
                                        </div>
                                        @else
                                        <div class="d-block">
                                            @php($langTitle=languageFromCode($item->collection->language))
                                            <span class="speechbubble p-1 z6 text-black text-uppercase product-listing-mobile-text" title="{{$langTitle}}">{{$item->collection->language}}</span>
                                        </div>
                                        @endif
                                    </td>
                                    <td>
                                    <div class="row d-flex">
                                            <div class="col-md-3 pe-0 text-center">
                                                <div class="text-bg-primary text-center rounded" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$item->collection->condition_name}}">
                                                    <p class="text-uppercase small text-truncate product-listing-mobile-text">{{$item->collection->condition}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-9 text-center">
                                                <img loading="lazy" width="20" src="{{$item->collection->char_signed}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Signed" alt="">
                                                <img loading="lazy" width="20" src="{{$item->collection->char_altered}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Altered" alt="">
                                                <img loading="lazy" width="20" src="{{$item->collection->char_graded}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Graded" alt="">
                                                <img loading="lazy" width="20" src="{{$item->collection->char_foil}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Foil" alt="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="product-listing-mobile-text text-truncate">£ {{$item->price}}</span>
                                        <span class="d-md-none d-block text-secondary fs-bread mt-2">{{$item->quantity ?? 0}} select</span>
                                    </td>
                                    
                                    <td class="d-md-table-cell d-none"><span class="product-listing-mobile-text">£ {{$item->quantity * $item->price}}</span></td>
                                    <td>
                                        @include('front.components.cart.options',['item'=>$item->collection ,'class'=>'cartIndex'])
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endforeach
                        @else
                        <div class="alert alert-primary rounded-0">No Item in your Cart</div>
                        @endif
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
@include('front.modals.add-funds')
@endsection

@push('js')
<script>
    $(document).on('click' , '.payin_while_checkout',function(){
        var amt = $(this).attr('data-amt');
        $('.payin_amount').val(amt);
        $('.PayinForm').submit();
    })
</script>
@endpush
