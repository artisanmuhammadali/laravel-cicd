<div class="card shadow_site border-0 mb-3 p-2">
    <div class="card-header border-0 bg-transparent">
        <div class="row mx-md-2">
            <div class="col-2 col-md-1 bg-light-blue text-center d-flex aligns-items-center">
                <img loading="lazy" class="m-auto img-fluid px-xxl-4 px-xl-3 py-2 lozad set_icon"
                    src="{{asset($item->set->icon)}}" style="filter: url({{"#".$item->rarity."_rarity"}});" alt="">
            </div>
            <div class="col-10 col-md-11 bg-dark-blue d-flex text-white py-2">
                <h6 class=" my-auto mx-1">{{$item->set_code}}</h6>
                <h5 class="  my-auto mx-1 fs-sm-14">{{$item->name}}</h5>
                @if($item->name_attr != "")
                <p class="fst-italic fs-5 my-auto fs-sm-14">{{$item->name_attr }}</p>
                @endif
                <a href="{{route('mtg.expansion.detail',[$item->url_slug, $item->url_type ,$item->slug])}}"
                    class="d-flex my-auto ms-auto text-decoration-none text-white" title="View all items">
                    <p class="mb-0 me-md-4 desktopView">View all <span class="desktopView">items</span></p>
                    <i class="fa fa-arrow-right fs-2 my-auto" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body pt-0 mx-md-3">
        <div class="row">
            <div class="col-md-3 pt-4 px-0 d-flex justify-content-center">
                <img src="{{$item->png_image}}" class="img_site_80 lozad" alt="" loading="lazy">
            </div>
            <div class="col-md-9 col-12 px-0 overflow-auto">
                <table class="table">
                    <thead class="">
                        <tr>
                            <th scope="col">User</th>
                            <th scope="col">Lan</th>
                            <th scope="col">Con</th>
                            <th scope="col" class="d-md-block d-none">Quantity</th>
                            <th scope="col">Price</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($item->best_price_cards as $collection)

                        <tr class="product_cart_row" data-collection="{{$collection->id}}">
                            <td>
                                @include('front.components.collection.user-detail')
                            </td>
                            <td>
                                @if($collection->mtg_card_type == "completed")
                                <div class="d-flex">
                                    <div class="d-block">
                                    @foreach(json_decode($collection->language) as $key =>$lang)
                                        @php($langTitle=languageFromCode($key))
                                        <span class="speechbubble p-1 z6 text-black text-uppercase" title="{{$langTitle}}">{{$key}}</span>
                                    @endforeach
                                    </div>
                                </div>
                                @else
                                <div class="d-block">
                                    @php($langTitle=languageFromCode($collection->language))
                                    <span class="speechbubble p-1 z6 text-black text-uppercase" title="{{$langTitle}}">{{$collection->language}}</span>
                                </div>
                                @endif
                            </td>
                            <td>
                                <div class=" text-center rounded text-white" style="background-color: {{$collection->condition_bg}}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$collection->condition_name}}">
                                    <p class="text-uppercase small">{{$collection->condition}}</p>
                                </div>
                            </td>
                            <td class="d-md-block d-none">
                                <span class="bg-light-blue py-1 px-2 rounded-1">{{$collection->quantity}}</span>
                            </td>
                            <td>
                                <span class="bg-light-blue py-1 px-2 rounded-1">£{{$collection->price}}</span>
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
    </div>
</div>
