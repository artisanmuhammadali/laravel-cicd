@extends('layouts.app')
@section('title',$item->seo->title ?? "")
@section('description',$item->seo->meta_description ?? "")
@push('css')
<style>
    .ver_drop{
        width: max-content;
  background: white;
  margin-top: 5px;
  border-radius: 5px;
  overflow: auto;
  max-height: 346px;
  position:absolute;
  z-index:999;
  padding-left: 0rem !important;
    }
    .ver_drop li{
        list-style:none;
    }
</style>
@endpush
@section('content')
<?php
include error_reporting(0);
?>
<div class="container-fluid p-0">
    <section>
        @include('front.components.breadcrumb')
    </section>
    <section>
        <div class="container py-3">
            <div class="row shadow_site py-3 my-2 ">
                <div class="col-12">
                    <div class="row  px-md-4 px-2 mb-2">
                        <div class="col-2 col-lg-1 bg-light-blue py-1 text-center">
                            <img loading="lazy" class="m-auto img-fluid px-xxl-4 px-xl-3 px-sm-2 py-2 set_icon"
                                src="{{asset($item->set->icon)}}" style="filter: url({{"#".$item->rarity."_rarity"}});"
                                alt="Detail img">
                        </div>
                        <div class="col-10 col-lg-11 bg-dark-blue d-flex text-white text-capitalize">
                            <div class="row align-items-center">
                                <div class="col-md-auto col-12 px-0 mx-1 d-md-block d-none">
                                    <h5 class="fs-5 my-auto fs-sm-14">{{$item->set_code}}</h5>
                                </div>
                                <div class="col-md-auto col-12 px-0 mx-1">
                                    <h1 class="fs-4  my-auto fs-sm-18">{{$item->seo->heading ?? $item->name}}</h1>

                                </div>
                                @if($item->name_attr != "")
                                <div class="col-md-auto col-12 px-0 mx-1">
                                    <p class="fst-italic fs-5 my-auto fs-sm-14">{{$item->name_attr }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($item->card_type == "single")
                    @include('front.components.singles.detail',['item'=>$item])
                    @else
                    @include('front.components.sealed.detail',['item'=>$item])
                    @endif

                </div>
            </div>
            <div class="row shadow_site py-3 px-3">
                <div class=" d-flex w-auto">
                    <p class=" fs-6 m-0 d-flex my-auto product-listing-mobile-text">Average Sold Card Price</p>
                    <select name="" class="rounded-1 text-white  bg-site-primary w-auto mx-1 averagePrice product-listing-mobile-text" id="">
                        <option value="one">24 hours</option>
                        <option value="seven">7 days</option>
                        <option value="thirty">30 days</option>
                        <option value="all">Lifetime</option>
                    </select>
                    <p class=" fs-6 m-0 d-flex">: </p>
                    <span class="bg-light-blue mx-2 px-2 avgPriceSpan my-auto product-listing-mobile-text">{{$item->average_price->one}}</span>
                </div>
            </div>
            @if($item->warningMsg)
            <div class="alert site-alert-warning d-flex align-items-center my-2 mx-4 " role="alert">
                <i class="text-white fs-3 fa-solid fa-circle-exclamation me-3"></i>
                <p class="fs-alert-warning mb-0">
                    {{$item->warningMsg}}
                </p>
            </div>
             @endif
             @if($item->legalCard)
            <div class="alert site-alert-warning d-flex align-items-center my-2 mx-4 " role="alert">
                <i class="text-white fs-3 fa-solid fa-circle-exclamation me-3"></i>
                <p class="fs-alert-warning mb-0">
                    This Card is not Tournament Legal
                </p>
            </div>
            @endif
            <div class="row shadow_site pt-3 my-2  d-md-flex d-none">
                <div class="col-lg-12  px-lg-3 d-flex align-items-center justify-content-center">
                    @include('front.components.collection.filter',['id1'=>'myCheckbox80','id2'=>'myCheckbox180','id3'=>'myCheckbox120','id4'=>'myCheckbox130'])
                </div>
            </div>
            @if($listing_count > 0)
            <div class="append_cards">
                @include('front.components.product-listing' , ['collections'=>$collections])
            </div>
            @else
            <div class="row shadow_site py-5 my-2  ">
                <div class="col-12 text-center">
                    <p>This product is not currently available.</p>
                    <div class="d-flex justify-content-center">
                            @if($auth)
                                @if((auth()->user()->role != 'buyer' && auth()->user()->role != 'admin'))
                                <button class="btn btn-site-primary"  data-bs-toggle="modal" data-bs-target="#forSale" title="Sell one like this">
                                    Sell one like this
                                </button>
                                @endif
                            @else
                            <button class="btn btn-site-primary" data-bs-toggle="modal" data-bs-target="#loginModal" title="Sell one like this">
                                Sell one like this
                            </button>
                            @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
</div>
<a href="#" class="float d-md-none d-block btn btn-site-primary" data-bs-toggle="modal" data-bs-target="#detailPgFilter">
    <i class="fa fa-filter my-float " aria-hidden="true"></i>
    <span class="position-absolute top-1 translate-middle badge rounded-pill bg-dark-blue filters_badge d-none" style="right:-12px">
        <span class="filters_count">0</span>
    </span>
</a>
@include('front.modals.single-modal')
@include('front.modals.for-sale')
@include('front.modals.product-listing-filter')



<input type="hidden" class="item_foil">
@endsection

@push('js')

@include('user.components.collection.searchScript',['id'=>$item->id , 'blade'=>'detailPg'])
<script>
    var avgPrices = {!! json_encode($item->average_price) !!}
    var foil = '';
    
    var checkboxValues = [];
    // change product foil
    $(document).on('click', '.characteristics', function () {
        var foil = $(this).val();
        var myArray = ['foil', 'nonfoil'];
        if ($.inArray(foil, myArray) !== -1) {
            foil = foil == "foil" && $(this).is(':checked') ? 'foil' : 'nonfoil';
            changeFoil(foil)
        }
    });

    $(document).on('click', '.filter', function () {
        fill_lang = $(this).closest('.row').find('.fill_lang').val();
        fill_condition = $(this).closest('.row').find('.fill_condition').val();
        attribute = $(this).closest('.row').find('.expansion_attribute').val();
        var filter_order = $(this).closest('.row').find('.expansion_order').val();
        $('.expansion_order').val(filter_order);
        badgeOnFloatingBtn(fill_lang , fill_condition , filter_order);
        senRequest();
    });
    function badgeOnFloatingBtn(lang , con , order)
    {
        var selected_filter_count = 0;
        $('.characteristics:checked').each(function(){
            selected_filter_count++;
        });
        selected_filter_count = lang != '' ? selected_filter_count+1 : selected_filter_count;
        selected_filter_count = con != '' ? selected_filter_count+1 : selected_filter_count;
        selected_filter_count = selected_filter_count > 0 || order == 'desc' ? selected_filter_count+1 : selected_filter_count;
        $('.filters_count').text(selected_filter_count);
        selected_filter_count > 0 ? $('.filters_badge').removeClass('d-none') : $('.filters_badge').addClass('d-none') ;
        
    }
    $(document).ready(function () {
        var foil = $('.changeFoil').val();
        changeFoil(foil);
        $.ajax({
            type: "GET",
            url: '{{route('cart.empty.cart.after.day')}}',
        });

    })
    function changeFoil(foil) {
        if (foil == "foil" || foil == "etched") {
            $('.ColorGradientDiv').addClass('rainbow');
            $('.ShineDiv').addClass('shine');
            $('[name="foil"]').prop('checked', 'true');
            $('.item_foil').val(1);
        } else {
            $('.ColorGradientDiv').removeClass('rainbow');
            $('.ShineDiv').removeClass('shine');
            $('.item_foil').val(0);
        }
    }

    $(document).on('click','.drop-ver-toggle',function(){
        $('.ver_drop').toggleClass('hide');
    })

</script>
<script>
    $(document).on('change','.averagePrice',function(){
        var index = $(this).val();
        $('.avgPriceSpan').text(avgPrices[index]);
    })
</script>
@endpush
