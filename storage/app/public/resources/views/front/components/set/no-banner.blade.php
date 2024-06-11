@if($detail)
<section>
    <div class="exp-banner-section">
        <div class="container py-md-5 py-2">
            <div class="row">
                <div class="col-md-2 text-center">
                    <img loading="lazy" src="{{asset($detail->set->icon ?? $detail->icon)}}" class="img-invert exp-icon-width img-fluid" alt="exp-banner">
                    <p class="text-white text-uppercase ">{{$detail->set->code ?? $detail->code}}</p>
                </div>
                <div class="col-md-10 text-center text-white">
                    <h1 class="exp-h1 mb-4">{{$detail->heading ?? ""}}</h1>
                    <h2 class="exp-h2">{{$detail->sub_heading ?? ""}}</h2>
                    <p class="exp-h2">Released at : {{$detail->set->released_at  ?? $detail->released_at}}</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    @include('front.components.breadcrumb')
</section>
@endif