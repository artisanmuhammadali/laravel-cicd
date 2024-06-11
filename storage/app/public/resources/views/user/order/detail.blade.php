@extends('user.layout.app')
@section('title','Order Detail')
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
<style>
    *{
    margin: 0;
    padding: 0;
}
.rate {
    float: left;
    height: 46px;
    padding: 0 10px;
}
.rate:not(:checked) > input {
    position:absolute;
    top:-9999px;
}
.rate:not(:checked) > label {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:30px;
    color:#ccc;
}
.rate:not(:checked) > label:before {
    content: '★ ';
}
.rate > input:checked ~ label {
    color: #ffc700;    
}
.rate:not(:checked) > label:hover,
.rate:not(:checked) > label:hover ~ label {
    color: #deb217;  
}
.rate > input:checked + label:hover,
.rate > input:checked + label:hover ~ label,
.rate > input:checked ~ label:hover,
.rate > input:checked ~ label:hover ~ label,
.rate > label:hover ~ input:checked ~ label {
    color: #c59b08;
}

/* Modified from: https://github.com/mukulkant/Star-rating-using-pure-css */
</style>
@endpush
@section('content')
<div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
    <div class="content-body">
        <section class="invoice-preview-wrapper d-flex justify-content-center">
            <div class="row invoice-preview w-100">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class=" row">
                                <div class="col-md-12 d-flex justify-content-between mb-2">
                                    <h1 class="text-primary bold">Order #{{$order->id}}</h1>
                                    <div>
                                        @if($extraCondition)
                                        <button data-bs-toggle="modal" data-bs-target="#extraPayment" type="button" class="btn btn-icon btn-outline-success waves-effect"   data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $auth->id == $order->buyer_id ?  'Send Extra Payment To Seller' : 'Refund To Buyer' }} " data-bs-original-title="{{ $auth->id == $order->buyer_id ?  'Send Extra Payment To Seller' : 'Refund To Buyer' }}">
                                        £
                                        </button>
                                        @endif
                                        <button data-bs-toggle="modal" data-bs-target="#invoiceModal" type="button" class="btn btn-icon btn-outline-warning waves-effect"   data-bs-toggle="tooltip" data-bs-placement="top" title="Order Summary">
                                            <i data-feather='download'></i>
                                        </button>
                                        <button data-bs-toggle="modal" data-bs-target="#addressModal" type="button" class="btn btn-icon btn-outline-success waves-effect"   data-bs-toggle="tooltip" data-bs-placement="top" title="Shipping Address">
                                            <i data-feather='map-pin'></i>
                                        </button>
                                        
                                    </div>
                                </div>
                                <div class="col-md-8">
                                        <h4 class="card-title">Order Detail</h4>
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <td class="px-sm-3 px-0">
                                                        <span class="fw-bold">Seller :</span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <img src="{{$order->seller->main_image}}" class="me-75" height="20"
                                                                width="20" alt="Angular">
                                                                <a href="{{route('profile.index',$order->seller->user_name)}}" target="_blank">
                                                                    <span class="fw-bold">
                                                                    {{$order->seller->user_name}}</span>
                                                                </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="px-sm-3 px-0">
                                                        <span class="fw-bold">Buyer :</span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex">
                                                            
                                                            <img src="{{$order->buyer->main_image}}" class="me-75" height="20"
                                                                width="20" alt="Angular">
                                                                <a href="{{route('profile.index',$order->buyer->user_name)}}" target="_blank">
                                                                    <span class="fw-bold">{{$order->buyer->user_name}}</span>
                                                                </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="px-sm-3 px-0">
                                                        <span class="fw-bold">Status :</span>
                                                    </td>
                                                    <td class="text-capitalize">{{$order->status}}</td>
                                                </tr>
                                                @if($order->status == "cancelled")
                                                <tr>
                                                    <td class="px-sm-3 px-0">
                                                        <span class="fw-bold">Cancelled By :</span>
                                                    </td>
                                                    <td class="text-capitalize fw-bold">{{getUserName($order->cancelled_by)}}</td>
                                                </tr>
                                               @endif
                                                <tr>
                                                    <td class="px-sm-3 px-0">
                                                        <span class="fw-bold">Total Items :</span>
                                                    </td>
                                                    <td>{{count($order->detail)}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="px-sm-3 px-0">
                                                        <span class="fw-bold">Quantity :</span>
                                                    </td>
                                                    <td>{{$order->detail->sum('quantity')}}</td>
                                                </tr>
                                                @if($order->tracking_id)
                                                <tr>
                                                    <td class="px-sm-3 px-0"> 
                                                        <span class="fw-bold">Shipment Tracking Id :</span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-primary">{{$order->tracking_id}}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="px-sm-3 px-0">
                                                        <span class="fw-bold">Dispatch On :</span>
                                                    </td>
                                                    <td>
                                                        {{$order->dispatch_at}}
                                                    </td>
                                                </tr>
                                                @endif
                                                 @if($order->reason)
                                                <tr>
                                                    <td class="px-sm-3 px-0">
                                                        <span class="fw-bold">Reason :</span>
                                                    </td>
                                                    <td>{{$order->reason}}</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        <h4 class="card-title mt-2">Order Pricing</h4>
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <td class="px-sm-3 px-0">
                                                        <span class="fw-bold">Items Price :</span>
                                                    </td>
                                                    <td>£ {{$items_price}}</td>
                                                </tr>
                                                <tr>
                                                <td class="d-grid px-sm-3 px-0">
                                                    <span class="fw-bold">Postage Name :</span>
                                                </td>
                                                <td class="px-sm-2 px-1">
                                                    <div class="d-grid">
                                                        <p class="mb-0 text-truncate">
                                                            <span>{{$order->postage ? $order->postage->name : "Postage"}}</span>
                                                        </p>
                                                    </div>
                                                </td>
                                                <tr>
                                                    <td class="px-sm-3 px-1">
                                                        <span class="fw-bold">Postage Service Charges :</span>
                                                    </td>
                                                    <td>
                                                        <div class="d-grid">
                                                            <p class="mb-0">
                                                                <span> £ {{$main->shiping_charges ?? 0}}</span>
                                                            </p>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="px-sm-3 px-0">
                                                        <span class="fw-bold">VFS Platform Fee :</span>
                                                    </td>
                                                    <td>£ {{$main->fee + $main->referee_credit + $main->seller_kyc_return}} </td>
                                                </tr>
                                                @if(count($extraPayments) > 0)
                                                    @foreach($extraPayments as $extra)
                                                    <tr>
                                                        <td class="px-sm-3 px-0">
                                                            <span class="fw-bold">{{$extra->credit_user == $order->buyer_id ? "Refund To Buyer" : "Buyer Send Extra Payment To Seller"}}</span>
                                                        </td>
                                                        <td>£ {{$extra->amount}}</td>
                                                    </tr>
                                                    @endforeach
                                                @endif
                                                <tr>
                                                    <td class="px-sm-3 px-0">
                                                        <span class="fw-bold">Seller Receive Amount :</span>
                                                    </td>
                                                    @php($seller_amount=$main->seller_amount - $main->referee_credit + $extraPrice -  $main->seller_kyc_return)
                                                    <td>£ {{number_format($seller_amount, 2, '.', '')}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="px-sm-3 px-0">
                                                        <span class="fw-bold">Total Order  Price :</span>
                                                    </td>
                                                    @php($total=$order->total  + $extraPrice)
                                                    <td>£ {{number_format($total, 2, '.', '')}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <h4 class="card-title mt-2">Order Shipping Detail</h4>
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <td class="px-sm-3 px-0">
                                                        <span class="fw-bold">Buyer:</span>
                                                        <br>
                                                        {{$order->buyer->full_name}}
                                                        <br>
                                                        {!!$order->deliveryAddress!!}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="px-sm-3 px-0">
                                                        <span class="fw-bold">Seller:</span>
                                                    <br>
                                                    {{$order->seller->full_name}}
                                                    <br>
                                                    {!! $order->seller->sellerAddress->street_number ." , <br>". $order->seller->sellerAddress->postal_code ." , <br>".$order->seller->sellerAddress->city ." , <br>". $order->seller->sellerAddress->country !!}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                <div class="col-md-4">
                                    <h4 class="card-title">Order Status</h4>
                                    <table class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <td class="px-md-0 px-sm-3 px-0">
                                                    <span class="fw-bold">Current Status :</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge {{$order->status == "completed" ? "bg-success" : "bg-primary"}} text-uppercase">
                                                        {{$order->status}}
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    @include('user.order.components.status')
                                    @include('user.order.components.reviews')

                            </div>
                              @if($con)
                                    <div class="table-responsive  col-md-12 mt-2">
                                        <h4 class="address-title mb-1" id="">Conversation</h4>
                                        <a target="_blank" href="{{route('user.chat')}}?id={{$con}}" class="btn btn-primary waves-effect waves-float waves-light py-1">Go To Chat</a>
                                    </div>
                                    @endif
                            <div class=" table-responsive col-md-12 mt-2">
                                <h4 class="address-title mb-1" id="addNewAddressTitle">Cards Detail</h4>
                                <table class="table">
                                    <thead>
                                        <th>
                                            Card
                                        </th>
                                        <th>
                                            Range
                                        </th>
                                        <th>
                                            Set
                                        </th>
                                        <th>
                                            Rarity
                                        </th>
                                        <th>
                                            Language
                                        </th>
                                        <th>
                                            Characterstics
                                        </th>
                                        <th>
                                            Photo
                                        </th>
                                        <th>
                                            Notes
                                        </th>
                                        <th>
                                            Quantity
                                        </th>
                                        <th>
                                            Price
                                        </th>

                                    </thead>
                                    <tbody>
                                        @foreach($order->detail as $detail)

                                        <tr>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="hover_div">
                                                        <img class="myDIV h4Btn me-1" src="{{$detail->card->png_image}}"
                                                            width="50px">
                                                        <div class="hide hand h4 "
                                                            style="left: 32rem; top: 0px !important;">
                                                            <img class="rounded-3" alt="very friendly shark" width="250"
                                                                src="{{$detail->card->png_image}}" />
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <a href="{{route($detail->range.'.expansion.detail',[$detail->card->url_slug, $detail->card->url_type ,$detail->card->slug])}}" target="_blank" class="fw-bold">{{$detail->card->name}}</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{getOrderRanges($detail->range)}}
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    {{$detail->card->set->name}}
                                                </div>
                                            </td>
                                            <td>
                                                <img loading="lazy" src="{{$detail->card->set->icon  ?? getStarWarIcon()}}" style="filter: url({{"#".$detail->card->rarity."_rarity"}});" class="me-75" height="40" width="40" alt="Angular" title="{{$detail->card->set->name}}">
                                            </td>
                                            <td>
                                                @if($detail->card->card_type == "completed")
                                                @foreach(json_decode($detail->collection->language) as $key =>$lang)
                                                <span class="badge bg-primary text-uppercase">{{$key}}</span>
                                                @endforeach
                                                @else
                                                <span
                                                    class="badge bg-primary text-uppercase">{{$detail->collection->language}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{$detail->collection->condition}}</span>
                                                @if($detail->collection->foil)
                                                <span class="badge bg-info">Foil</span>
                                                @endif
                                                @if($detail->collection->signed)
                                                <span class="badge bg-warning">Signed</span>
                                                @endif
                                                @if($detail->collection->graded)
                                                <span class="badge bg-success">Graded</span>
                                                @endif
                                                @if($detail->collection->altered)
                                                <span class="badge bg-secondary">Altered</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="col-4 d-flex align-items-center justify-content-center">
                                                    @if($detail->collection->image)
                                                    <a href="{{$detail->collection->img}}" target="_blank">
                                                        <i class="fa fa-camera myDIV h4Btn text-site-primary fs-4"
                                                            aria-hidden="true"></i>
                                                        <div class="hide hand h4">
                                                            <img loading="lazy" src="{{$detail->collection->img}} "
                                                                class="px-1 png tab_img_hover" width="500" alt="">
                                                        </div>
                                                    </a>

                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-8 d-flex align-items-center justify-content-center">
                                                    <p class="m-0 small" data-toggle="tooltip" data-placement="top" title="{{$detail->collection->note}}">
                                                        {!! Str::limit($detail->collection->note, 20,'..') !!}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                {{$detail->quantity}}
                                            </td>
                                            <td>
                                                {{$detail->price}}
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
</div>
</div>
<div class="sipnner d-none">
    <div class="rotate" style=" transform: rotate(270deg); ">
        <div class="spinner-grow text-secondary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-grow text-secondary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-grow text-secondary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-grow text-secondary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div> 
@include('user.order.summary')
@include('user.order.print-address')
@include('user.layout.modals.orders.confirmation')
@include('user.layout.modals.orders.cancel-confirmation')
@include('user.layout.modals.orders.dispatch-confirmation')
@include('user.layout.modals.orders.dispute')
@include('user.layout.modals.orders.extra-payment')
@include('user.components.html-to-pdf')
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script>
    $(document).on('click','.rating',function(){
        var rating =  $(this).val();
        $('.reviewRatingShow').text(rating);
        $('.reviewRating').val(rating);

    })
</script>
<script>
    var rating
    $(document).ready(function () {
        $('.rating').each(function () {
            rating = $(this).text();
            $(this).rateYo({
                readOnly: true,
                rating: rating,
                numStars: 5,
                precision: 2,
                minValue: 1,
                maxValue: 5,
                starWidth: "15px",
                ratedFill: "#FCB800",
            });
        })

    })

</script>
<script>
    $(document).on('change', '.orderStatus', function () {
        orderStatus($(this).val()); 
    })
    function orderStatus(val)
    {
        $('.orderBody').empty();
        $('label[for="tracking_id"], input[name="tracking_id"]').remove();
        $('label[for="reason"], input[name="reason"]').remove();
        var tracking = `
            <label for="tracking_id">Tracking Id</label>
            <input type="text" class="form-control" name="tracking_id" required>
            `;
        var reason = `
            <label for="reason">Reason</label>
            <textarea name="reason" class="form-control" cols="40" rows="5" required></textarea>
            `;

        val == 'dispatched' ? $('.orderBody').append(tracking) : val == 'dispute' ? $(
            '.orderBody').append(reason) : '';
        
    }

</script>
@endpush
