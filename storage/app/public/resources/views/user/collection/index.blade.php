@extends('user.layout.app')
@section('title','My Collection')
@push('css')
<link rel="stylesheet" href="{{ asset('admin/assets/dashboard/css/dataTables.bootstrap4.min.css') }}" />
<style>
    .dropdown-menuu {
        position: absolute;
        z-index: 1000;
        display: none;
        min-width: 10rem;
        padding: 0.5rem 0;
        margin: 0;
        font-size: 1rem;
        color: #6e6b7b;
        text-align: left;
        list-style: none;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid rgba(34, 41, 47, 0.05);
        border-radius: 0.357rem;
    }

    .dropdown-menuu.show {
        display: block !important;
    }


   .custom_datatable > div.row {
  margin: 0;
}

.custom_datatable div.dataTables_length label {
  font-weight: normal;
  text-align: left;
  white-space: nowrap;
}
.custom_datatable div.dataTables_filter label, .custom_datatable div.dataTables_length label {
  margin-top: 1rem;
  margin-bottom: 0.5rem;
}

.custom_datatable div.dataTables_length select {
  width: auto;
  display: inline-block;
}
.custom_datatable div.dataTables_filter select, .custom_datatable div.dataTables_length select {
  background-position: calc(100% - 3px) 11px, calc(100% - 20px) 13px, 100% 0;
  width: 5rem;
  margin: 0 0.5rem;
}
.float-right {
  text-align: right;
}
@media (max-width: 576px) {
    .fs-12p-sm{
    font-size:12px !important;
}
    }

