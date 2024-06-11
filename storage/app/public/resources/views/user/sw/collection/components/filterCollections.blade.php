@php($isBulk = $isBulk ?? null)

<div class=" filter-card hide_box mt-2">
<div><span class="close_btn d-block d-md-none d-lg-none d-xl-none" data-target=".filter-card"><i class="fa fa-times"></i></span></div>
<div class="row filterBox  py-2  bg-gry px-sm-2 px-0" style="background-color: #f3f2f7;">

    <div class="col-md-6 mb-2">
        <select class="form-select select2 selectExp en_submit">
            <option selected disabled> Search Expansion</option>
            @foreach ($sets as $set)
            <option class="form-control" value="{{$set->code}}">{{$set->name}}</option>
            @endforeach
        </select>
    </div>
    @if(request()->type == "single")
    <div class="col-md-6 mb-2">
        <select class="form-select selectRarity en_submit">
            <option class="form-control" value="all">All Cards</option>
            @foreach(wsRarity() as $r)
            <option class="form-control" value="{{$r}}">{{$r}}</option>
            @endforeach
        </select>
    </div>
    @endif
    <div class="col-md-12">
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6  ">
        <label for="exampleInputEmail1">Name</label>
        <input type="text" name="keyword" class="form-control keyword">
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6   ">
        <label for="exampleInputEmail1">Language</label>
        <select name="language" class="form-select fill_language  px-50 fs-sm-drop">
            <option value="">Select</option>
            @foreach(getLanguages() as $key => $lang)
            <option value="{{$key}}">{{$lang}}</option>
            @endforeach
        </select>
    </div>
    @if(!$isBulk)
    <div class="col-lg-3 col-md-4 col-sm-6   ">
        <label for="exampleInputEmail1">Condition</label>
        <select name="condition" class="form-select fill_condition  px-50 fs-sm-drop">
            <option value="">Select</option>
            @foreach(getConditions() as $key => $lang)
            <option value="{{$key}}">{{$lang}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 ">
        <label for="exampleInputEmail1">Price(max/min)</label>
        <div class="input-group">
            <div class="mau_div input-group-prepend">
                <button class="btn btn-outline-secondary dropdown-toggle toggle_drop_men" type="button"
                    data-toggle="Greater Than" aria-haspopup="true" aria-expanded="false">Equal To</button>
                <div class="dropdown-menuu">
                    <a class="dropdown-item itemm" data-val=">" href="#">Greater Than</a>
                    <a class="dropdown-item itemm" data-val="<" href="#">Less Than</a>
                    <a class="dropdown-item itemm" data-val="=" href="#">Equal To</a>
                </div>
            </div>
            <input type="hidden" name="fill_pow" value="=" class="form-control fill_pow_order">
            <input type="text" name="fill_pow" class="form-control fill_pow" placeholder="0.00">
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6   ">
        <label for="exampleInputEmail1">Status</label>
        <select class="form-select status_active fs-sm-drop">
            <option value="">Both</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
    </div>
    @endif

    @if(!$isBulk)
    <div class="col-lg-6 col-md-6 col-sm-6   ">
        <label for="exampleInputEmail1">Characteristics</label>
        <select class="form-select fill_char fs-sm-drop select2" multiple>
            <option value="" disabled>Any</option>
            @foreach(getCharacteristics() as $key => $lang)
            <option value="{{$key}}">{{$lang}}</option>
            @endforeach
        </select>
    </div>
    @endif
    <div class="col-lg-2 col-sm-3 col-12  mt-2">
        @if($isBulk)
        <button class="btn btn-primary mx-md-3 render_vieww" data-url="{{route('user.collection.sw.renderViews')}}"
            data-type="bulkList" data-card="{{request()->type}}"> Search</button>
        @else
        <button class="btn btn-primary w-100 filter_collections" type="button">
            Search
        </button>
        @endif
    </div>
    <div class="col-lg-2 col-sm-3 col-12  mt-2">
        <a class="btn btn-danger w-100 " href="{{url()->full()}}">
            Reset
        </a>
    </div>

    <div class="col-md-6 mt-2 ">
        <select class="form-select collection_attributes tab_head_item px-50 fs-sm-drop">
            <option value="">Select</option>
            <option value="alphabets">Alphabetical</option>
            @if(!$isBulk)
            <option value="price">Price</option>
            @endif
            @if($type == "single")
            <option value="power">Power</option>
            <option value="cost">Cost</option>
            <option value="hp">HP</option>
            <option value="released_at">Release Date</option>
            @endif
        </select>
    </div>
    <div class="col-md-6 mt-2">
        <select class="form-select collection_order tab_head_item px-50 fs-sm-drop">
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
        </select>
    </div>
</div>
</div>
