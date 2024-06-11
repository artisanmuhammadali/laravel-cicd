<div class="product-section my-3">
    <div class="container ">
        <div class="tab-content" id="myTabContent">
            @if($tab_type == 'best_price')
            <div class=" active" >
                <div class="row ">
                    @foreach($list as $item)
                    @include('front.sw.components.singles.best-price' , ['item'=>$item])
                    @endforeach
                </div>
            </div>
            @elseif($tab_type == 'card_view')
            <div class=""  >
                <div class="row shadow_site  py-5">
                    @foreach($list as $item)
                    @include('front.sw.components.singles.card-view', ['item'=>$item])
                    @endforeach
                </div>
            </div>
            @else
            <div class="" >
                <div class="row shadow_site p-3">
                    @include('front.sw.components.singles.list-view', ['list'=>$list])
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center paginationDiv w-100 pb-4" id="pagination-container">
        <div class="col-md-9  px-md-5 overflow-auto">
            {{$list->links()}}
        </div>
        <div class="col-md-3 d-flex justify-content-end px-md-5">
            <label class="my-auto me-2">View Item per page</label>
            <select class="form-select form-select-sm rounded-0 border-site-primary dynamicPagination w-auto h-100 my-auto">
                <option class="form-control" value="9" {{$request->pagination == "9" ? "selected" : ""}}>9</option>
                <option class="form-control" value="50" {{$request->pagination == "50" ? "selected" : ""}}>50</option>
                <option class="form-control" value="100" {{$request->pagination == "100" ? "selected" : ""}}>100</option>
                <option class="form-control" value="500" {{$request->pagination == "500" ? "selected" : ""}}>500</option>
            </select>
        </div>
    </div>
</div>
