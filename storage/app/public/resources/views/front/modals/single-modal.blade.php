<div class="modal fade site-modal" id="staticBackdrop" role="dialog" aria-modal="true">
  <div class="modal-dialog mt-5 ">
    <div class="modal-content bg-gry">
      <div class="modal-header">
        <div class="row">
          <div class="circle_xsm register-btn-margin d-flex justify-content-center align-items-center text-center">
            <i class="fa fa-close close_icon" data-bs-dismiss="modal" aria-label="Close"></i>
          </div>
        </div>
      </div>
      @foreach($item->faces as $face)
      <div class="modal-body card mx-3 py-4 mb-3">
          <div class="col-12 d-flex align-items-center">
            @if($item->card_type == "single")
            <h5 class="text-black mb-0 me-2">{{$face->name ?? $item->name}}</h5>
            @else
            <h5 class="text-black mb-0 me-2">{{$item->name}}</h5>
            @endif
            @php($mana_cost=getCardManaCost($face->id))
            @foreach($mana_cost as $cost)
              <img  src="{{$cost}}" width="20" alt="">
            @endforeach
          </div>
        <div class="col-12">
            <p class="mt-3 small">{{$face->type_line}}</p>
            <img src="{{$item->set->icon}}" width="20" alt="" style="filter: url({{"#".$item->rarity."_rarity"}});">
        </div>
        <hr>
        @if($item->card_type == "single")
          <p class="fs-6">{{$face->oracle_text}}</p>
        @else
        <p class="fs-6 col-12 sealed_oracle_div oracle_text">{!! $face->oracle_text !!}</p>
        @endif
        @if($item->card_type == "single")
        <div class="col-12 d-flex align-items-center mt-4">
            <img src="{{asset('images/single/28-artist.svg')}}" alt="">
            <p class="mb-0 small">
                Artist : {{$face->artist}}
            </p>
            <p class="mb-0 ms-auto small">#{{$item->collector_number}}</p>
        </div>
          @if($loop->iteration ==1)
            <div class="col-12 mt-3 mb-1">
                <h4 class="mb-0 small text-muted mb-1">
                    Card Legalities
                </h4>
                @if($item->legalities && $item->legalities != '[]')
                    @foreach (json_decode($item->legalities) as $key=> $legality )
                    @if($legality == "legal")
                    <span class="badge border card-legality-text card-legality-border text-capitalize">{{$key}}</span>
                    @endif
                    @endforeach
                @else
                    <span class="badge border card-legality-text card-legality-border text-capitalize">Card is not Legal</span>
                @endif
            </div>
          @endif
        @endif
      </div>
      @endforeach
    </div>
  </div>
</div>