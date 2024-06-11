@extends('layouts.app')
@section('title', $setting['mtg_page_title'] ?? "")
@section('description', $setting['mtg_page_meta'] ?? "")
@push('css')
<link rel="stylesheet" href="{{ asset('Owl_carousel/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('Owl_carousel/css/owl.theme.default.min.css') }}">
<style>
    .owl-carousel .owl-item img{
        object-fit: contain !important;
    }
    .centered-text > .dispatch-badge-text{
        font-size: 10px;
    }
    .fa-star{
        font-size: 12px;
    }
</style>
@endpush
@section('content')
<style>

</style>

<div class="container-fluid px-0">
    <section>
        @include('front.components.breadcrumb')
    </section>
        @include('front.components.general.banner',['button' => 'mtg','frontImage' => $setting['mtg_banner_upper'] ?? null, 'backgroundImage' => $setting['mtg_banner_backgorund'] ?? null])
    </section>
    @if(count($latestUsers) > 0)
    <section class="bg-gry pt-md-5 pt-3 pb-3">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 mb-md-4">
                            <h1 class="Why-Buy-Sell-With text-site-primary">Newly added</h1>
                        </div>
                    </div>
                    <div class="mb-md-2 mt-md-2">
                        <div class="">
                            <div class=" text-center my-md-3">
                                <div class="owl-carousel owl-carousel-newly owl-theme">
                                    @php($total_count = 0)
                                    @foreach($latestUsers as $user_id)
                                    @php(list($collections, $count ) = getUserNewlyCollections(3,$user_id))
                                    @foreach($collections as $collection)
                                    <div class="newly_card_sets item my-3 pt-3">
                                        <a class="py-3 pb-1 text-decoration-none"
                                            href="{{route('mtg.expansion.detail',[$collection->card->url_slug, $collection->card->url_type ,$collection->card->slug])}}"
                                            title="{{$collection->card->name}}">
                                            <img class="{{$collection->card->card_type == 'completed' ? 'comp_set_card p-2' : ''}} rounded-site set_owl_img"
                                                src="{{$collection->card->png_image}}" alt="{{$collection->card->name}}"
                                                loading="lazy">
                                            <p class="bg-site-primary mb-0   text-white py-1 px-2 price_newly">
                                                £{{$collection->price}}</p>

                                            <h4 class="px-2 text-start h6 mt-2 text-black mb-0 text-decoration-none name_newly">
                                                {{ Str::limit($collection->card->name, 85,'..') }}
                                            </h4>
                                        </a>
                                        <a class="text-end hover-blue text-decoration-none"
                                            href="{{route('profile.index',$collection->user->user_name)}}">
                                            <div class="d-flex align-items-center pb-3 ms-3">
                                                <img class="profile_img me-1" src="{{$collection->user->main_image}}"
                                                    alt="">
                                                <div class="w-100 text-start">
                                                    <span>{!! Str::limit($collection->user->user_name, 14,'..') !!}</span>
                                                    <div class="d-flex">
                                                        @include('front.components.user.badges')
                                                        <span class="ms-auto me-3 text-black fw-bold d-flex">
                                                            @include('front.components.user.rating',['rating'=>$collection->user->average_rating,'class'=>'','num_visible'=>'d-none' ,'user'=>$collection->user])
                                                            ( {{$collection->user->reviews ? $collection->user->reviews->count() : 0}} )
                                                        </span>
                                                    </div>   
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    @php($total_count = $total_count + $count)
                                    @if($total_count >= $limit)
                                    @break;
                                    @endif
                                    @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="col-12 text-center pb-3">
                    <a href="{{route('mtg.newly.collection.type',['singles'])}}" class="btn btn-site-primary mt-2 fs-5 px-3"
                    title="View More Collections">View More</a>
                </div>

                <div class="col-12 mt-md-5 mt-2">
                    <div class="row">
                        <div class="col-12 mb-md-4">
                            <h1 class="Why-Buy-Sell-With text-site-primary">Featured Items</h1>
                        </div>
                    </div>
                    <div class="mb-md-2 mt-md-2">
                        <div class="">
                            <div class=" text-center my-3">
                                <div class="owl-carousel owl-carousel-newly owl-theme">
                                    @php($total_count = 0)
                                    @foreach($featuredUsers as $f_user_id)
                                    @php(list($collections, $count ) = getUserFeaturedCollections(3,$f_user_id))
                                    @foreach($collections as $collection)
                                    <div class="newly_card_sets item my-3 pt-3">
                                        <a class="py-3 pb-1 text-decoration-none"
                                            href="{{route('mtg.expansion.detail',[$collection->card->url_slug, $collection->card->url_type ,$collection->card->slug])}}"
                                            title="{{$collection->card->name}}">
                                            <img class="{{$collection->card->card_type == 'completed' ? 'comp_set_card p-2' : ''}} rounded-site set_owl_img"
                                                src="{{$collection->card->png_image}}" alt="{{$collection->card->name}}"
                                                loading="lazy">
                                            <p class="bg-site-primary mb-0   text-white py-1 px-2 price_newly">
                                                £{{$collection->price}}</p>

                                            <h4 class="px-2 text-start h6 mt-2 text-black mb-0 text-decoration-none name_newly">
                                                {{ Str::limit($collection->card->name, 85,'..') }}
                                            </h4>
                                        </a>
                                        <a class="text-end hover-blue text-decoration-none"
                                            href="{{route('profile.index',$collection->user->user_name)}}">
                                            <div class="d-flex align-items-center pb-3 ms-3">
                                                <img class="profile_img me-1" src="{{$collection->user->main_image}}"
                                                    alt="">
                                                    <div class="w-100 text-start">
                                                    <span>{!! Str::limit($collection->user->user_name, 14,'..') !!}</span>
                                                    <div class="d-flex">
                                                        @include('front.components.user.badges')
                                                        <span class="ms-auto me-3 text-black fw-bold d-flex">
                                                            @include('front.components.user.rating',['rating'=>$collection->user->average_rating,'class'=>'','num_visible'=>'d-none' ,'user'=>$collection->user])
                                                            ( {{$collection->user->reviews ? $collection->user->reviews->count() : 0}} )
                                                        </span>
                                                    </div>   
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    @php($total_count = $total_count + $count)
                                    @if($total_count >= $limit)
                                    @break;
                                    @endif
                                    @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="col-12 text-center pb-4">
                    <a href="{{route('mtg.featured.items.type',['singles'])}}" class="btn btn-site-primary mt-2 fs-5 px-3"
                    title="View More Collections">View More</a>
                </div>
                
                
            </div>
        </div>
        
    </section>
    @endif
    <section class="container mb-4 pt-5">
        <div class="row justify-content-center">
            <div class="d-grid gap-2 mt-2 px-1 rounded">
                <div class="bg_dark_shark d-flex justify-content-between rounded-site">
                    <button
                        class="btn btn-large text-white bg_dark_shark border-0 text-start py-3 w-auto bg_primary_hover w-100 rounded-site"
                        type="button" data-bs-toggle="collapse" data-bs-target="#standard" aria-expanded="true"
                        aria-controls="collapseExample">
                        Standard Sets <span><i class="fa-solid fa-caret-down text-site-primary ps-1"></i></span>
                    </button>
                </div>
            </div>
            <div class="collapse mb-2 mt-2 show px-1" id="standard">
                <div class="">
                    <div class=" text-center my-3">
                        <div class="owl-carousel owl-carousel-stan owl-theme">
                            @foreach($standard as $s_item)
                            <div class="card-sets text-center bg-site-dark-hover item">
                                <a class="px-1 btn" href="{{ route('mtg.expansion.set', $s_item->mtgset->slug) }}">
                                    <img src="{{$s_item->mtgset->icon}}" alt="{{$s_item->mtgset->name}}" loading="lazy">
                                    <div class="d-flex justify-content-center">
                                        <hr>
                                    </div>
                                    <h4 class="h3">{{$s_item->mtgset->name}}</h4>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row px-0 d-md-block d-none">
                <div class="d-grid gap-2 mt-2 px-1 ">
                    <div class="bg_dark_shark d-flex justify-content-between rounded-site">
                        <button
                            class="btn btn-large text-white bg_dark_shark border-0 text-start py-3 w-auto bg_primary_hover w-100 rounded-site"
                            type="button" data-bs-toggle="collapse" data-bs-target="#recents" aria-expanded="true"
                            aria-controls="collapseExample">
                            Recent Sets <span><i class="fa-solid fa-caret-down text-site-primary ps-1"></i></span>
                        </button>

                    </div>
                </div>
                <div class="collapse mb-3 mt-3 show" id="recents">
                    <div class="row">
                        @foreach($recents as $r_item)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mt-2 px-1">
                            <div class="card-sets text-center bg-site-dark-hover">
                                <a class="px-1 btn" href="{{ route('mtg.expansion.set', $r_item->slug) }}">
                                    <img src="{{$r_item->icon}}" alt="{{$r_item->name}}" loading="lazy">
                                    <div class="d-flex justify-content-center">
                                        <hr>
                                    </div>
                                    <h4>{{$r_item->name}}</h4>
                                </a>
                            </div>

                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 py-3 text-center">
                    <a href="{{route('mtg.expansion.index')}}"
                        class="btn btn-site-primary mt-2 fs-5 px-3 pro_range_learn_area" title="View All Sets">View All
                        Sets</a>
                </div>
            </div>
    </section>
    <section>
    </section>
    <section>
        @include('front.components.buy-and-sell')
    </section>
</div>
@endsection

@push('js')
<script src="{{ asset('Owl_carousel/js/owl.carousel.min.js') }}"></script>
<script>
    $('.owl-carousel-stan').owlCarousel({
        loop: true,
        margin: 10,
        dots: false,
        nav: true,
        items: 4,
        slideBy: 4,
        autoplay: false,
        // autoplayTimeout: 10000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            768: {
                items: 3
            },
            1025: {
                items: 4
            }
        }
    })

    $('.owl-carousel-newly').owlCarousel({
        loop: true,
        margin: 10,
        dots: false,
        nav: true,
        items: 5,
        slideBy: 4,
        autoplay: false,
        // autoplayTimeout: 10000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 2
            },
            768: {
                items: 3
            },
            1025: {
                items: 4
            },
            1200: {
                items: 5
            }
        }
    })

</script>

@endpush
