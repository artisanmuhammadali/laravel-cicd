<div class="row w-100  mb-3 showOptions">
    <div class="col-md-3 col-6">
        <label for="language">Language</label>
        <select class="form-select BulkSelect">
            <option selected disabled id="language">Select</option>
            @if($set->set_languages)
                @foreach($set->set_languages as $key => $lang)
                <option class="form-control" value="{{$key}}">{{$lang}}</option>
                @endforeach
            @else
            <option class="form-control" value="en">English</option>
            @endif
        </select>
    </div>
    
    <div class="col-md-2 col-sm-4 col-6">
        <label for="quantity">Quantity</label>
        <input class="form-control BulkInputs" data-name="quantity" placeholder="1" min="1" type="number" id="quantity" placeholder="1">
    </div>
    <div class="col-md-2 col-sm-4 col-6">
        <label for="price">Price</label>
        <input class="form-control BulkInputs" data-name="price" step="0.01" min="0.01" type="number" id="price" placeholder="1">
    </div>
    <div class="col-md-2 col-sm-4 col-6">
        <label for="price">Condition</label>
        <select class="form-select BulkCondition">
            <option class="form-control" value="NM">NM</option>
            <option class="form-control" value="LP">LP</option>
            <option class="form-control" value="MP">MP</option>
            <option class="form-control" value="HP">HP</option>
            <option class="form-control" value="D">Dmg</option>
        </select>
    </div>
    <div class="col-md-3 col-12">
        <label for="note">Note</label>
        <input class="form-control BulkInputs" data-name="note" type="text" id="note">
    </div>
    <div class="ps-3 col-sm-3 col-6 form-check my-auto form-check-info mt-2">
        <input type="checkbox" class="form-check-input BulkChar" data-char="foil" data-name="foil" id="foilCheck" >
        <label class="form-check-label" for="foilCheck">Foil</label>
    </div>
    <div class="ps-3 col-sm-3 col-6 form-check my-auto form-check-secondary mt-2 ">
        <input type="checkbox" class="form-check-input BulkChar" data-char="altered" data-name="altered" id="alteredCheck">
        <label class="form-check-label" for="alteredCheck">Altered</label>
    </div>
    <div class="ps-3 col-sm-3 col-6 form-check my-auto form-check-success mt-2">
        <input type="checkbox" class="form-check-input BulkChar" data-char="graded" data-name="graded" id="gradedCheck">
        <label class="form-check-label" for="gradedCheck">Graded</label>
    </div>
    <div class="ps-3 col-sm-3 col-6 form-check my-auto form-check-warning mt-2">
        <input type="checkbox" class="form-check-input BulkChar" data-char="signed" data-name="signed" id="signedCheck">
        <label class="form-check-label" for="signedCheck">Signed</label>
    </div>
</div>
<div class="row justify-content-between">
    <div class="col-12  px-2 py-1 d-flex justify-content-between align-items-center">
        <p class="fw-6 mb-0"><span class="fw-bold text-black cardCount">{{$count}}</span> Results Found</p>
        @if(count($list) > 0)
            <button  class="btn btn-primary publishBtn form_submit_btn d-none" type="submit" >Add to collection</button>
        @endif
    </div>
</div>
@if(count($list) < 1)
    <div class="row text-center">
        <div class="text-danger text-center">No Record Found</div>
    </div>
