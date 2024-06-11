<div class="table-responsive">
    <table class="table">
        <thead class="table-head table-head_white">
            <tr>
                <th scope="col">
                    <span class="d-md-block d-none">Art</span>
                    <span class="d-md-none d-block">Card</span>
                </th>
                <th scope="col" class="d-md-table-cell d-none">#</th>
                <th class="text-nowrap d-md-table-cell d-none" scope="col">
                    <span class="d-md-block d-none">Card Name</span>
                </th>
                <th class="text-nowrap d-md-table-cell d-none" scope="col">Expansion</th>
                <th scope="col" class="text-center">
                    <span class="d-md-block d-none">Ratity</span>
                    <span class="d-block d-md-none">Exp</span>
                </th>
                <th class="text-nowrap d-md-table-cell d-none" scope="col">Quantity (Non foil)</th>
                <th class="text-nowrap" scope="col">
                    <span class="d-md-block d-none">Price( Non Foil )</span>
                    <span class="d-block d-md-none">Non Foil</span>
                </th>
                <th class="text-nowrap d-md-table-cell d-none" scope="col">Quantity( Foil )</th>
                <th class="text-nowrap" scope="col">
                    <span class="d-md-block d-none">Price( Foil )</span>
                    <span class="d-block d-md-none">Foil</span>
                </th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($list as $item)
            <tr class="text-center">
                <td class="">
                    <div class="d-md-table-cell d-flex">
                        <img class="myDIV h4Btn me-1 set_icon d-md-block d-none" src="{{$item->png_image}}" width="50px">
                        <i class="fa fa-camera myDIV h4Btn d-md-none d-block pe-1"></i>
                        <div class="hide hand h4" style="left: 32rem; top: 0px !important;">
                            <img class="rounded-3 lozad" alt="very friendly shark" width="250" src="{{$item->png_image}}"  />
                        </div>
                        <span class="text-site-primary product-listing-mobile-text d-md-none d-block">{{$item->name}}</span>
                    </div>
                </td>
                <td class="d-md-table-cell d-none" >{{$loop->iteration}}</td>
                <td class="d-md-table-cell d-none"><span class="text-site-primary product-listing-mobile-text">{{$item->name}}</span></td>
                <td class="d-md-table-cell d-none">
                    <img loading="lazy" src="{{$item->set->icon}}" title="{{$item->set->name}}" class="img-fluid lozad" width="30"   alt="">
                </td>
                <td>
                    <div>
                        <img loading="lazy" src="{{$item->set->icon}}" title="{{$item->rarity}}" style="filter: url({{"#".$item->rarity."_rarity"}});" class="img-fluid lozad" width="30"   alt="">
                    </div>
                    <p class="text-capitalize mb-0 fs-6 d-md-block d-none">{{$item->rarity}}</p>
                </td>
                <td class="d-md-table-cell d-none">{{$item->non_foil_item->quantity ?? 0}}</td>
                <td>
                    <span class="bg-light-blue p-2 rounded-1 product-listing-mobile-text d-flex"><span class="d-md-none d-block">£</span>{{$item->non_foil_item->price ?? 0}}</span>
                    <span class="d-md-none d-block text-secondary fs-bread mt-2">{{$item->non_foil_item->quantity ?? 0}} avail</span>
                </td>
                <td class="d-md-table-cell d-none">{{$item->foil_item->quantity ?? 0}}</td>
                <td>
                    <span class="bg-light-blue p-2 rounded-1 product-listing-mobile-text d-flex"><span class="d-md-none d-block">£</span>{{$item->foil_item->price ?? 0}}</span>
                    <span class="d-md-none d-block text-secondary fs-bread mt-2">{{$item->foil_item->quantity ?? 0}} avail</span>
                </td>
                <td>
                    <a href="{{route('mtg.expansion.detail',[$item->url_slug, $item->url_type ,$item->slug])}}">
                        <i class="fa fa-arrow-right fs-2 " aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>