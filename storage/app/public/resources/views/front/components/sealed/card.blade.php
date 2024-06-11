<div class="col-lg-3 col-md-6">
    <div class="card border-0 bg-transparent card-set" >
        <a href="{{route('mtg.expansion.detail',[$item->url_slug, $item->url_type ,$item->slug])}}" class="text-decoration-none text-black">
            <div class="set_card_img d-flex justify-content-center">
                <img src="{{$item->png_image}}" class="img-fluid" alt="" width="100%">
            </div>
            <div class="card-footer bg-transparent border-0 text-center">
                <p class="fs-16">{{$item->name}}</p>
            </div>
        </a>
    </div>
</div>