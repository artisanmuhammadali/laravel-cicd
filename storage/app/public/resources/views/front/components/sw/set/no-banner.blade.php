@if($detail)
<section>
    <div class="exp-banner-section">
        <div class="container py-md-5 py-2">
            <div class="row">
                <div class="col-md-2 text-center">
                    <img loading="lazy" src="{{$detail->icon ? 'https://img.veryfriendlysharks.co.uk/'.$detail->icon : getStarWarIcon()}}" class="img-invert exp-icon-width img-fluid" alt="exp-banner">
                    <p class="text-white text-uppercase ">{{$detail->set->code ?? $detail->code}}</p>
                </div>
                <div class="col-md-10 text-center text-white">
                    <h1 class="exp-h1 mb-4">{{$detail->heading ?? $detail->name}}</h1>
                    <h2 class="exp-h2">{{$detail->sub_heading ?? "Select Your Category To Buy & Sell Your SW Products"}}</h2>
                    <p class="exp-h2">Released at : {{customDate($detail->sw_published_at,'Y/m/d')}}</p>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    @include('front.components.breadcrumb')
</section>
@endif