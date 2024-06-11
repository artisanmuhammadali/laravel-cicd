@extends('layouts.app')
@section('title','Cart')
@push('css')
@endpush
@section('content')

<section>
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12 text-center my-3">
                <h1>My Cart</h1>
            </div>
            @if(count($data) > 0)
            <div class="col-12">
                <div class="alert alert-warning rounded-0 mt-3 ">Your Cart will be empty after 24 hours.</div>
            </div>
            <div class="col-12">
                <form action="{{$final_total ? route('checkout.confirm') : "#"}}" method="GET" class=""> 
                    <div class="row justify-content-center">
                        <div class="col-md-8 mb-md-0 mb-2">
                            <div class="cart-card">
                                <div class="row">
                                    <div class="col-md-9">
                                        <h4 class="mb-2">Select Address where you want to deliever this order</h4>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <a href="{{route('user.address.index')}}" class="btn btn-site-primary">Add Address</a>
                                    </div>
                                </div>
                                @foreach($auth->address as $address)
                                <div class="border px-2 py-3 col-md-5 my-2 me-auto col-md-12">
                                    <div class="form-check row">
                                        <div class="col-1">
                                        <input class="form-check-input col-1" type="radio" name="address_id"
                                            id="addressRadio{{$address->id}}" value="{{$address->id}}" {{$loop->iteration -1 == 0 ? "checked" : "" }}>
                                        </div>
                                        <div class="col-11">
                                            <label class="form-check-label text-start col-11 w-100" for="addressRadio{{$address->id}}">
                                                <div class="row justify-content-between mb-2">
                                                    <div class="col-sm-6 d-flex">
                                                        <p class="fs-6 fw-bold m-0 me-3">{{$address->name}}</p>
                                                        @if($address->type == "primary")
                                                        <span class="badge bg-site-primary text-capitalize">{{$address->type}}</span>
                                                        @endif
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <a href="{{route('user.address.index')}}" class="me-3 hover-blue" target="_blank">Edit</a>
                                                        <a href="{{route('user.address.index')}}" class="hover-blue" target="_blank">Remove</a>
                                                    </div>
                                                </div>
                                                <p class="fs-6 m-0">{{$address->full_address}}</p>                                        
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-4">
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
                                <p class="fs-5 mt-3 fw-bold text-primary">
                                    <span class=" text-black">Total Price :</span>
                                    £ {{$final_total + $vat}} 
                                    {{-- + <span class="fs-5 text-black fw-normal">{{$pspConfig->vat_percentage}}% VAT</span> --}}
                                </p>
                                <button class="btn btn-site-primary w-100" type="submit">Checkout</button>
                                <span class="fs-6 mt-3">
                                    Know more about our fee <a href="{{getPagesRoute('fees')}}" class="hover-blue
                                    ">Fees Explained</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-12 text-center my-3">
                <h2>Cart Items</h2>
            </div>
            <div class="col-md-12 mt-3">
                <div class="card p-3 cart-card border-0">
                    <div class="table-responsive">
                        @foreach($data as $key => $items)
                        <div class="alert alert-primary rounded-0">Seller Name: {{getUserName($key)}}  - <a target="_blank" href="{{route('profile.index',getUserName($key))}}">Visit Seller's Store</a></div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Card</th>
                                    <th scope="col">Lan</th>
                                    <th scope="col" >
                                        <span class="d-md-block d-none">Characteristics</span>
                                        <span class="d-md-none d-block">Char</span>
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
                    </div>
                </div>
            </div>
            @else
            <div class="alert alert-primary rounded-0 mt-5">Your Cart is Empty.</div>
            @endif
            
        </div>
    </div>
</section>
@endsection

@push('js')

@endpush
