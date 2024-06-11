<div class="modal fade site-modal" id="forSale" role="dialog"  aria-modal="true">
    <div class="modal-dialog modal-lg mt-4">
        <div class="modal-content " >
            <div class="modal-header">
                <h5 class="m-auto text-site-primary">Sell one like this</h5>
                <div class="circle_xsm register-btn-margin me-2">
                    <i class="fa fa-close close_icon" data-bs-dismiss="modal" aria-label="Close"></i>
                </div>
            </div>
            <div class="modal-body border-top">
                <form action="{{route('user.collection.save')}}" class="submit_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="form_type" value="modal">
                    <input type="hidden" name="mtg_card_id" value="{{$item->id}}">
                    <input type="hidden" name="mtg_card_type" value="{{$item->card_type}}">
                    <div class="row mb-2 mt-2">
                        <div class="col-sm-4 col-5 mb-2">
                            <label class="fw-bolder">Name:</label>
                        </div>
                        <div class="col-sm-8 col-7">
                            <p class="text-site-primary">{{$item->name}}</p>
                        </div>
                        <div class="col-sm-4 col-5 mb-2">
                            <label>Language <span class="text-danger">*</span>:</label>
                            <p class="sm-text text-secondary">
                                Select the language of the item
                            </p>
                        </div>
                        <div class="col-sm-8 col-7">
                            @if($item->card_type == "completed")
                                @if($item->card_languages)
                                <div class="row mb-3">
                                    @foreach($item->card_languages  as $key=> $lang)
                                    <div class="form-group col-4">
                                        <label for="{{$key}}" class="small">{{$lang}}</label>
                                        <input type="checkbox" name="languages[{{$key}}]" id="{{$key}}" {{$key == 'en' ? 'checked' : ''}}>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <label for="en">English</label>
                                <input type="checkbox" name="languages[en]" id="en" checked>
                                @endif
                            @else
                            <select name="language" class="form-select border border-site-primary rounded-1 required">
                                <option selected disabled>Select one</option>
                                @if($item->card_languages)
                                    @foreach($item->card_languages  as $key=> $lang)
                                    <option class="form-control" value="{{$key}}" {{$key == 'en' ? 'selected' : ''}}>{{$lang}}</option>
                                    @endforeach
                                @else
                                <option class="form-control" value="en" selected>English</option>
                                @endif
                            </select>
                            @endif
                        </div>
                        <div class="col-sm-4 col-5 mb-2">
                            <label>Conditions <span class="text-danger">*</span>:</label>
                            <p class="sm-text text-secondary">
                                Select product conditions
                            </p>
                        </div>
                        <div class="col-sm-8 col-7">
                            <select name="condition" class="form-select border border-site-primary rounded-1 required">
                                <option class="form-control" value="NM" selected>Near Mint</option>
                                <option class="form-control" value="LP">Light Play</option>
                                <option class="form-control" value="MP">Moderate Play</option>
                                <option class="form-control" value="HP">Heavy Play</option>
                                <option class="form-control" value="DMG">Damaged</option>
                            </select>
                        </div>
                        <div class="col-sm-4 col-5 mb-2">
                            <label>Card Characteristics:</label>
                            <p class="sm-text text-secondary">
                                Select one or more characteristics
                            </p>
                        </div>
                        <div class="col-sm-8 col-7">
                            <div class="row justify-content-around">
                                <div class="text-center pe-3 w-auto">
                                    {{-- <input type="checkbox" id="myCheckbox8" name="foil">
                                    @php($foil = $item->card_type == "single" ? $item->foil : $item->set->foil)
                                    @if($foil == 0)
                                    <label class="p-0 m-0">
                                        <img src="{{asset('images/characterstics/foil.png')}}" style="filter:grayscale(1);">
                                    @else
                                    <label for="myCheckbox8" class="p-0 m-0">
                                        <img src="{{asset('images/characterstics/foil.png')}}" >
                                    @endif --}}

                                    <input type="checkbox" id="myCheckbox8" name="foil" {{$item->card_foil->attr}}>
                                        <label for="{{$item->card_foil->attr == "checked" ?'' : 'myCheckbox8'}}" class="p-0 m-0">
                                            <img src="{{asset('images/characterstics/foil.png')}}" class="{{$item->card_foil->class}}">
                                        </label>
                                        <p class="sm-text fw-bolder">Foil</p>
                                    {{-- </label> --}}
                                    {{-- <p class="sm-text fw-bolder">Foil</p> --}}
                                </div>
                                <div class="text-center pe-3 w-auto">
                                    <input type="checkbox" id="myCheckbox11" name="signed">
                                    <label for="myCheckbox11" class="p-0 m-0">
                                        <img src="{{asset('images/characterstics/signed.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder">Signed</p>
                                </div>
                                <div class="text-center pe-3 w-auto">
                                    <input type="checkbox" id="myCheckbox12" name="graded">
                                    <label for="myCheckbox12" class="p-0 m-0">
                                        <img src="{{asset('images/characterstics/graded.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder">Graded</p>
                                </div>
                                <div class="text-center pe-3 w-auto">
                                    <input type="checkbox" id="myCheckbox13" name="altered">
                                    @if($item->card_type == "sealed")
                                    <label for="myCheckbox13" class="p-0 m-0">
                                        <img src="{{asset('images/characterstics/altered.png')}}" style="filter:grayscale(1);">
                                    </label>
                                    @else
                                    <label for="myCheckbox13" class="p-0 m-0">
                                        <img src="{{asset('images/characterstics/altered.png')}}">
                                    </label>
                                    @endif
                                    <p class="sm-text fw-bolder">Altered</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-5 mb-2">
                            <label>Price <span class="text-danger">*</span>:</label>
                            <p class="sm-text text-secondary">
                                Set the price of item
                            </p>
                        </div>
                        <div class="col-sm-8 col-7">
                            <input type="number" placeholder="£ 0.01" step="0.01" min="0.01"name="price" class="form-control border border-site-primary rounded-1 required">
                        </div>
                        <div class="col-sm-4 col-5 mb-2">
                            <label>Quantity <span class="text-danger">*</span>:</label>
                            <p class="sm-text text-secondary">
                                Enter how many copies do you want to sell
                            </p>
                        </div>
                        <div class="col-sm-8 col-7">
                            <input type="number" placeholder="1" min="1" value="1" name="quantity" class="form-control border border-site-primary rounded-1 required">

                        </div>
                        <div class="col-sm-4 col-5">
                            <label>Add a Photo:</label>
                        </div>
                        <div class="col-sm-8 col-7">
                            <input type="file" class="form-control" accept=".jpg, .jpeg, .png" name="photo">
                            <p class="md-text text-secondary">Formats: .JPG or .PDF. Maximum 2MB.</p>
                        </div>
                        <div class="col-sm-4 col-5">
                            <label for="note">Note:</label>
                        </div>
                        <div class="col-sm-8 col-7">
                            <textarea name="note" id="note" cols="25" rows="3" class="form-control border border-site-primary rounded-1"></textarea>
                        </div>

                        <button type="submit" class="btn btn-site-primary px-5 m-auto mt-3 w-auto">Add to Collection</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
