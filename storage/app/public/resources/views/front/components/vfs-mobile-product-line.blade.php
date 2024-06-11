<div class=" text-center my-3">
    <div class="owl-carousel owl-carousel-product-line  owl-theme">
        <div class="landing-pg-crousel-div col-12">
            <a class="px-1 w-100" href="{{route('mtg.index')}}">
                <div class="prod_range_card">
                    <div class="card_image d-flex justify-content-center p-2">
                        <img loading="lazy" class="magic_img_h product_1_img_area" src="{{$setting['product_1_img'] ?? ""}}" alt=" magic_img">
                    </div>
                </div>
            </a>
        </div>
        <div class="landing-pg-crousel-div col-12">
            <a href="{{route('sw.index')}}" class="w-100">
                <div class="prod_range_card">
                    <div class="card_image card_image text-center justify-content-center p-2 d-flex">
                        <img loading="lazy" src="{{$setting['product_2_img'] ?? ""}}" alt="comming_soon" class="product_2_img_area">
                    </div>
                </div>
            </a>
        </div>
        <div class="landing-pg-crousel-div col-12">
            <a href="" class="diabaled w-100">
                <div class="prod_range_card">
                    <div class="card_image card_image text-center justify-content-center p-2 d-flex">
                        <p class="Coming-Soon m-0 py-4">Coming Soon</p>
                        <img loading="lazy" src="{{$setting['product_3_img'] ?? ""}}" alt="comming_soon" class="product_3_img_area">
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>