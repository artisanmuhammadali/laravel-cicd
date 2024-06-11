<div class="row shadow_site py-3 my-2 ">
    <div class="table-responsive">
        <table class="table ms-2">
            <thead>
                <tr class="bg-gry">
                    <th>User</th>
                    <th>
                        Card
                    </th>
                    <th class="d-md-table-cell d-none">Set</th>
                    <th class="d-md-table-cell d-none">Lang</th>
                    <th>
                        <span class="d-md-block d-none">Characteristics</span>
                        <span class="d-block d-md-none">Char</span>
                    </th>
                    <th>
                        Price
                    </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($collections as $collection)
                <tr class="product_cart_row" data-collection="{{$collection->id}}">
                    <td>
                        @include('front.components.collection.user-detail')
                    </td>
                    <td class="d-md-table-cell d-grid">
                        <img class="myDIV h4Btn me-1" src="{{$collection->card->png_image}}" width="50px" height="60px">
                        <div class="hide hand h4" style="left: 32rem; top: 0px !important;">
                            <img class="rounded-3 lozad" alt="very friendly shark" width="250"
                                src="{{$collection->card->png_image}}" />
                        </div>
                        <a class="text-decoration-none product-listing-mobile-text"
                            href="{{route('mtg.expansion.detail',[$collection->card->url_slug, $collection->card->url_type ,$collection->card->slug])}}">{{$collection->card->name}}</a>
                            @php($attributess = $collection->card->attributes ?? null)
                            @if($attributess)
                                <br>
                                @foreach($collection->card->attributes as $att)
                                    <span class="badge bg-site-primary position-relative fs-12p-sm d-inline review-box mb-md-0 mb-1" style="font-size: 9px !important;">{{$att->name}}</span>
                                @endforeach
                            @endif
                    </td>
                    <td class="d-md-table-cell d-none">
                        <img loading="lazy" src="{{$collection->card->set->icon}}"
                            style="filter: url({{"#".$collection->card->rarity."_rarity"}});"
                            class="px-1 png tab_img_hover" width="50" alt="" height="30px">
                    </td>
                    <td class="d-md-table-cell d-none">
                        @if($collection->mtg_card_type == "completed")
                        <div class="d-flex">
                            <div class="d-block">
                                @foreach(json_decode($collection->language) as $key =>$lang)
                                <span class="speechbubble p-1 z6 text-black text-uppercase">{{$key}}</span>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div class="d-block">
                            @php($langTitle=languageFromCode($collection->language))
                            <span class="speechbubble p-1 z6 text-black text-uppercase"
                                title="{{$langTitle}}">{{$collection->language}}</span>
                        </div>
                        @endif
                    </td>
                    <td>
                        <div class="d-md-flex row d-block">
                            <div class="col-4 p-0">
                                <div class=" text-center rounded text-white my-1"
                                    style="background-color: {{$collection->condition_bg}}; width: fit-content;"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="{{$collection->condition_name}}">
                                    <p class="text-uppercase small m-0 px-1 product-listing-mobile-text">
                                        {{$collection->condition}}</p>
                                </div>
                            </div>
                            <div class="col" style="display: inline-table;">
                                <img loading="lazy" width="20" src="{{$collection->char_signed}}"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Signed" alt="">
                                <img loading="lazy" width="20" src="{{$collection->char_altered}}"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Altered" alt="">
                                <img loading="lazy" width="20" src="{{$collection->char_graded}}"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Graded" alt="">
                                <img loading="lazy" width="20" src="{{$collection->char_foil}}" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Foil" alt="">
                            </div>
                        </div>
                    </td>
                    <td>
                        <p class="bg-light-blue rounded text-center m-0 product-listing-mobile-text">
                            £{{$collection->price}}</p>
                        <span class="d-md-none d-block text-secondary fs-bread">{{$collection->quantity}}
                            avail</span>
                    </td>
                    <td>
                        @include('front.components.cart.options',['item'=>$collection ,
                        'class'=>''])
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>
