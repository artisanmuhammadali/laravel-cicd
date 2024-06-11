<section>
        
    <div class="exp-banner-section">
        <img loading="lazy" src="{{'https://img.veryfriendlysharks.co.uk/'.$banner}}" class="img-fluid w-100 exp-banner-img" alt="Exp-banner">
    </div>
</section>
<section>
    @include('front.components.breadcrumb')
</section>
<section>
    <div class="expansion-detail-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center mt-3">
                    <h1 class="exp-h1 mb-4">{{$detail->heading ?? $detail->name ? $detail->name : ""}}</h1>
                    <h2 class="exp-h2">{{$detail->sub_heading ?? "Select Your Category To Buy & Sell Your SW Products"}}</h2>
                    <p class="exp-h2">Released at : {{customDate($detail->sw_published_at,'Y/m/d')}}</p>
                </div>
            </div>
        </div>
    </div>
</section>