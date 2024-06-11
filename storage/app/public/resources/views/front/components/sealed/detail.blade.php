<div class="row px-md-4 px-2">
    <div class="col-lg-4 col-12 p-0 bg-white  text-center sealed_detail_img d-flex align-items-center justify-content-center">
        <img src="{{$item->png_image}}" class="img_site_80 py-3" style="filter: url({{"#".$item->rarity."_rarity"}})" alt="">
    </div>
    <div class="col-lg-8 bg-white d-lg-block d-none pt-5 border-start ">
        <div class="row px-1">
            <div class="col-lg-12 pe-0">
                <h2 class="fs-5">{{$item->seo->sub_heading ?? $item->name}}</h2>
            </div>
            
            <hr>
        
            <div class="col-12 sealed_oracle_div oracle_text">
                {!! $item->faces[0]->oracle_text ?? "" !!}
            </div>
        </div>
    </div>
</div>
<div class="col-12 d-flex justify-content-end bg-white d-flex d-lg-none mt-2">
    <a href="" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="my-auto"><img class="d-lg-none d-block me-2 " src="{{asset('images/single/32-info-solidBlue.svg')}}" alt=""></a>
    @if($auth)
        @if((auth()->user()->role != 'buyer' && auth()->user()->role != 'admin'))
        <button class="btn btn-site-primary w-auto h-50 my-3 mx-1 fs-small"  data-bs-toggle="modal" data-bs-target="#forSale" title="Sell one like this">
            Sell one like this
        </button>
        @endif
    @else
    <button class="btn btn-site-primary w-auto h-50 my-3 mx-1 fs-small" data-bs-toggle="modal" data-bs-target="#loginModal" title="Sell one like this">
        Sell one like this
    </button>
    @endif
</div>