
<div class="modal-content " >
    <div class="modal-header">
        <h5 class="m-auto text-site-primary">Sell one like this</h5>   
        <div class="circle_xsm register-btn-margin ">
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
                <div class="col-4 mb-2">
                    <label class="fw-bolder">Name:</label>
                </div>
                <div class="col-8">
                    <p class="text-site-primary fw-bold">{{$item->name}}</p>
                </div>
                <div class="col-4 mb-2">
                    <label class="fw-bolder">Language<span class="text-danger">*</span>:</label>
                    <p class="sm-text text-secondary">
                        Select the language of the item
                    </p>
                </div>
                <div class="col-8">
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
                <div class="col-4 mb-2">
                    <label class="fw-bolder">Conditions <span class="text-danger">*</span>:</label>
                    <p class="sm-text text-secondary">
                        Select product conditions
                    </p>
                </div>
                <div class="col-8">
                    <select name="condition" class="form-select border border-site-primary rounded-1 required">
                        <option class="form-control" value="NM" selected>Near Mint</option>
                        <option class="form-control" value="LP">Light Play</option>
                        <option class="form-control" value="MP">Moderate Play</option>
                        <option class="form-control" value="HP">Heavy Play</option>
                        <option class="form-control" value="DMG">Damaged</option>
                    </select>
                </div>
                <div class="col-4 mb-2">
                    <label class="fw-bolder">Card Characteristics:</label>
                    <p class="sm-text text-secondary">
                        Select one or more characteristics
                    </p>
                </div>
                <div class="col-8">
                    <div class="row justify-content-around">
                        <div class="demo-inline-spacing">
                            <div class="form-check form-check-info">
                                @php($foil = $item->card_type == "single" ? $item->foil : $item->set->foil)
                                @if($foil == 0)
                                <input type="checkbox" disabled class="form-check-input" >
                                <label class="form-check-label">Foil</label>
                                @else
                                <input type="checkbox" class="form-check-input" name="foil" id="colorCheck1" {{$item->card_foil->attr == 'checked' ? 'checked disabled' : ''}}>
                                <input type="checkbox" class="form-check-input" name="foil" id="colorCheck1" >
                                <label class="form-check-label" for="colorCheck1">Foil</label>
                                @endif
                            </div>
                            <div class="form-check form-check-secondary">
                                <input type="checkbox" class="form-check-input" name="altered" id="colorCheck2"  {{$item->altered ? "checked" : ""}}>
                                <label class="form-check-label" for="colorCheck2">Altered</label>
                            </div>
                            <div class="form-check form-check-success">
                                <input type="checkbox" class="form-check-input" name="graded" id="colorCheck3"  {{$item->graded ? "checked" : ""}}>
                                <label class="form-check-label" for="colorCheck3">Graded</label>
                            </div>
                            <div class="form-check form-check-warning">
                                <input type="checkbox" class="form-check-input" name="signed" id="colorCheck6"  {{$item->signed ? "checked" : ""}}>
                                <label class="form-check-label" for="colorCheck6">Signed</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4 mb-2">
                    <label class="fw-bolder">Price <span class="text-danger">*</span>:</label>
                    <p class="sm-text text-secondary">
                        Set the price of item
                    </p>
                </div>
                <div class="col-8">
                    <input type="number" placeholder="£ 0.01" step="0.01" min="0.01"name="price" class="form-control border border-site-primary rounded-1 required">
                </div>
                <div class="col-4 mb-2">
                    <label class="fw-bolder">Quantity <span class="text-danger">*</span>:</label>
                    <p class="sm-text text-secondary">
                        Enter how many copies do you want to sell
                    </p>
                </div>
                <div class="col-8">
                    <input type="number" placeholder="1" min="1" name="quantity" value="1" class="form-control border border-site-primary rounded-1 required">

                </div>
                <div class="col-4">
                    <label class="fw-bolder">Add a Photo:</label>
                </div>
                <div class="col-8">
                    <input type="file" class="form-control" name="photo" accept=".jpg, .jpeg, .png" >
                    <p class="md-text text-secondary">Formats: .JPG or .PDF. Maximum 2MB.</p>
                </div>
                <div class="col-4">
                    <label class="fw-bolder" for="note">Note:</label>
                </div>
                <div class="col-8 mb-2">
                    <textarea name="note" id="note" cols="25" rows="3" class="form-control border border-site-primary rounded-1"></textarea>
                </div>
                <button type="submit" class="btn btn-primary px-5 m-auto w-auto submit_btn">Add to Collection</button>
            </div>
            
        </form>
    </div>
</div>