@else
<p class="fw-6 mb-0 text-warning fw-bold"><span><i class="fa-solid fa-circle-info fs-6 me-25"></i></span>Please use the red "-" symbol to remove any card you do not own
</p>
<div class="table-responsive" style="height: 600px">
    <table class="table table-hover">
        <thead class="tabl-header">
            <tr>
                <th>Actions</th>
                <th>Card</th>
                <th>Attributes</th>
                <th>Set</th>
                <th>Condition</th>
                <th>Language</th>
                <th>Characteristics</th>
                <th>Qty</th>
                <th class="text-truncate">Price</th>
                <th class="text-truncate">Card Note</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach($list as $item)
            <tr class="itemRow{{$item->id}}">
                <td class="py-0 px-25">
                    <input type="hidden" name="mtg_card_id[{{$loop->iteration - 1}}]" value="{{$item->id}}">
                    <div class="d-flex justify-content-around">
                        <button type="button" class="btn btn-icon btn-outline-danger waves-effect  removeBulkItem w-25 py-25 h-50 px-0"  data-id="{{$item->id}}" title="Remove item">
                            <i class="fa fa-minus" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-outline-primary waves-effect me-1 cloneBulkItem  w-25 py-25 h-50 px-0" data-id="{{$item->id}}" title="Copy item">
                            <i class="fa fa-clone" aria-hidden="true"></i>
                        </button>
                    </div>

                </td>
                <td class="py-0 px-25">
                    <div class="d-flex align-items-center">
                        <i class="fa fa-image myDIV h4Btn me-1"></i>
                        {{--<img loading="lazy" alt="{{$item->name}}" class="myDIV h4Btn me-1" src="{{$item->png_image}}" width="25px">--}}
                        <div class="hide hand h4" style="left: 32rem; top: 0px !important;">
                            <img class="rounded-3" alt="very friendly shark" width="250" src="{{$item->png_image}}" loading="lazy" alt="{{$item->name}}" />
                        </div>
                        
                        <span class="fw-bold text-truncate small">{{$item->name}}</span>
                        <div>
                            @php($attributess = $item->card->attributes ?? null)
                            @if($attributess)
                                <br>
                                @foreach($item->card->attributes as $att)
                                    <span class="badge bg-primary fs-12p-sm">{{$att->name}}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </td>
                <td>
                    @if($item->attributes)
                @foreach($item->attributes as $att)
                    <span class="badge bg-primary position-relative fs-12p-sm">{{$att->name}}</span>
                @endforeach
                @else
                <span>'-'</span>
                 @endif
                </td>

                <td class="py-0 px-25">
                    <div title="{{$item->set->name.'-'.ucfirst($item->rarity)}}" class="text-center">
                        <img loading="lazy" alt="{{$item->set->name.'-'.ucfirst($item->rarity)}}" src="{{$item->set->icon}}" style="filter: url({{"#".$item->rarity."_rarity"}});" width="25" alt="{{$item->set->name}}" >
                    </div>
                </td>
                <td class="py-0 px-25">
                    <select class="form-select required InputCondition bulk-options bulk-options-font" name="condition[{{$loop->iteration - 1}}]" >
                        <option class="form-control bulk-options-font" value="NM">Near Mint</option>
                        <option class="form-control bulk-options-font" value="LP">Light Played</option>
                        <option class="form-control bulk-options-font" value="MP">Moderate Play</option>
                        <option class="form-control bulk-options-font" value="HP">Heavy Play</option>
                        <option class="form-control bulk-options-font" value="DMG">Damaged</option>
                    </select>
                </td>
                <td class="py-0 px-25">
                    <select class="form-select InputLanguage required bulk-options bulk-options-font" name="language[{{$loop->iteration - 1}}]" >
                        <option selected disabled>Language</option>
                        @if($item->card_languages)
                            @foreach($item->card_languages  as $key=> $lang)
                            <option class="form-control bulk-options-font" value="{{$key}}">{{$lang}}</option>
                            @endforeach
                        @else
                        <option class="form-control bulk-options-font" value="en">English</option>
                        @endif
                    </select>
                </td>
                <td class="py-0 px-25">
                    <div class="form-check my-auto form-check-info">
                        <input type="checkbox" value="0" class="form-check-input  {{$item->foil == 0 && $item->card_type == "single" ? "" : "Inputfoil"}} " {{$item->foil == 0 && $item->card_type == "single"  ? "disabled" : ""}} name="foil[{{$loop->iteration - 1}}]" id="foilCheck{{$loop->iteration+1}}" >
                        <label class="form-check-label bulk-options-font" for="foilCheck{{$loop->iteration+1}}">Foil</label>
                    </div>
                    <div class="form-check my-auto form-check-secondary">
                        <input type="checkbox" value="0" class="form-check-input Inputaltered" name="altered[{{$loop->iteration - 1}}]" id="alteredCheck{{$loop->iteration+1}}">
                        <label class="form-check-label bulk-options-font" for="alteredCheck{{$loop->iteration+1}}">Altered</label>
                    </div>
                    <div class="form-check my-auto form-check-success">
                        <input type="checkbox" value="0" class="form-check-input Inputgraded" name="graded[{{$loop->iteration - 1}}]" id="gradedCheck{{$loop->iteration+1}}">
                        <label class="form-check-label bulk-options-font" for="gradedCheck{{$loop->iteration+1}}">Graded</label>
                    </div>
                    <div class="form-check my-auto form-check-warning">
                        <input type="checkbox" value="0" class="form-check-input Inputsigned" name="signed[{{$loop->iteration - 1}}]" id="signedCheck{{$loop->iteration+1}}">
                        <label class="form-check-label bulk-options-font" for="signedCheck{{$loop->iteration+1}}">Signed</label>
                    </div>
                </td>
                <td class="py-0 px-25">
                    <input type="number" class="form-control Inputquantity required m-auto bulk-options-font" min="1" name="quantity[{{$loop->iteration - 1}}]" placeholder="1">
                </td>
                <td class="py-0 px-25">
                    <input type="number" class="form-control Inputprice required m-auto bulk-options-font" step="0.01" min="0.01" name="price[{{$loop->iteration - 1}}]" placeholder="1">
                </td>
                <td class="py-0 px-25">
                <input type="text" class="form-control Inputnote w-75 m-auto bulk-options-font" name="note[{{$loop->iteration - 1}}]">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

