<div class="product-section my-3">
    <div class="tab-content" id="myTabContent">
        @if($tab_type == 'card_view')
        <div class=""  >
            <div class="row">
                @foreach($collections as $collection)
                @include('front.mtg.marketplace.components.card', ['collection'=>$collection])
                @endforeach
            </div>
        </div>
        @else
        <div class="" >
            @include('front.mtg.marketplace.components.table', ['collections'=>$collections])
        </div>
        @endif
    </div>
</div>
<div class="row justify-content-center paginationDiv w-100 pb-4" id="pagination-container">
    <div class="col-md-8  px-md-5 overflow-auto">
        <div class="d-md-block d-none">{{$collections->links()}}</div>
        @include('front.components.pagination',['items'=>$collections])
    </div>
    <div class="col-md-4 d-flex justify-content-end px-md-5">
        <label class="my-auto me-2">View Item per page</label>
        <select class="form-select form-select-sm rounded-0 border-site-primary dynamicPagination w-auto h-100 my-auto">
            <option class="form-control" value="50" {{$request->pagination == "50" ? "selected" : ""}}>50</option>
            <option class="form-control" value="100" {{$request->pagination == "100" ? "selected" : ""}}>100</option>
            <option class="form-control" value="500" {{$request->pagination == "500" ? "selected" : ""}}>500</option>
        </select>
    </div>
</div>