</style>
@endpush
@section('content')
<div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
    <div class="content-body">
        <section class="app-user-view-app-user-view-account d-flex justify-content-center">
            <div class="row w-100" id="table-hover-row">
                <div class="col-12 p-sm-0">
                    <div class="card">
                        <div class="card-header d-flex justify-content-center px-sm-2 px-0">
                            <div class="row d-flex w-100 justify-content-between bg-white">
                                <div class="col-md-6 col-12 text-md-start text-center">
                                    <h4>My Collections</h4>
                                </div>
                                <div class="col-md-6 col-12 text-md-end text-center px-0">
                                    <span class="badge bg-primary">Active Collection Amount : £
                                        <span class="total_active">{{$active_sum ?? 0}}</span></span>
                                    <span class="badge bg-warning">Inactive Collection Amount : £
                                    <span class="total_inactive">{{$inactive_sum ?? 0}}</span></span>
                                </div>
                            </div>
                            <div class="row d-flex w-100 justify-content-between bg-white ">
                                <div class="col-4 px-md-2 py-1 ">
                                    <a href="{{ route('user.collection.index',['single']) }}">
                                        <div class="card border-site-primary p-sm-5 border-1 m-0 {{$type == 'single' ?
                                            'bg-site-primary' : '' }}">
                                            <div class="card-body text-center p-sm-0">
                                                <img class="w-25 w-sm-28p" src="{{asset('images/userCollection/single.svg')}}"
                                                    alt="">
                                                <p class="md-text text-info m-0 d-sm-none d-none d-md-block">
                                                    Singles
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-4 px-md-2 py-1">
                                    <a href="{{ route('user.collection.index',['sealed']) }}">
                                        <div class="card border-site-primary p-sm-5 border-1 m-0 {{$type == 'sealed' ?
                                            'bg-site-primary' : '' }} ">
                                            <div class="card-body text-center p-sm-0">
                                                <img class="w-25 w-sm-28p" src="{{asset('images/userCollection/sealed.svg')}}"
                                                    alt="">
                                                <p class="md-text text-info m-0 d-sm-none d-xs-none d-none d-md-block">
                                                    Sealed
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-4 px-md-2 py-1">
                                    <a href="{{ route('user.collection.index',['completed']) }}">
                                        <div class="card border-site-primary p-sm-5 border-1 m-0 {{$type == 'completed' ?
                                            'bg-site-primary' : '' }} ">
                                            <div class="card-body text-center p-sm-0">
                                                <img class="w-25 w-sm-28p" src="{{asset('images/userCollection/fullSet.svg')}}"
                                                    alt="">
                                                <p class="md-text text-info m-0 d-sm-none d-xs-none d-none d-md-block">
                                                    Full Sets
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="row d-flex w-100 justify-content-between px-md-50 px-0 ">
                                <div class="col-md-6  d-flex justify-content-center">
                                    <div class="row w-100 justify-content-between">
                                        <!-- <div class="col-md-4 col-12  px-0 d-flex align-items-center mb-md-0 mb-50">
                                            <input type="text" class="form-control keyword" placeholder="Search Within Collection">
                                        </div> -->



                                    </div>
                                </div>
                                <div class="col-md-6 d-flex justify-content-between text-center d-grid gap-2">
                                    <button type="button" class="btn btn-outline-primary waves-effect fs-sm-drop w-100 mt-sm-0 mt-50"
                                        data-bs-toggle="modal" data-bs-target="#addCard" title="Add">
                                        <i data-feather='plus'></i>
                                        <span class="text-capitalize d-sm-none d-none d-md-block">Add
                                            {{$type == "completed" ? 'full sets' : $type}}</span>
                                    </button>
                                    <a href="{{route('user.collection.bulk.upload',$type)}}" type="button"
                                        class="btn btn-outline-primary waves-effect fs-sm-drop w-100 mt-sm-0 mt-50" title="Add">
                                        <i data-feather='layers'></i>
                                        <span class="d-sm-none d-none d-md-block">Add Bulk</span>
                                    </a>
                                    @if($type == "single")
                                    <a href="{{route('user.collection.csv.upload',$type)}}" type="button"
                                        class="btn btn-outline-primary waves-effect fs-sm-drop w-100 mt-sm-0 mt-50" title="Add">
                                        <i data-feather='upload'></i>
                                        <span class="d-sm-none d-none d-md-block">Upload Csv</span>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            @include('user.collection.components.filter')
                            <div class="">
                                @include('user.components.collection.filterCollections')
                            </div>
                        </div>

                        <div class="card-body  p-sm-0">
                            <div class="table-responsive  material-datatables custom_datatable">
                                <div class="row">
                                    <div class="col-3 col-md-6">
                                        <div class="dataTables_length " id="DataTables_Table_0_length"><label class="d-flex"><span class="d-sm-none d-none d-md-block">Show</span>
                                                <select name="DataTables_Table_0_length"
                                                    aria-controls="DataTables_Table_0"
                                                    class="custom-select show_limit custom-select-sm form-control form-control-sm">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                    <option value="500">500</option>
                                                    <option value="1000">1000</option>
                                                </select> <span class="d-sm-none d-none d-md-block">entries</span></label></div>
                                    </div>
                                    <div class=" col-9 col-md-6 float-right pe-0">
                                        <button  class="btn btn-warning select_all_btn">Select Whole <span class="total_collection_count">{{$list->total()}}</span> items</button>
                                    </div>
                                    <div class="col-sm-12 col-md-12 ">
                                        <div class="append_cards">
                                            <p class="fw-6 mb-0 text-warning fw-bold pt-1 pb-50 d-sm-none d-xs-none d-none d-md-block"><span><i class="fa-solid fa-circle-info fs-6 me-25"></i></span>
                                                To bulk edit multiple items tap or click on the box next to them and click "Bulk Edit of Selected Items" on the menu that appears on the screen
                                            </p>
                                            @include('user.components.collection.table')
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
                @include('components.spinnerLoader')
       
                    <div class="col collectionActionDiv d-none bg-site-primary px-2 py-1 d-flex d-grid justify-content-sm-start justify-content-center pe-xxl-0 gap-1">
                        <button class="btn btn-danger publishBtn  waves-effect waves-float waves-light mb-1 mb-md-0 mx-sm-25"
                        data-bs-toggle="modal" data-bs-target="#deleteCollection"><i class="fa fa-trash d-block d-md-none d-lg-none d-xl-none"></i> <span class="d-sm-none d-none d-md-block">Delete Selected Items</span></button>
                        @if(vfsWebConfig() && $auth->verified)
                        <button class="btn btn-info publishBtn for_publish d-none  mb-1 mb-md-0 mx-sm-25" data-bs-toggle="modal"
                            data-bs-target="#inactiveCollection"><i class="fa fa-ban d-block d-md-none d-lg-none d-xl-none"></i> <span class="d-sm-none d-none d-md-block">Inactive Selected Items</span></button>
                        <button class="btn btn-primary publishBtn for_unpublish d-none site-display  mb-1 mb-md-0  mx-sm-25"
                            {{$auth->verified ? "" : "disabled"}} data-bs-toggle="modal"
                            data-bs-target="#publishCollection"><i class="fa fa-toggle-on d-block d-md-none d-lg-none d-xl-none"></i> <span class="d-sm-none d-none d-md-block">Publish Selected Items</span></button>
                        @endif
                        <button class="btn btn-info publishBtn site-display   mb-1 mb-sm-0 ms-sm-25 me-sm-50 me-0 " data-bs-toggle="modal"
                        data-bs-target="#updatePrice"><i class="fa fa-eur d-block d-md-none d-lg-none d-xl-none"></i> <span class="d-sm-none d-none d-md-block">Edit Price of Selected Items</span></button>
                    <div class="hide_on_total mb-sm-0 mb-1">
                        <button data-bs-toggle="modal"
                 data-bs-target="#updateBulk" type="button" data-link="{{route('user.collection.bulk.update.ids')}}" class="btn btn-info publishBtn site-display  bulk_wid  me-sm-50 me-0 h-100"><i class="d-block d-md-none d-lg-none d-xl-none fa fa-pencil"></i> <span class="d-sm-none d-none d-md-block">Bulk Edit of Selected Items</span></button>
                    </div>
                    <div class="">
                        <button disabled class="btn btn-outline-primary text-white "><span class="d-sm-none d-none d-md-block">Total Selected Items:</span> <span class="total_collection_count">0</span></button>
                    </div>
                    </div>
    
        </div>
        </section>
    </div>
{{-- </div> --}}


