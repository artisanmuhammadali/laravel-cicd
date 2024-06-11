@extends('layouts.app')
@section('title', $title)
@section('description', $description)
@push('css')
<style>
    .dataTables_length,
    .dataTables_info,
    .dataTables_paginate {
        display: none !important;
    }
    .centered-text > .dispatch-badge-text{
        font-size: 10px !important;
    }
    .user-badges-size{
        width: 16px !important;
        height: 25px !important;
    }
    .fa-star{
        font-size: 12px;
    }
    @media only screen and (max-width: 769px) {
        .dataTables_filter {
            text-align: start !important;
        }
    }

</style>
<link href="{{asset('front/styles/tagify.css')}}" rel="stylesheet">

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
                        <h1 class="Why-Buy-Sell-With text-site-primary">{{$h1}}</h1>
                    </div>
                    <div class="col-12 px-0 filter-section">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row mx-0 shadow_site my-2 py-3 ">
                                <div class="col-lg-6 col-12">
                                    <ul class="nav nav-tabs border-bottom-0 d-flex justify-content-between" id="myTab"
                                        role="tablist">
                                        <li class="nav-item " role="presentation">
                                            <a href="{{route('mtg.marketplace',['single-cards'])}}"
                                                class=" {{request()->type == 'single-cards' || !request()->type  ? 'active' : ''}} nav-link text-black rounded-1  px-sm-2 px-1 fs-6 d-flex nav-link-mtg"
                                                title="Single Products">Single <span
                                                    class="d-sm-flex d-none ps-1">Products</span></a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a href="{{route('mtg.marketplace',['sealed-products'])}}"
                                                class=" {{request()->type == 'sealed-products'  ? 'active' : ''}} nav-link text-black rounded-1 px-sm-2 px-1 fs-6 d-flex nav-link-mtg"
                                                title="Sealed Products">Sealed <span
                                                    class="d-sm-flex d-none ps-1">Products</span></a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a href="{{route('mtg.marketplace',['complete-sets'])}}"
                                                class="{{request()->type == 'complete-sets'  ? 'active' : ''}} nav-link text-black rounded-1 px-sm-2 px-1 fs-6 nav-link-mtg"
                                                title="Full Sets">Full Sets</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6 col-12 text-end d-md-flex justify-content-end mt-md-0 mt-2 ">
                                    <ul class="nav nav-tabs border-bottom-0 d-flex justify-content-between" id="myTab" role="tablist">
                                        <li class="nav-item "  role="presentation">
                                            <button class="btn text-white rounded-1 active tab_head_item_front border mx-1" data-id="list_view" data-bs-toggle="tab"  data-bs-target="#list-tab-pane" type="button" role="tab"  aria-controls="list-tab-pane" aria-selected="true" title="List View">
                                                <i class="fa fa-list" aria-hidden="true"></i>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="btn text-black rounded-1 tab_head_item_front border mx-1" data-id="card_view" data-bs-toggle="tab" data-bs-target="#card-tab-pane" type="button" role="tab" aria-controls="card-tab-pane" aria-selected="false" title="Card View">
                                                <i class="fa fa-th" aria-hidden="true"></i>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="btn rounded-1 btn-site-primary mx-1"  data-bs-toggle="modal" data-bs-target="#detailPgFilter" type="button" aria-selected="false" title="Filter">
                                                <i class="fa fa-filter" aria-hidden="true"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="append_sort append_cards">
                    @include('front.mtg.marketplace.components.tabs')
                </div>
            </div>
        </div>
</div>
</section>

</div>

@include('front.modals.listing-filter')
@endsection

@push('js')
@include('front.mtg.marketplace.components.searchScript',['id'=>0 , 'blade'=>'detailPg'])

<script src="{{asset('front/scripts/jQuery.tagify.min.js')}}"></script>
<script>
    $('.tags').tagify();
</script>
<script>
    $(document).on('click', '.filter', function () {
        fill_lang = $(this).closest('.row').find('.fill_lang').val();
        fill_condition = $(this).closest('.row').find('.fill_condition').val();
        attribute = $(this).closest('.row').find('.expansion_attribute').val();
        set_name = $(this).closest('.row').find('.set_name').val();
        set_name = $(this).closest('.row').find('.set_name').val();
        exact_set_name = $(this).closest('.row').find('.exact_set_name').val();
        var filter_order = $(this).closest('.row').find('.expansion_order').val();
        $('.expansion_order').val(filter_order);
        badgeOnFloatingBtn(fill_lang, fill_condition, filter_order);
        senRequest();
    });

    function badgeOnFloatingBtn(lang, con, order) {
        var selected_filter_count = 0;
        $('.characteristics:checked').each(function () {
            selected_filter_count++;
        });
        selected_filter_count = lang != '' ? selected_filter_count + 1 : selected_filter_count;
        selected_filter_count = con != '' ? selected_filter_count + 1 : selected_filter_count;
        selected_filter_count = selected_filter_count > 0 || order == 'desc' ? selected_filter_count + 1 :
            selected_filter_count;
        $('.filters_count').text(selected_filter_count);
        selected_filter_count > 0 ? $('.filters_badge').removeClass('d-none') : $('.filters_badge').addClass('d-none');

    }

</script>
@endpush
