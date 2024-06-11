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
                        <div class="col-2 col-lg-1 bg-light-blue py-2 text-center d-flex justify-content-center">
                            <img loading="lazy" class="m-auto img-fluid px-xxl-4 px-xl-3 px-sm-2 py-2"
                                src="{{getStarWarIcon()}}" style="filter: url({{"#".$item->rarity."_rarity"}});"
                                alt="Detail img">
                        </div>
                        <div class="col-10 col-lg-11 bg-dark-blue d-flex text-white text-capitalize">
                            <div class="row align-items-center">
                                <div class="col-md-auto col-12 px-0 mx-1">
                                    <h5 class="fs-5 my-auto fs-sm-14">{{$item->set->code}}</h5>
                                </div>
                                <div class="col-md-auto col-12 px-0 mx-1">
                                    <h1 class="fs-4  my-auto fs-sm-18">{{$item->seo->heading ?? $item->name}}</h1>

                                </div>
                            </div>
                        </div>
                    </div>
                    @if($item->card_type == "single")
                    @include('front.sw.components.singles.detail')
                    @else
                    @include('front.sw.components.sealed.detail')
                    @endif

                </div>
            </div>
            <div class="row shadow_site py-3 px-3">
                <div class=" d-flex w-auto">
                    <p class=" fs-6 m-0 d-flex my-auto">Average Sold Card Price</p>
                    <select name="" class="rounded-1 text-white  bg-site-primary w-auto mx-1 averagePrice" id="">
                        <option value="one">24 hours</option>
                        <option value="seven">7 days</option>
                        <option value="thirty">30 days</option>
                        <option value="all">Lifetime</option>
                    </select>
                    <p class=" fs-6 m-0 d-flex">: </p>
                    <span class="bg-light-blue mx-2 px-2 avgPriceSpan my-auto">{{$item->average_price->one}}</span>
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
            <div class="row shadow_site pt-3 my-2  ">
                <div class="col-lg-12  px-lg-3 d-flex align-items-center justify-content-center">
                    <div class="row w-100">
                        <div class="col-lg-5 col-12 d-md-flex align-items-center justify-content-center">
                            <div class="col-md-5 text-center">
                                <label class="fw-bold fs-5">Card characteristics:</label>
                                <p class="sm-text text-body-secondary fst-italic">Select one or more characteristics
                                </p>
                            </div>
                            <div class="col-md-7">
                                <div class="row d-flex justify-content-center">
                                    <div class="text-center pe-3 w-auto">
                                        <input type="checkbox" class="characteristics" id="myCheckbox80" value="foil"
                                            name="characterstics[]" {{$item->foil == 1 ? '' : 'disabled'}} >
                                        <label for="{{$item->card_foil->attr == "checked" ?'' : 'myCheckbox80'}}" class="p-0 m-0">
                                            <img src="{{asset('images/characterstics/foil.png')}}" class="{{$item->card_foil->class}}" loading="lazy" alt="Foil">
                                        </label>
                                        <p class="sm-text fw-bolder">Foil</p>
                                    </div>
                                    <div class="text-center pe-3 w-auto">
                                        <input type="checkbox" class="characteristics" id="myCheckbox110" value="signed"
                                            name="characterstics[]">
                                        <label for="myCheckbox110" class="p-0 m-0">
                                            <img src="{{asset('images/characterstics/signed.png')}}" loading="lazy" alt="Signed">
                                        </label>
                                        <p class="sm-text fw-bolder">Signed</p>
                                    </div>
                                    <div class="text-center pe-3 w-auto">
                                        <input type="checkbox" class="characteristics" id="myCheckbox120" value="graded"
                                            name="characterstics[]">
                                        <label for="myCheckbox120" class="p-0 m-0">
                                            <img src="{{asset('images/characterstics/graded.png')}}" loading="lazy" alt="Graded">
                                        </label>
                                        <p class="sm-text fw-bolder">Graded</p>
                                    </div>
                                    <div class="text-center pe-3 w-auto">
                                        <input type="checkbox" class="characteristics" id="myCheckbox130" value="altered"
                                            name="characterstics[]">
                                        <label for="myCheckbox130" class="p-0 m-0">
                                            <img src="{{asset('images/characterstics/altered.png')}}" loading="lazy" alt="Altered">
                                        </label>
                                        <p class="sm-text fw-bolder">Altered</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3  col-sm-6 mt-md-0 mt-1">
                            <select name="condition" id="condition"
                                class="form-select-lg rounded border-site-primary item_condition fill_condition pe-lg-5 rounded-1 fs-6 w-100">
                                <option class="form-control" value="" selected="">Condition</option>
                                <option class="form-control" value="NM">Near Mint</option>
                                <option class="form-control" value="LP">Light Play</option>
                                <option class="form-control" value="MP">Moderate Play</option>
                                <option class="form-control" value="HP">Heavy Play</option>
                                <option class="form-control" value="DMG">Damaged</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6 mt-md-0 mt-1">
                            <select name="language" id="language"
                                class="form-select-lg rounded border-site-primary pe-lg-5 fill_lang item_language rounded-1 fs-6 w-100">
                                <option class="form-control " value="" selected="">Language</option>
                                @if($item->card_languages)
                                    @foreach($item->card_languages  as $key=> $lang)
                                    <option class="form-control " value="{{$key}}">{{$lang}}</option>
                                    @endforeach
                                @else
                                <option class="form-control" value="en">English</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6 mt-md-0 mt-1">
                            <select class="form-select-lg border-site-primary rounded-1 fs-6 w-100 expansion_order">
                                <option class="form-control" value="asc">Price - Ascending</option>
                                <option class="form-control" value="desc">Price - Descending</option>
                            </select>
                        </div>

                        <div class="col-lg-1 col-md-3 col-sm-6 mt-md-0 mt-1 mb-sm-0 mb-1">
                            <button class="btn btn-site-primary w-100 filter" title="Filter">Filter</button>
                        </div>



                    </div>

                    @if($item->card_type == "single")
                        <div class="col-lg-3 col-6 d-none">
                            <select class="form-select-lg border-site-primary rounded-1 pe-lg-5 fs-6 w-100 text-capitalize changeFoil">
                                @if($item->finishes)
                                    @foreach(json_decode($item->finishes) as $foil)
                                    <option class="form-control" class="text-capitalize" value="{{$foil}}">{{$foil}}</option>
                                    @endforeach
                                @else
                                    <option class="form-control" class="text-capitalize" value="{{$item->foil ? 'foil' : 'nonfoil'}}">{{$item->foil ? 'Foil' : 'Nonfoil'}}</option>
                                @endif
                            </select>
                        </div>
                        @endif
                </div>

            </div>

            @if($item->listing_collection->count() > 0)
            <div class="append_cards">
                @include('front.components.product-listing' , ['collections'=>$item->listing_collection])
            </div>
            @else
            <div class="row shadow_site py-5 my-2  ">
                <div class="col-12 text-center">
                    <p>This product is not currently available.</p>
                    <div class="d-flex justify-content-center">
                            {{-- @if($auth)
                                @if((auth()->user()->role != 'buyer' && auth()->user()->role != 'admin'))
                                <button class="btn btn-site-primary"  data-bs-toggle="modal" data-bs-target="#forSale" title="Sell one like this">
                                    Sell one like this
                                </button>
                                @endif
                            @else
                            <button class="btn btn-site-primary" data-bs-toggle="modal" data-bs-target="#loginModal" title="Sell one like this">
                                Sell one like this
                            </button>
                            @endif --}}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
</div>
@include('front.modals.single-modal')
@include('front.modals.for-sale')



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
        fill_lang = $('.fill_lang').val();
        fill_condition = $('.fill_condition').val();
        senRequest();
    });
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
