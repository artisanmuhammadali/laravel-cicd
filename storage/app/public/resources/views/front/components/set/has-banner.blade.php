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
                    <h1 class="exp-h1 mb-4">{{$detail->heading ?? $detail->name}}</h1>
                    <h2 class="exp-h2">{{$detail->sub_heading ?? ""}}</h2>
                    <p class="exp-h2">Released at : {{$detail->released_at ?? $detail->set->released_at}}</p>
                </div>
            </div>
        </div>
    </div>
</section>