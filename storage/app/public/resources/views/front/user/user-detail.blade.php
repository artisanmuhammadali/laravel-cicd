@extends('layouts.app')
@section('title', $user->user_name.' Shop Page | Very Friendly Sharks Card Market')
@section('description', "Check out our users' Very Friendly Sharks shop pages to buy
directly from your favourite places and become a member today!")
@section('metaTag')
<meta name="robots" content="noindex , follow">
@endsection
@push('css')
@endpush

@section('content')

<section>
    <div class="container my-md-5 py-3 pe-md-0">
        <div class="row mx-0">
            <div class="col-12">
                <div class="row shadow_site px-md-0 px-2">
                    <div class="col-sm-3 col-3 d-flex justify-content-center my-2">
                        <div class=" d-flex justify-content-center">
                            <img class="card-img-top rounded-circle user_detail" src="{{$user->main_image}}"
                                alt="Card image cap">
                        </div>
                    </div>
                    <div class="col-sm-9 d-flex col-9 ">
                        <div class="card-body">
                            <div class="row py-3">
                                <div class="col-md-5 order-md-2">
                                    <h1 class="card-title fw-bold fs-3 mb-2">{{$user->user_name}}</h1>
                                    {{--<p class="mb-0 md-text text-uppercase">{{$user->user_name}}</p>--}}
                                    @if(auth()->user() && auth()->user()->role != "admin"  && !($user->id == auth()->user()->id))
                                    @if($user->block_by_auth)
                                    <a class="btn btn-site-danger"
                                        href="{{route('user.block.destroy',$user->block_by_auth->id)}}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Unblock the User"><i
                                            class="fa-sharp fa-solid fa-ban"></i></a>
                                    @elseif($user->fav_by_auth)
                                    <a class="btn btn-red"
                                        href="{{route('user.favourite.destroy',$user->fav_by_auth->id)}}"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Remove from Favourite"><i class="fa-solid fa-heart"></i></a>
                                    @else
                                    <a class="btn btn-site-primary" href="{{route('user.block.add',$user->user_name)}}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Block the User"><i
                                            class="fa-sharp fa-solid fa-ban"></i></a>
                                    <a class="btn btn-site-primary"
                                        href="{{route('user.favourite.add',$user->user_name)}}" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Add to Favourite"><i
                                            class="fa-regular fa-heart"></i></a>
                                    @endif
                                    <form action="{{route('help')}}" style="display: contents" method="GET"
                                        enctype="multipart/form-data">
                                        <input type="hidden" name="type" value="report">
                                        <input type="hidden" name="user_name" value="{{$user->user_name}}">
                                        <button class="btn btn-warning text-white" title="Report User" type="submit"><i
                                                class="fa fa-exclamation-circle" aria-hidden="true"></i></button>
                                    </form>
                                    @endif
                                </div>
                                <div class="col-md-7 ">
                                    <h2 class="card-title fw-bold text-uppercase fs-5">{{$user->role}} Account</h2>
                                    <p class=" mb-0 md-text text-capitalize">Member Since:
                                        {{$user->created_at->format('Y/m/d')}}</p>
                                        <p class="mb-0 fw-bolder mt-rating me-1">{{$user->average_rating == 0.0 ? 0 : (int)$user->average_rating}}.0</p>
                                        <!-- <p class="mb-0 fs-12">Average Rating: {{$user->average_rating == 0.0 ? 0 : (int)$user->average_rating}}</p> -->
                                    <div class="d-flex">
                                        @include('front.components.user.rating',['rating'=>$user->average_rating,'class'=>'','num_visible'=>''])
                                    </div>
                                    <div class="mt-1 d-flex">
                                        @if($user->verified)
                                        <img class="user-badges-size" src="{{asset('images/badges/verifiedSeller.svg')}}" alt=""
                                            title="Verified Seller">
                                        @endif
                                        @if($user->tire_badge)
                                        <img class="user-badges-size" src="{{asset('images/badges/sellerTier.svg')}}" alt=""
                                            title="Tier 1 Seller">
                                        @endif
                                        @if($user->dispatch_badge->day)
                                        <div class="position-relative" style="width: fit-content"
                                            title="{{$user->dispatch_badge->lable}}">
                                            <img class="user-badges-size" src="{{asset('images/badges/dispatches.svg')}}" alt="">
                                            <div class="centered-text">
                                                <p class="m-0 small">{{$user->dispatch_badge->day}}</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mx-0 my-2 py-3 ">
            <div class="col-lg-12 mb-2  px-0">
                <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
                    <li class="nav-item nav-tab-user-detail" role="presentation">
                        <button class="nav-link active color_black nav-tab-user-btn" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                            type="button" role="tab" aria-controls="home" aria-selected="true">Collections</button>
                    </li>
                    <li class="nav-item nav-tab-user-detail" role="presentation">
                        <button class="nav-link color_black review_btn nav-tab-user-btn" id="review-tab" data-bs-toggle="tab" data-bs-target="#review"
                            type="button" role="tab" aria-controls="review" aria-selected="false">Reviews</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row mx-0 shadow_site my-2 py-3 ">
                            <div class="col-lg-6 col-12  mb-2">
                                <ul class="nav nav-tabs border-bottom-0 d-flex justify-content-between" id="myTab"
                                    role="tablist">
                                    <li class="nav-item " role="presentation">
                                        <a href="{{route('profile.index',$user->user_name)}}/single"
                                            class=" {{$type=='single' ? 'active' : ''}} nav-link text-black rounded-1  px-sm-2 px-1 fs-6 d-flex nav-link-mtg"
                                            title="Single Products">Single <span
                                                class="d-sm-flex d-none ps-1">Products</span></a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="{{route('profile.index',$user->user_name)}}/sealed"
                                            class=" {{$type=='sealed' ? 'active' : ''}} nav-link text-black rounded-1 px-sm-2 px-1 fs-6 d-flex nav-link-mtg"
                                            title="Sealed Products">Sealed <span
                                                class="d-sm-flex d-none ps-1">Products</span></a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="{{route('profile.index',$user->user_name)}}/completed"
                                            class="{{$type=='completed' ? 'active' : ''}} nav-link text-black rounded-1 px-sm-2 px-1 fs-6 nav-link-mtg"
                                            title="Full Sets">Full Sets</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-lg-3 col-6">
                                <select
                                    class="form-select form-select-lg border border-site-primary rounded-0 collection_attr"
                                    aria-label="Default select example">
                                    <option class="form-control" value="alphabets" selected="">Alphabetical</option>
                                    <option class="form-control" value="price">Price</option>
                                    <option class="form-control" value="collector_number">Collector Number</option>
                                    <option class="form-control" value="power">Power</option>
                                    <option class="form-control" value="toughness">Toughness</option>
                                    <option class="form-control" value="cmc">CMC</option>
                                    <option class="form-control" value="rarity_number">Rarity</option>
                                    <option class="form-control" value="color">Color</option>
                                    <option class="form-control" value="released_at">Release Date</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-6 mb-2">
                                <select
                                    class="form-select form-select-lg border border-site-primary rounded-0 collection_order"
                                    aria-label="Default select example">
                                    <option class="form-control" value="asc" selected="">Ascending</option>
                                    <option class="form-control" value="desc">Descending</option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="row mx-0 shadow_site my-2 py-3">
                            <div class="col-lg-3 col-md-6 col-sm-6  ">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" name="keyword" class="form-control form-control-lg border border-site-primary rounded-0 keyword">
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6   ">
                                <label for="exampleInputEmail1">Language</label>
                                <select name="language" class="form-select form-select-lg border border-site-primary rounded-0 fill_lang">
                                    <option value="">Select</option>
                                    @foreach(getLanguages() as $key => $lang)
                                    <option class="form-control" value="{{$key}}">{{$lang}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6   ">
                                <label for="exampleInputEmail1">Condition</label>
                                <select name="condition" class="form-select form-select-lg border border-site-primary rounded-0 fill_condition">
                                    <option value="">Select</option>
                                    @foreach(getConditions() as $key => $lang)
                                    <option class="form-control" value="{{$key}}">{{$lang}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6 ">

                                <label for="exampleInputEmail1">Price(max/min)</label>
                                <div class=" mau_div input-group input-group-lg border border-site-primary rounded-0">
                                    <button class="btn btn-outline-secondary dropdown-toggle border border-site-primary rounded-0 toggle_drop_men" type="button" data-bs-toggle="dropdown" data-toggle="Greater Than" aria-expanded="false">Equal To</button>
                                    <ul class="dropdown-menu dropdown-menuu">
                                      <li><button class="dropdown-item itemm" data-val=">" href="#">Greater Than</button></li>
                                      <li><button class="dropdown-item itemm" data-val="<" href="#">Less Than</button></li>
                                      <li><button class="dropdown-item itemm" data-val="=" href="#">Equal To</button></li>
                                    </ul>
                                    <input type="hidden" name="fill_pow" value="=" class="form-control fill_pow_order">
                                    <input type="text" class="form-control rounded-0 fill_pow" aria-label="Text input with dropdown button" placeholder="0.00">
                                  </div>
                               
                            </div>
                            
                            <div class="col-12">
                                <div class="row justify-content-md-end">
                                    <div class="col-lg-2 col-sm-3 col-12  mt-2">
                                        <button class="btn btn-site-primary w-100 filter_f" type="button">
                                            Search
                                        </button>
                                    </div>
                                    <div class="col-lg-2 col-sm-3 col-12  mt-2">
                                        <a class="btn btn-danger w-100 filter_f" href="{{url()->full()}}">
                                            Reset
                                        </a>
                                    </div>
                                </div>
                            </div>

                            
                        </div>
                        <div class="row shadow_site py-3 my-2 justify-content-center mx-0">
                            <div class="row d-flex justify-content-start p-0">
                                <h3 class="px-0 my-4 ms-3">Cards for Sale</h3>
                                <div class="append_tabl bg-white py-2 rounded-2">
                                    @include('front.user.components.collection-tab')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                        @if($user->block_by_auth  || check_auth_block($user->id))
                        <div class="row mx-0 shadow_site my-2 py-3 justify-content-center">
                            <p class="text-danger text-center">No Reviews to Show</p>
                        </div>
                        @else
                        <div class="row mx-0 shadow_site my-2 py-3 ">
                            <div class="card border-0">
                                <div class="card-header bg-white border-0 d-sm-flex justify-content-between px-md-2 px-0">
                                    <div class="d-flex justify-content-md-start justify-content-between">
                                        <h4 class="card-title mt-2 pt-1 fw-bolder">Reviews</h4>
                                        <div class="d-flex justify-content-center">
                                            <select name="sort_review" class="  my-3 ms-sm-3 sort_review sort_wid" aria-label="Default select example">
                                                <option selected disabled>Sort by</option>
                                                <option value="high">High to low</option>
                                                <option value="low">Low to high</option>
                                                <option value="recents">Recents</option>
                                            </select>
                                            <select name="type_review" class="  my-3 ms-md-3 type_review" aria-label="Default select example">
                                                <option value="buyer">As Buyer</option>
                                                <option value="seller">As Seller</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mt-1 text-center d-grid justify-content-md-center justify-content-end">
                                        <!-- <h3 class="fs-2">{{(int)$user->average_rating.'.0'}}</h3> -->
                                        @include('front.components.user.rating',['rating'=>$user->average_rating,'class'=>'','num_visible'=>'d-none'])
                                        <span class="small text-secondary">{{count($user->reviews)}} reviews</span>
                                    </div>
                                </div>
                                <div class="card-body py-0 render_review">
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


    </div>
</section>
@include('front.modals.report-user')
@endsection

@push('js')
<script>
    let url = '{{url()->full()}}';
    let url1 = '{{route('render.reviews')}}';
    let id = '{{$user->id}}';
    let sort = 'high';
    let type = 'buyer';
    let revPage = 1;
    let endpoint = '{{url()->full()}}';
    let attribute = '';
    let order = '';
    let page = 1;
    let limit = 10;
    let tab_type = 'best_price';
    let active = $('.status_active').val();
    let keyword = $('.keyword').val();
    let fill_collect = $('.fill_collect').val();
    let fill_tough = $('.fill_tough').val();
    let fill_cmc = $('.fill_cmc').val();
    let fill_rarity = $('.fill_rarity').val();
    let fill_color = $('.fill_color').val();
    let fill_lang = $('.fill_lang').val();
    let fill_pow_order = $('.fill_pow_order').val();
    let fill_pow = $('.fill_pow').val();
    let fill_char = $('.fill_char').val();
    let fill_condition = $('.fill_condition').val();
    let user_id = '{{$user->id}}';

    $(document).on('change', '.collection_attr', function () {
        
        senRequest()
    })
    $(document).on('change', '.collection_order', function () {
        senRequest()
    })
    $(document).on('click', '.btn_rating', function () {
        $('.review_btn').click();
    })
    $(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
        let url1 =  $(this).attr('href');
        var urlObject = new URL(url1);
        page = urlObject.searchParams.get('page');
        senRequest();
    })

    $(document).on('click', '.filter_f', function () {
        active = $('.status_active').val();
        keyword = $('.keyword').val();
        fill_collect = $('.fill_collect').val();
        fill_tough = $('.fill_tough').val();
        fill_cmc = $('.fill_cmc').val();
        fill_rarity = $('.fill_rarity').val();
        fill_color = $('.fill_color').val();
        fill_lang = $('.fill_lang').val();
        fill_pow_order = $('.fill_pow_order').val();
        fill_pow = $('.fill_pow').val();
        fill_condition = $('.fill_condition').val();
        fill_char = $('.fill_char').val();
        page=1;
        senRequest()
    })
    function senRequest() {
        url = url.split('?')[0];
        attribute = $('.collection_attr').val();
        order = $('.collection_order').val();
        $.ajax({
            type: "GET",
            data: {
                keyword: keyword,
                attribute: attribute,
                order: order,
                tab_type: tab_type,
                user_id: user_id,
                fill_collect :fill_collect,
                fill_tough :fill_tough,
                fill_cmc :fill_cmc,
                fill_rarity :fill_rarity,
                fill_color :fill_color,
                fill_lang :fill_lang,
                fill_pow_order :fill_pow_order,
                fill_pow :fill_pow,
                fill_condition :fill_condition,
                fill_char :fill_char,
                page :page,
                limit :limit,
            },
            url: url,
            success: function (response) {
                $('.append_tabl').empty()
                $('.append_tabl').html(response.html)
            },
        });
    }

    $(document).on('change', '.sort_review', function () {
        sort = $('.sort_review').val();
        renderReviews();
    })
    $(document).on('change', '.type_review', function () {
        type = $('.type_review').val();
        renderReviews();
    })
 

    $(document).ready(function(){
      renderReviews();
      $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
         url1 =  $(this).attr('href');
         renderReviews();
       })
    })

  function renderReviews()
  {
    $.ajax({
        type: "GET",
        data: {
            type: type,
            sort: sort,
            id:id,
        },
        url: url1,
        success: function (response) {
            $('.render_review').html(response.html)
        },
    });
  }

//   $(document).on('click', '.toggle_drop_men', function () {
//         // $(this).closest('div').find('.dropdown-menuu').toggleClass('show');
//     })
    $(document).on('click', '.itemm', function () {
        let tex = $(this).text();
        $(this).closest('.mau_div').find('.toggle_drop_men').text(tex);
        // $(this).closest('.mau_div').find('.dropdown-menuu').toggleClass('show');
        let sym = $(this).data('val');
        $('.fill_pow_order').val(sym);
    })
</script>

@endpush
