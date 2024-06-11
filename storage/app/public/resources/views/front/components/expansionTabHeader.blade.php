@php($routeBase = getRouteBase())
@php($detailSearch = $detailSearch ?? '')
<div class="row shadow_site py-3">
    @if($detailSearch != 'true')
    <div class="col-xl-4 col-lg-3 mb-2">
        <div class="input-group input-group-lg">
            <input class="form-control border border-site-primary rounded-0 keyword input-text" type="search"
                placeholder="Search" aria-label="Search" value="{{$request->keyword ?? ''}}">
        </div>
    </div>
    @else
    <input type="hidden" class="keyword" value="{{$request->keyword ?? ''}}">
    @endif
    @include('front.'.$routeBase.'.expansion.components.filter')
    <div class="col-xl-4 col-lg-5 ">
        <ul class="nav nav-tabs border-bottom-0 d-flex justify-content-between" id="myTab" role="tablist">
            <li class="nav-item "  role="presentation">
                <button class="nav-link text-black rounded-1 active tab_head_item px-sm-2 px-1" data-id="best_price" data-bs-toggle="tab"
                    data-bs-target="#best-tab-pane" type="button" role="tab"
                    aria-controls="best-tab-pane" aria-selected="true" title="Best Price View">Best Price</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-black rounded-1 tab_head_item px-sm-2 px-1" data-id="card_view" data-bs-toggle="tab"
                    data-bs-target="#card-tab-pane" type="button" role="tab"
                    aria-controls="card-tab-pane" aria-selected="false" title="Card View">Card View</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-black rounded-1 tab_head_item px-sm-2 px-1" data-id="list_view" data-bs-toggle="tab"
                    data-bs-target="#list-tab-pane" type="button" role="tab"
                    aria-controls="list-tab-pane" aria-selected="false" title="List View">List View</button>
            </li>
        </ul>
    </div>
    @if($detailSearch == 'true')
    <div class="col-lg-4">
        <p class="mt-2"> <span class="text-site-primary">{{$count}}</span> Results Found</p>
    </div>
    @endif
</div>
