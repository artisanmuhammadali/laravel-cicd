<div class="col-md-4 col-10 mb-md-0 mb-2 me-md-2 me-0 {{$class}}">
    <a href="{{route('mtg.index')}}">
        <div class="prod_range_card">
            <div class="card_image d-flex justify-content-center">
                <img loading="lazy" class="magic_img_h product_1_img_area" src="{{$setting['product_1_img'] ?? ""}}" alt=" magic_img">
            </div>
        </div>
    </a>
</div>
<div class="col-md-4 col-10 mb-md-0 mb-2 me-md-2 me-0 {{$class}}">
    <a href="{{route('sw.index')}}">
       <div class="prod_range_card">
        <div class="card_image card_image text-center justify-content-center d-flex">
            {{-- <p class="Coming-Soon m-0 py-4">Coming Soon</p> --}}
            <img loading="lazy" src="{{$setting['product_2_img'] ?? ""}}" alt="comming_soon" class="product_2_img_area">
        </div>
    </div>
    </a>
</div>
{{-- <div class="col-md-4 col-10 mb-md-0 mb-2  me-md-2 me-0">
    <div class="prod_range_card">
        <div class="card_image card_image text-center justify-content-center d-flex">
            <p class="Coming-Soon m-0 py-4">Coming Soon</p>
            <img loading="lazy" src="{{$setting['product_2_img'] ?? ""}}" alt="comming_soon" class="product_2_img_area">
        </div>
    </div>
</div> --}}
<div class="col-md-4 col-10 mb-md-0 mb-2  me-md-2 me-0">
    <div class="prod_range_card">
        <div class="card_image card_image text-center justify-content-center d-flex">
            <p class="Coming-Soon m-0 py-4">Coming Soon</p>
            <img loading="lazy" src="{{$setting['product_3_img'] ?? ""}}" alt="comming_soon" class="product_3_img_area">
        </div>
    </div>
</div>