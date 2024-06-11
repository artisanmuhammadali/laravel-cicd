<div class="row w-100 ">
    <div class="col-lg-5 col-12 d-md-flex align-items-center justify-content-center">
        <div class="col-md-5 text-center">
            <label class="fw-bold fs-5">Card characteristics:</label>
            <p class="sm-text text-body-secondary fst-italic">Select one or more characteristics
            </p>
        </div>
        <div class="col-md-7">
            <div class="row d-flex justify-content-center">
                <div class="text-center pe-3 w-auto">
                    <input type="checkbox" class="characteristics" id="{{$id1}}" value="foil"
                        name="characterstics[]" {{$item->card_foil->attr}}>
                    <label for="{{$item->card_foil->attr == "checked" ?'' : $id1}}" class="p-0 m-0">
                        <img src="{{asset('images/characterstics/foil.png')}}" class="{{$item->card_foil->class}}" loading="lazy" alt="Foil">
                    </label>
                    <p class="sm-text fw-bolder">Foil</p>
                </div>
                <div class="text-center pe-3 w-auto">
                    <input type="checkbox" class="characteristics" id="{{$id2}}" value="signed"
                        name="characterstics[]">
                    <label for="{{$id2}}" class="p-0 m-0">
                        <img src="{{asset('images/characterstics/signed.png')}}" loading="lazy" alt="Signed">
                    </label>
                    <p class="sm-text fw-bolder">Signed</p>
                </div>
                <div class="text-center pe-3 w-auto">
                    <input type="checkbox" class="characteristics" id="{{$id3}}" value="graded"
                        name="characterstics[]">
                    <label for="{{$id3}}" class="p-0 m-0">
                        <img src="{{asset('images/characterstics/graded.png')}}" loading="lazy" alt="Graded">
                    </label>
                    <p class="sm-text fw-bolder">Graded</p>
                </div>
                <div class="text-center pe-3 w-auto">
                    <input type="checkbox" class="characteristics" id="{{$id4}}" value="altered"
                        name="characterstics[]">
                    <label for="{{$id4}}" class="p-0 m-0">
                        <img src="{{asset('images/characterstics/altered.png')}}" loading="lazy" alt="Altered">
                    </label>
                    <p class="sm-text fw-bolder">Altered</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-3  col-sm-6 mt-md-0 mt-1">
        <select name="condition" id="condition"
            class="form-select-lg rounded border-site-primary item_condition fill_condition pe-lg-5 rounded-1 fs-6 w-100">
            <option class="form-control" value="" selected="">Condition</option>
            <option class="form-control" value="NM">Near Mint</option>
            <option class="form-control" value="LP">Light Play</option>
            <option class="form-control" value="MP">Moderate Play</option>
            <option class="form-control" value="HP">Heavy Play</option>
            <option class="form-control" value="DMG">Damaged</option>
        </select>
    </div>
    <div class="col-lg-2 col-md-3 col-sm-6 mt-md-0 mt-1">
        <select name="language" id="language"
            class="form-select-lg rounded border-site-primary pe-lg-5 fill_lang item_language rounded-1 fs-6 w-100">
            <option class="form-control " value="" selected="">Language</option>
            @if($item->card_languages)
                @foreach($item->card_languages  as $key=> $lang)
                <option class="form-control " value="{{$key}}">{{$lang}}</option>
                @endforeach
            @else
            <option class="form-control" value="en">English</option>
            @endif
        </select>
    </div>
    <div class="col-lg-2 col-md-3 col-sm-6 mt-md-0 mt-1">
        <select class="form-select-lg border-site-primary rounded-1 fs-6 w-100 expansion_order">
            <option class="form-control" value="asc">Price - Ascending</option>
            <option class="form-control" value="desc">Price - Descending</option>
        </select>
    </div>
    <div class="col-lg-1 col-md-3 col-sm-6 mt-md-0 mt-1 mb-sm-0 mb-1">
        <button class="btn btn-site-primary w-100 filter" title="Filter" data-bs-dismiss="modal" aria-label="Close">Filter</button>
    </div>
</div>