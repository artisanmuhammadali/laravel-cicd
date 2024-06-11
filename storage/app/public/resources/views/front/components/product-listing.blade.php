<div class="row shadow_site py-3 my-2 ">
    <div class="table-responsive product-listing-table px-md-1 p-0">
        <table class="table table-bordered ms-2">
            <thead>
                <tr>
                    <th>User</th>
                    <th class="text-center">Lan</th>
                    <th class="text-center">
                        <span class="d-md-block d-none">Characteristics</span>
                        <span class="d-md-none d-block">Char</span>
                    </th>
                    <th class="d-md-block d-none">
                        <div class="row">
                            <div class="col-2 text-center">Photos </div>
                            <div class="col-10 text-center">Notes </div>
                        </div>
                    </th>
                    <th>
                        Price
                    </th>
                    <th class="d-md-block d-none">
                        Quantity
                    </th>
                    <th> Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($collections as $collection)
                <tr class="product_cart_row" data-collection="{{$collection->id}}">
                    <td>
                        @include('front.components.collection.user-detail')
                    </td>
                    <td>
                        @if($collection->mtg_card_type == "completed")
                        <div class="d-flex">
                            <div class="d-block" style="width: fit-content;">
                            @foreach(json_decode($collection->language) as $key =>$lang)
                                    <span class="speechbubble p-1 z6 text-black text-uppercase product-listing-mobile-text">{{$key}}</span>
                            @endforeach
                            </div>
                        </div>
                        @else
                        <div class="d-block" style="width: fit-content;">
                            @php($langTitle=languageFromCode($collection->language))
                            <span class="speechbubble p-1 z6 text-black text-uppercase product-listing-mobile-text" title="{{$langTitle}}">{{$collection->language}}</span>
                        </div>
                        @endif
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-4 d-flex justify-content-center">
                                <div class=" text-center rounded text-white my-1" style="background-color: {{$collection->condition_bg}}; width: fit-content;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$collection->condition_name}}">
                                    <p class="text-uppercase small m-0 px-1 product-listing-mobile-text">{{$collection->condition}}</p>
                                </div>
                            </div>
                            <div class="col-md text-center" style="display: inline-table;">
                                <img loading="lazy" width="20" src="{{$collection->char_signed}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Signed" alt="">
                                <img loading="lazy" width="20" src="{{$collection->char_altered}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Altered" alt="">
                                <img loading="lazy" width="20" src="{{$collection->char_graded}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Graded" alt="">
                                <img loading="lazy" width="20" src="{{$collection->char_foil}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Foil" alt="">
                            </div>
                        </div>
                    </td>
                    <td class="d-md-block d-none">
                        <div class="row">
                            <div class="col-4 d-flex align-items-center justify-content-center">
                                @if($collection->image)
                                <a href="{{$collection->img}}" target="_blank">
                                    <i class="fa fa-camera myDIV h4Btn text-site-primary fs-4" aria-hidden="true"></i>
                                    <div class="hide hand h4" >
                                        <img loading="lazy" src="{{$collection->img}} " class="px-1 png tab_img_hover" width="500" alt="">
                                    </div> 
                                </a>

                                @endif
                            </div>
                            <div class="col-8 d-flex align-items-center justify-content-center">
                                <p class="m-0 small" data-toggle="tooltip" data-placement="top" title="{{$collection->note}}">
                                    {!! Str::limit($collection->note, 20,'..') !!}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <p class="bg-light-blue rounded text-center m-0 product-listing-mobile-text">
                            £{{$collection->price}}
                        </p>
                        <span class="d-md-none d-block text-secondary fs-bread">{{$collection->quantity}} avail</span>
                    </td>
                    <td class="d-md-table-cell d-none">
                        {{$collection->quantity}}
                    </td>
                    <td>
                        @include('front.components.cart.options',['item'=>$collection , 'class'=>''])
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
