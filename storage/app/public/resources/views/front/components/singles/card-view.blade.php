<div class="col-lg-4 col-md-6 mb-3">
    <div class="card border-0 bg-transparent" >
        <a href="{{route('mtg.expansion.detail',[$item->url_slug, $item->url_type ,$item->slug])}}" class="text-decoration-none text-black">
            <div class="row px-5 mb-2">
                <div class="col-2 bg-light-blue justify-content-center d-flex align-items-center">
                    <img loading="lazy" src="{{$item->set->icon}}" style="filter: url({{"#".$item->rarity."_rarity"}});height: 23px;" class="img-fluid lozad" width="30"    alt="">
                </div>
                <div class="col-10 bg-dark-blue text-white">
                    <p class="m-auto card_name_fs">{{$item->set->name}}</p>
                </div>
            </div>
            <div class="card-body pt-0 d-flex justify-content-center">
                <img loading="lazy" src="{{$item->png_image}}" class="img_site_80 lozad" alt="">
            </div>
            <div class="card-footer d-flex bg-transparent border-0 justify-content-between ps-5">
                @if($item->collections)
                <span class="bg-light-blue py-1 px-4 rounded-1">from £ {{$item->price_starts_from}}</span>
                @else
                <p class="m-0">Not Available</p>
                @endif
            </div>
        </a>
    </div>
</div>