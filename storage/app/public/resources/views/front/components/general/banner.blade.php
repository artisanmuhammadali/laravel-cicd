@php($button = $button ?? '')
<section>
    <div class="row m-0">
        <div class="col-12 px-0">
            <div class="bg-cards-img d-flex justify-content-center align-items-center mtg_banner_backgorund_area"
                style=" background-image:linear-gradient(rgba(33, 48, 86, 1), rgba(0, 0, 0, 0.5)), url({{$backgroundImage}});">
                <div class="text-center px-md-0 px-5">
                    <img loading="lazy" alt="Image" class="_mtg_banner_upper_area sw_banner_logo"
                        src="{{$frontImage}}" alt="" width="100%">

                    @if($button)
                    <a href="{{route('mtg.marketplace','single-cards')}}" class="btn btn-site-primary rounded-pill mt-md-3 product-listing-mobile-text">View All Available Products</a>
                    @endif
                </div>
            </div>
        </div>

    </div>
</section>