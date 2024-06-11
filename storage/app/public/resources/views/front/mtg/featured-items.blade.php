@extends('layouts.app')
@section('title', "Featured MTG Cards & Deals | Very Friendly Sharks")
@section('description', "Explore top picks and exclusive deals on MTG cards at Very Friendly Sharks. Curated selections
to enhance your gameplay and collection!")
@push('css')
<style>
    @media only screen and (max-width: 769px) {
        .dataTables_length{
            display: none !important;
        }
        .dataTables_filter{
            text-align: start !important;
        }
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
    <section class="container mb-4">
        <div class="row justify-content-center">
            <div class=" col-12 my-5">
                <div class="row">
                    <div class="col-12 mb-4">
                        <h1 class="Why-Buy-Sell-With text-site-primary">Featured Items</h1>
                    </div>
                    <div class="col-12 px-0">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row mx-0 shadow_site my-2 py-3 ">
                                <div class="col-lg-6 col-12">
                                    <ul class="nav nav-tabs border-bottom-0 d-flex justify-content-between" id="myTab"
                                        role="tablist">
                                        <li class="nav-item " role="presentation">
                                            <a href="{{route('mtg.featured.items.type',['singles'])}}"
                                                class=" {{request()->type == 'singles' || !request()->type  ? 'active' : ''}} nav-link text-black rounded-1  px-sm-2 px-1 fs-6 d-flex nav-link-mtg"
                                                title="Single Products">Single <span
                                                    class="d-sm-flex d-none ps-1">Products</span></a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a href="{{route('mtg.featured.items.type',['sealed-products'])}}"
                                                class=" {{request()->type == 'sealed-products'  ? 'active' : ''}} nav-link text-black rounded-1 px-sm-2 px-1 fs-6 d-flex nav-link-mtg"
                                                title="Sealed Products">Sealed <span
                                                    class="d-sm-flex d-none ps-1">Products</span></a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a href="{{route('mtg.featured.items.type',['complete-sets'])}}"
                                                class="{{request()->type == 'complete-sets'  ? 'active' : ''}} nav-link text-black rounded-1 px-sm-2 px-1 fs-6 nav-link-mtg"
                                                title="Full Sets">Full Sets</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6 col-12 text-end d-md-block d-none">
                                    <a href="#" class="btn btn-site-primary" data-bs-toggle="modal" data-bs-target="#detailPgFilter">
                                        <i class="fa fa-filter" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="append_sort append_cards">
                    @include('front.components.collection.newly-added',
                    ['latestUsers'=>$latestUsers,'type'=>request()->type,'fun_type'=>'featured'])
                </div>
            </div>
        </div>
</div>
</section>

</div>
<a href="#" class="float d-md-none d-block btn btn-site-primary" data-bs-toggle="modal" data-bs-target="#detailPgFilter">
    <i class="fa fa-filter my-float " aria-hidden="true"></i>
    <span class="position-absolute top-1 translate-middle badge rounded-pill bg-dark-blue filters_badge d-none" style="right:-12px">
        <span class="filters_count">0</span>
    </span>
</a>
@include('front.modals.listing-filter')
@endsection

@push('js')
@include('user.components.collection.searchScript',['id'=>0 , 'blade'=>'detailPg'])
<script>
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
</script>
@endpush
