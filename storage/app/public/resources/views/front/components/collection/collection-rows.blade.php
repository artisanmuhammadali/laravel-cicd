  <tr class="product_cart_row" data-collection="{{$collection->id}}">
<td>
    @include('front.components.collection.user-detail')
</td>
  <td>
          <img class="myDIV h4Btn me-1" src="{{$collection->card->png_image}}" width="50px" height="60px">
          <div class="hide hand h4" style="left: 32rem; top: 0px !important;">
              <img class="rounded-3 lozad" alt="very friendly shark" width="250"
                  src="{{$collection->card->png_image}}" />
          </div>
          <a class="text-decoration-none product-listing-mobile-text"
              href="{{route('mtg.expansion.detail',[$collection->card->url_slug, $collection->card->url_type ,$collection->card->slug])}}">{{$collection->card->name}}</a>
      </td>
      <td class="d-md-table-cell d-none">
          <img loading="lazy" src="{{$collection->card->set->icon}}"
              style="filter: url({{"#".$collection->card->rarity."_rarity"}});" class="px-1 png tab_img_hover"
              width="50" alt="" height="30px">
      </td>
      <td class="d-md-table-cell d-none">
          @if($collection->mtg_card_type == "completed")
          <div class="d-flex">
              <div class="d-block">
                  @foreach(json_decode($collection->language) as $key =>$lang)
                  <span class="speechbubble p-1 z6 text-black text-uppercase">{{$key}}</span>
                  @endforeach
              </div>
          </div>
          @else
          <div class="d-block">
              @php($langTitle=languageFromCode($collection->language))
              <span class="speechbubble p-1 z6 text-black text-uppercase"
                  title="{{$langTitle}}">{{$collection->language}}</span>
          </div>
          @endif
      </td>
      <td>
            <div class="d-flex row">
                <div class="col-4">
                    <div class=" text-center rounded text-white my-1" style="background-color: {{$collection->condition_bg}}; width: fit-content;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$collection->condition_name}}">
                        <p class="text-uppercase small m-0 px-1 product-listing-mobile-text">{{$collection->condition}}</p>
                    </div>
                </div>
                @if(Route::is('mtg.marketplace'))
                <div class="col" style="display: inline-table;">
                    <img loading="lazy" width="20" src="{{$collection->char_signed}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Signed" alt="">
                    <img loading="lazy" width="20" src="{{$collection->char_altered}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Altered" alt="">
                    <img loading="lazy" width="20" src="{{$collection->char_graded}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Graded" alt="">
                    <img loading="lazy" width="20" src="{{$collection->char_foil}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Foil" alt="">
                </div>
                @endif
            </div>
      </td>
      @if(!Route::is('mtg.marketplace'))
      <td class="d-md-table-cell d-none">
          {{$collection->quantity}}
      </td>
      @endif
      <td>
          <p class="bg-light-blue rounded text-center m-0 product-listing-mobile-text">£{{$collection->price}}</p>
          <span class="d-md-none d-block text-secondary fs-bread">{{$collection->quantity}} avail</span>
      </td>
      <td>
            @if(!Route::is('mtg.marketplace'))    
                <a href="{{route('mtg.expansion.detail',[$collection->card->url_slug, $collection->card->url_type ,$collection->card->slug])}}">
                    <i class="fa fa-arrow-right fs-2 " aria-hidden="true"></i>
                </a>
            @else
                @include('front.components.cart.options',['item'=>$collection , 'class'=>''])
            @endif
      </td>
  </tr>
