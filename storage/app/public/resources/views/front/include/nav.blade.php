
@php($routeBase = getRouteBase())
@php($cardbase = !in_array($routeBase,getCardRanges()) ? 'mtg' : $routeBase)
@if($routeBase == 'index')
<style>
    .banner_img_area{
        background-image:linear-gradient(rgba(33, 48, 86, 1), rgba(0, 0, 0, 0.5)), url({{$setting['banner_img'] ?? ""}});
    }
    @media only screen and (max-width: 426px) {
        .banner_img_area{
            background-image:linear-gradient(rgba(33, 48, 86, 1), rgba(33, 48, 86, 1)) !important;
        }   
    }
</style>
<div class="header banner_background banner_img_area" style="">
    <div class="container pb-md-5 px-0">
        @include('front.include.header')
        <div class="col-12 text-center pt-5 mt-5 d-none d-md-block">
            <p class=" text-white fs-4 fw-bold mb-0 select_main-range-pos pro_range_heading_1_area">{{$setting['pro_range_heading_1'] ?? ""}}</p>
        </div>
        <div class="container pb-md-5 d-none d-md-block">
            <div class="d-flex px-md-9 justify-content-center  card_img_banner_row top_zero_sm over_flow_banner ">
                @include('front.components.vfs-product-line',['class'=>"pl-sm-larg"])            
            </div>
        </div>
    </div>
</div>
<div class="row d-flex d-md-none justify-content-center m-0 mt-3">
    @include('front.components.vfs-mobile-product-line',['class'=>""])            
</div>
@else

<section>
    <div class="row  m-0">
        <div class="col-12 p-0 site-light-bg">
            @include('front.include.header',['class'=>'bg_dark_shark'])
            @if(getRouteBase() != 'seller')
            <div class="container pt-md-3 mtg-nav pt-2">
                <div class="row">
                    <div class="col-12">
                        <div class="row d-flex justify-content-between">
                            <div class="  col-md-4  d-flex ps-md-0">
                                <form class="d-flex w-100">
                                    <div class="input-group mb-md-3 mb-2 border site-border-color rounded-0">
                                        <input type="text"
                                            class="form-control input-padding bg-transparent text-white border-0 general_search_input"
                                            data-url="{{route($cardbase.'.general.search')}}"
                                            aria-label="Text input with dropdown button">
                                        <span class="nav-vertical-bar py-2 ">|</span>
                                        <a href="{{route($cardbase.'.detailedSearch')}}"
                                            class="btn btn-outline-secondary  fw-lighter md-text input-padding nav-light-text bg-transparent border-0 d-flex"
                                            type="button">
                                            <span class="d-lg-flex d-none pe-1">Detailed Search</span>
                                            <img loading="lazy" alt="detail search" class="mr-3" src="{{asset('images/nav-bar/32-filterOff.svg')}}"
                                                width="20">
                                        </a>
                                    </div>
                                </form>
                            </div>
                            <div class=" col-md-5 col-5  d-md-flex   justify-content-end px-md-0 d-none">
                                @if(getRouteBase() == 'mtg')
                                <a class="nav-light-text me-2 site-border-color btn btn-outline-primary rounded-0  text-decoration-none bg-transparent md-text fw-lighter btn-padding" style="height: fit-content;" href="{{route('mtg.marketplace','single-cards')}}">
                                    View All Available Products
                                </a>
                                @endif
                                <div class=" me-md-2 me-2">
                                    <a href="{{route($cardbase.'.expansion.index')}}"
                                        class="btn nav-light-text pe-0 md-text mt-1 fw-lighter d-flex align-items-center rounded-0">
                                        <span class="d-md-flex d-none pe-1">Select</span> Expansion
                                        <i class="fa fa-caret-right d-md-block d-none ps-1" aria-hidden="true"></i>
                                    </a>
                                </div>
                                
                                <div class="dropdown col-4  col-md-3">
                                    <a href="#" class="btn rounded-0  border site-border-color py-2 mtg-dropdown-toggle d-flex justify-content-center" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <img loading="lazy" alt="MTG" class="w-100 px-lg-3 px-0 d-md-block d-none"
                                            src="{{asset('images/banner/MTG_Primary_LL_4c_White_XL_V12.png')}}" alt="">
                                        <img loading="lazy" alt="MTG" class="d-md-none d-block" src="{{asset('images/nav-bar/Bitmap.png')}}"
                                            alt="">
                                    </a>
                                    <ul class="dropdown-menu bg-black" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item hover-ini" href="{{route('mtg.index')}}"><img loading="lazy" alt="MTG"
                                                    class="w-100 px-3 mb-2"
                                                    src="{{asset('images/banner/MTG_Primary_LL_4c_White_XL_V12.png')}}"
                                                    alt=""></a></li>
                                        {{-- <li><a href="{{route('sw.index')}}" class="dropdown-item hover-ini" tabindex="-1" role="button"
                                                aria-disabled="true"><img loading="lazy" alt="pokemon" class="w-100 px-3 mb-1"
                                                    src="{{asset('images/banner/logo@2.png')}}" alt=""></a></li> --}}
                                        <li><a href="" class="dropdown-item disabled" tabindex="-1" role="button"
                                                        aria-disabled="true"><img loading="lazy" alt="Star-wars" class=" w-100 px-3 mb-1"
                                                            src="{{asset('images/banner/star-wars.png')}}" alt=""></a></li>
                                        <li><a href="" class="dropdown-item disabled" tabindex="-1" role="button"
                                                aria-disabled="true"><img loading="lazy" alt="Flesh Blood" class=" w-100 px-3 mb-1"
                                                    src="{{asset('images/banner/logo-fab.png')}}" alt=""></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="position-relative">
                        <div class="search_tab_block">
                          
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

@endif