<div class="table-responsive">
    <table class="table">
        <thead class="table-head table-head_white">
            <tr>
                <th scope="col">Art</th>
                <th scope="col">#</th>
                <th class="text-nowrap" scope="col">Card Name</th>
                <th class="text-nowrap" scope="col">Expansion</th>
                <th scope="col" class="text-center">Rarity</th>
                <th class="text-nowrap" scope="col">Quantity (non-foil)</th>
                <th class="text-nowrap" scope="col">Price( Non Foil )</th>
                <th class="text-nowrap" scope="col">Quantity( Foil )</th>
                <th class="text-nowrap" scope="col">Price( Foil )</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($list as $item)
            <tr class="text-center">
                <td class="">
                    <img class="myDIV h4Btn me-1" src="{{$item->png_image}}" width="50px">
                    <div class="hide hand h4" style="left: 32rem; top: 0px !important;">
                        <img class="rounded-3 lozad" alt="very friendly shark" width="250" src="{{$item->png_image}}"  />
                    </div>
                </td>
                <td >{{$loop->iteration}}</td>
                <td><span class="text-site-primary">{{$item->name}}</span></td>
                <td>
                    <img loading="lazy" src="{{getStarWarIcon()}}" title="{{$item->set->name}}" class="img-fluid lozad" width="30"   alt="">
                </td>
                <td>
                    <div>
                        <img loading="lazy" src="{{$item->set->icon}}" title="{{$item->rarity}}" style="filter: url({{"#".$item->rarity."_rarity"}});" class="img-fluid lozad" width="30"   alt="">
                    </div>
                    <p class="text-capitalize mb-0 fs-6">{{$item->rarity}}</p>
                </td>
                <td>{{$item->non_foil_item->quantity ?? 0}}</td>
                <td>
                    <span class="bg-light-blue p-2 rounded-1">{{$item->non_foil_item->price ?? 0}}</span>
                </td>
                <td>{{$item->foil_item->quantity ?? 0}}</td>
                <td>
                    <span class="bg-light-blue p-2 rounded-1">{{$item->foil_item->price ?? 0}}</span>
                </td>
                <td>
                    <a href="{{route('sw.expansion.detail',[$item->set->slug, $item->url_type ,$item->slug])}}">
                        <i class="fa fa-arrow-right fs-2 " aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>