<input type="hidden" value="{{$type}}" class="mtg_card_type">
@include('user.layout.modals.collection.add-card')
@include('user.layout.modals.collection.publish-collection')
@include('user.layout.modals.collection.inactive-collection')
@include('user.layout.modals.collection.bulk-delete')
@include('user.layout.modals.collection.update-price')
@include('user.layout.modals.collection.csv-upload')
@include('user.layout.modals.collection.prevent')
@include('user.layout.modals.collection.update-bulk')
@endsection
@push('js')
<script>
    $(document).on('change', '#show_inactive_modal', function () {
        if ($(this).is(':checked')) {
            $('.close_form_btn').addClass('d-none');
            $('.show_form_btn').removeClass('d-none');
        } else {
            $('.close_form_btn').removeClass('d-none');
            $('.show_form_btn').addClass('d-none');
        }
    })
    $(document).on('click', '.toggle_drop_men', function () {
        $(this).closest('div').find('.dropdown-menuu').toggleClass('show');
    })
    $(document).on('click', '.itemm', function () {
        let tex = $(this).text();
        $(this).closest('.mau_div').find('.toggle_drop_men').text(tex);
        $(this).closest('.mau_div').find('.dropdown-menuu').toggleClass('show');
        let sym = $(this).data('val');
        $('.fill_pow_order').val(sym);
    })
    $(document).ready(function () {
        @if($auth->verified && $auth ->store->kyc_payment && !$auth->store-> show_inactive_modal && authUserCollectionCount(0) > 0)
        $('.preventCollection').modal('show');
        @endif
        var body = document.body,
            html = document.documentElement;
        var margin_top = $(window).height() / 20;
        $('.footer-border').css('margin-bottom', margin_top);
    })

</script>
<script>
    $(document).ready(function () {
        var body = document.body,
            html = document.documentElement;
        var margin_top = $(window).height() / 20;
        $('.footer-border').css('margin-bottom', margin_top);
    })

</script>
@include('user.components.collection.searchScript',['id'=>$auth->id , 'blade'=>'collectionPg'])
@endpush
