@extends('admin.layout.app')
@section('title','Order Detail')
@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('admin/css/pages/app-chat.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('admin/css/pages/app-chat-list.css')}}">
@endpush
@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="invoice-preview-wrapper">
                <div class="row invoice-preview">
                    
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-between mb-2">
                                        <h1 class="text-primary bold">Order #{{$order->id}}</h1>
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
                                                                <a href="{{route('admin.user.detail',[$order->seller->id , 'info'])}}" target="_blank">
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
                                                                <a href="{{route('admin.user.detail',[$order->buyer->id , 'info'])}}" target="_blank">
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
                                               
                                                <tr>
                                                    <td class="px-sm-3 px-0">
                                                        <span class="fw-bold">Total Items :</span>
                                                    </td>
                                                    <td>{{count($order->detail)}}</td>
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
                                                @if($order->ticket)
                                                <tr>
                                                    <td class="px-sm-3 px-0">
                                                        <span class="fw-bold">Dispute Ticket :</span>
                                                    </td>
                                                    <td>
                                                        <a target="_blank" href="{{'https://veryfriendlysharksltd.zendesk.com/agent/tickets/'.$order->ticket->desk_id}}">
                                                        view<i data-feather='arrow-right' class="ms-25"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endif
                                                @if($order->status == "cancelled")
                                                <tr>
                                                    <td class="px-sm-3 px-0">
                                                        <span class="fw-bold">Order Cancel After :</span>
                                                    </td>
                                                    <td>
                                                        {{$order->cancel_after}} {{$order->cancel_after == 1 ? "day" : "days"}}
                                                    </td>
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
                                                    <span class="fw-bold">Postage Service Charges :</span>

                                                </td>
                                                <td class="px-sm-2 px-1">
                                                    <div class="d-grid">
                                                        <p class="mb-0 text-truncate">
                                                            <span>{{$order->postage ? $order->postage->name : "Postage"}}</span>
                                                        </p>
                                                        <p class="mb-0">
                                                            <span> £ {{$main->shiping_charges ?? 0}}</span>
                                                        </p>
                                                    </div>
                                                </td>
                                                <tr>
                                                    <td class="px-sm-3 px-0">
                                                        <span class="fw-bold">VFS Platform Fee :</span>
                                                    </td>
                                                    <td>£ {{$main->fee + $main->referee_credit}} </td>
                                                </tr>
                                                @if(count($extraPayments) > 0)
                                                    @foreach($extraPayments as $extra)
                                                    <tr>
                                                        <td class="px-sm-3 px-0">
                                                            <span class="fw-bold">{{$extra->credit_user == $order->buyer_id ? "Return Extra Payment To Buyer" : "Send Extra Payment To Seller"}}</span>
                                                        </td>
                                                        <td>£ {{$extra->amount}}</td>
                                                    </tr>
                                                    @endforeach
                                                @endif
                                                <tr>
                                                    <td class="px-sm-3 px-0">
                                                        <span class="fw-bold">Seller Receive Amount :</span>
                                                    </td>
                                                    @php($seller_amount=$main->seller_amount - $main->referee_credit + $extraPrice)
                                                    <td>£ {{number_format($seller_amount, 2, '.', '')}} {{$main->seller_kyc_return > 0 ?  '( included KYC Return amount )' : ''}}  </td>
                                                </tr>
                                                <tr>
                                                    <td class="px-sm-3 px-0">
                                                        <span class="fw-bold">Total Order Price :</span>
                                                    </td>
                                                    @php($total=$order->total  + $extraPrice)
                                                    <td>£ {{number_format($total, 2, '.', '')}}</td>
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
                                                        <span class="badge {{$order->status == "completed" ? "bg-success" : "bg-primary"}} text-uppercase">
                                                            {{$order->status}}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @if($show_btns)
                                        <div class="d-flex mt-3 justify-content-between">
                                            <button class="btn btn-outline-danger w-auto" data-bs-toggle="modal" data-bs-target="#ordercancel" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Refund">
                                                Cancel
                                            </button>
                                            <button class="btn btn-outline-warning w-auto" data-bs-toggle="modal" data-bs-target="#orderRefund" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Refund">
                                                Refund
                                            </button>
                                            <a onclick="confirmationAlert('{{ route('admin.orders.update',[$order->id, 'completed']) }}')"
                                                class="btn btn-outline-success w-auto mr-10p btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Completed">
                                                Complete
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="table-responsive  col-md-12 mt-2">
                                        <h4 class="address-title mb-1" id="">Conversation</h4>
                                        <a target="_blank" href="{{route('admin.mtg.chat')}}?id={{$conversation->id ?? 0}}" class="btn btn-primary">Go To Chat</a>
                                    </div>
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
                                                    <div>
                                                        {{$detail->card->name}}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{getOrderRanges($detail->range)}}
                                            </td>
                                            <td>
                                                {{$detail->card->set->name}}
                                            </td>
                                            <td>
                                                <img loading="lazy" src="{{$detail->card->set->icon  ?? getStarWarIcon()}}" style="filter: url({{"#".$detail->card->rarity."_rarity"}});" class="me-75" height="40" width="40" alt="Angular" title="{{$detail->card->set->name}}">
                                            </td>
                                            <td>
                                                @if($detail->collection->mtg_card_type == "completed")
                                                @foreach(json_decode($detail->collection->language) as $key =>$lang)
                                                <span class="badge bg-primary text-uppercase">{{$key}}</span>
                                                @endforeach
                                                @else
                                                <span class="badge bg-primary text-uppercase">{{$detail->collection->language}}</span>
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
</div>
@include('admin.orders.modals.cancel')
@include('admin.orders.modals.refund')
@endsection
@push('js')
<script>
    $(document).on('change','#refund_with_fee',function(){
        if($(this).prop('checked'))
        {
            $('.refund_amount').val('');
            $('.refund_amount').prop('disabled',true);
        }
        else{
            $('.refund_amount').prop('disabled',false);
        }
    })
</script>
@endpush