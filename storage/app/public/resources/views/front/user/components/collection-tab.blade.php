@if(count($list) <= 0)
<div class="row text-center">
    <p class="text-danger">No Record</p>
</div>
@else
<div class="table-responsive">
    <h5>{{$count}} Records Found</h5>
    <table class="table table-hover">
        <thead>
            <tr>
                @if($type == "single")
                <th class="text-truncate d-md-block d-none">Coll #</th>
                @endif
                <th>Card</th>
                <th class="d-md-block d-none">Set</th>
                <th>Lan</th>
                <th>
                    <span class="d-md-block d-none">Characteristics</span>
                    <span class="d-md-none d-block">Char</span>
                </th>
                <th class="d-md-table-cell d-none">Qty</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($list as $item)
            @if($item->user_id == $user->id)
            <tr class="">
                @if($type == "single")
                <td class="d-md-table-cell d-none">
                    {{$item->card->collector_number}}
                </td>
                @endif
                <td>
                    <div class="d-flex align-items-center ">
                        <img class="myDIV h4Btn me-1 d-md-block d-none" src="{{$item->card->png_image}}" width="50px">
                        <i class="fa fa-camera myDIV h4Btn d-md-none d-block pe-1"></i>
                        <div class="hide hand h4 " style="left: 32rem; top: 0px !important;">
                            <img class="rounded-3" alt="very friendly shark" width="250" src="{{$item->card->png_image}}"/>
                        </div>
                        <a href="{{route('mtg.expansion.detail',[$item->card->url_slug, $item->card->url_type ,$item->card->slug])}}" class="fw-bold product-listing-mobile-text">{{$item->card->name}}</a>
                    </div>
                </td>
                <td class="d-md-table-cell d-none">
                    <img src="{{$item->card->set->icon  ?? ""}}" style="filter: url({{"#".$item->card->rarity."_rarity"}});" class="me-75" height="40" width="40" alt="Angular" title="{{$item->card->set->name}}">
                </td>
                <td> 
                    @if($item->mtg_card_type == "completed")
                    <div class="d-flex">
                        <div class="d-block">
                        @foreach(json_decode($item->language) as $key =>$lang)
                                <span class="speechbubble p-1 z6 text-black text-uppercase product-listing-mobile-text">{{$key}}</span>
                        @endforeach
                        </div>
                    </div>
                    @else
                    <div class="d-block">
                        @php($langTitle=languageFromCode($item->language))
                        <span class="speechbubble p-1 z6 text-black text-uppercase product-listing-mobile-text" title="{{$langTitle}}">{{$item->language}}</span>
                    </div>
                    @endif
                </td>
                <td>
                    <div class="d-md-flex d-block row ">
                        <div class="col-4">
                            <div class=" text-center rounded text-white my-1" style="background-color: {{$item->condition_bg}}; width: fit-content;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$item->condition_name}}">
                                <p class="text-uppercase small m-0 px-1 product-listing-mobile-text">{{$item->condition}}</p>
                            </div>
                        </div>
                        <div class="col" style="display: inline-table;">
                            <img loading="lazy" width="20" src="{{$item->char_signed}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Signed" alt="">
                            <img loading="lazy" width="20" src="{{$item->char_altered}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Altered" alt="">
                            <img loading="lazy" width="20" src="{{$item->char_graded}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Graded" alt="">
                            <img loading="lazy" width="20" src="{{$item->char_foil}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Foil" alt="">
                        </div>
                    </div>
                </td>
                <td class="d-md-table-cell d-none">
                    {{$item->quantity}}
                </td>
                <td class="text-truncate">
                    £ {{$item->price}}
                    <span class="d-md-none d-block text-secondary fs-bread">{{$item->quantity}} avail</span>
                </td>
                <td>
                    @include('front.components.cart.options',['item'=>$item , 'class'=>''])
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center py-2">
        <div class="d-md-block d-none">{{$list->links()}}</div>
        @include('front.components.pagination',['items'=>$list])
    </div>
@endif 
        