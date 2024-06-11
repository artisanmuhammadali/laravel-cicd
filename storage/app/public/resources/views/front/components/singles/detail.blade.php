<div class="row px-md-4 px-2">
    <div class="col-lg-3 col-12 p-0 d-flex justify-content-center">
        @if($item->is_card_faced)
        <div class="flip-card-3D-wrapper px-0">
            <div class="flip-card">
                @include('front.components.singles.double-face',['class'=>'front','img'=>$item->double_image[0] ?? null])
                @include('front.components.singles.double-face',['class'=>'back','img'=>$item->double_image[1] ?? null])
            </div>
        </div>
        @else
            <div class="ColorGradientDiv">
                <span class="ShineDiv "></span>
                <img src="{{$item->png_image}}" class="w-100" alt="" loading="lazy">
                @if($item->cardMsg)
                    <div class="text-on-img text-capitalize fw-bolder">{{$item->cardMsg}}</div>
                @endif
            </div>
        @endif
    </div>
    @foreach($item->faces as $face)
    <div class="col-lg-4 bg-gry d-lg-block d-none pt-5 my-3">
        <div class="row px-1">
            <div class="col-lg-8 pe-0">
                <h2 class="fs-5">{{$face->name ?? $item->name}}</h2>
            </div>
            @php($mana_cost=getCardManaCost($face->id))
            <div class="col-4 ps-0">
                @foreach($mana_cost as $cost)
                <img  src="{{$cost}}" width="20" alt="" loading="lazy">
                @endforeach
            </div>
            <div class="col-12 d-flex mt-3 ">
                <p class="mb-0 pe-2 small">
                    {{$face->type_line}}
                </p>
                <img loading="lazy" src="{{$item->set->icon}}" width="20" alt="" style="filter: url({{"#".$item->rarity."_rarity"}});">
                <p class="mb-0 ms-2 text-capitalize pe-2 small">
                   - {{$item->rarity}}
                </p>

            </div>
            <hr>

            <div class="col-12 oracle_text">
                {{$face->oracle_text}}
            </div>
            <div class="col-12 d-flex align-items-center mt-4">
                <img src="{{asset('images/single/28-artist.svg')}}" alt="" loading="lazy">
                <h4 class="mb-0 fs-6">
                    Artist : {{$face->artist}}
                </h4>
                <p class="mb-0 ms-auto fs-6">#{{$item->collector_number}}</p>
            </div>
            @if($loop->iteration ==1 && $item->is_legal)
            <div class="col-12 mt-3 mb-1">
                <h4 class="mb-0 small text-muted mb-1">
                    Card Legalities
                </h4>
                @if($item->legalities && $item->legalities != '[]')
                    @foreach (json_decode($item->legalities) as $key=> $legality )
                    @if($legality == "legal")
                    <span class="badge border card-legality-text card-legality-border text-capitalize">{{$key}}</span>
                    @endif
                    @endforeach
                @else
                    <span class="badge border card-legality-text card-legality-border text-capitalize">Card is not Legal</span>
                @endif
            </div>
            @endif
        </div>
    </div>
    @endforeach
    {{-- <div class="col-lg-3"></div>
    <div class="col-lg-8 bg-white">
        @if($item->is_card_faced)
        <div class="col-12 my-3">
            <h4 class="mb-0 small text-muted mb-1">
                Card Legalities
            </h4>
            @foreach (json_decode($item->legalities) as $key=> $legality )
            @if($legality == "legal")
            <span class="badge border border-warning text-warning text-capitalize">{{$key}}</span>
            @endif
            @endforeach
        </div>
        @endif
    </div>
    <div class="col-lg-1"></div> --}}
    <div class="col-12 px-0 mt-2 d-flex justify-content-center">
       <div class="row w-100 justify-content-end">
            @if(count($item->versions) != 0)

            <div class="col-md-4 mt-1">
                <div class="dropdown ">
                    <button class="hover-white btn dropdown-toggle drop-ver-toggle  btn_25 bg-white border-site-primary text-start w-100 d-flex justify-content-between pe-1 rounded-1" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        View Versions
                    </button>
                    <div class="row justify-content-center">
                        <ul class="hide ver_drop overflow-auto version_drop col-12 px-0" aria-labelledby="">
                            <div style="max-height: 200px;overflow: auto;">

                            @foreach($item->versions as $version)
                            @if($loop->iteration == 11)
                                @break
                            @endif
                            <li class="drop-hover" style="position:relative">
                                <div class="btn d-flex expansion_detailed_route" data-url="{{route('mtg.expansion.detail',[$version->url_slug , $version->url_type ,  $version->slug])}}">
                                    <img class="myDIV h4Btn me-1" style="width:20px" src="{{$version->png_image}}">
                                    <div class="hide hand h4" >
                                    <img class="rounded-3 lozad" alt="very friendly shark" width="250" src="{{$version->png_image}}">
                                    </div>
                                    <img loading="lazy" class=" img-fluid"
                                            src="{{asset($version->set->icon)}}" style="width:20px;filter: url({{"#".$version->rarity."_rarity"}});"
                                            alt="">
                                    <p class="fs-6 bolder my-auto ms-1 text-truncate pe-1" title="{{$version->set->name}}">{{$version->set->name}}
                                        @if($version->name_attr != "")
                                        |<span class="ms-1 fst-italic my-auto fs-version">{{$version->name_attr }}</span>
                                        @endif
                                    </p>

                                </div>
                            </li>
                            @endforeach
                            </div>
                            <div class="col-12 d-flex justify-content-center">
                                <a href="{{route('mtg.specific.search','items')}}?keyword={{$item->name}}&item=versions" class="btn btn-site-primary w-100 rounded-0">View All {{$item->versions->count()}} Items</a>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <div class="col-md-4 mt-1">
                {{-- <select
                    class="form-select-lg border-site-primary rounded-1 pe-lg-5 fs-6 text-capitalize changeFoil w-100">
                    @foreach(json_decode($item->finishes) as $foil)
                    <option class="text-capitalize bg-white text-black" value="{{$foil}}">{{$foil}}</option>
                    @endforeach
                </select> --}}
            </div>
            <div class="col-md-4 d-flex justify-content-end mt-1">
                <a href="" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="my-auto"><img
                    class="d-lg-none d-block me-2 " loading="lazy"
                    src="{{asset('images/single/32-info-solidBlue.svg')}}" alt=""></a>
                @if($auth)
                    @if((auth()->user()->role != 'buyer' && auth()->user()->role != 'admin'))
                    <button class="btn btn-site-primary w-auto  fs-small w-100"  data-bs-toggle="modal" data-bs-target="#forSale" title="Sell one like this">
                        Sell one like this
                    </button>
                    @endif
                @else
                <button class="btn btn-site-primary  w-auto  fs-small w-100" data-bs-toggle="modal" data-bs-target="#loginModal" title="Sell one like this">
                    Sell one like this
                </button>
                @endif
            </div>
       </div>
    </div>
    {{--<div class="col-12 d-flex justify-content-end bg-white d-flex d-lg-none mt-2">
        <a href="" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="my-auto"><img loading="lazy" class="d-lg-none d-block me-2 " src="{{asset('images/single/32-info-solidBlue.svg')}}" alt=""></a>
        @if($auth)
            @if((auth()->user()->role != 'buyer' && auth()->user()->role != 'admin'))
            <button class="btn btn-site-primary w-auto h-50 my-3 mx-1 fs-small"  data-bs-toggle="modal" data-bs-target="#forSale">
                Sell one like this
            </button>
            @endif
        @else
        <button class="btn btn-site-primary w-auto h-50 my-3 mx-1 fs-small" data-bs-toggle="modal" data-bs-target="#loginModal">
            Sell one like this
        </button>
        @endif

    </div>--}}
</div>
