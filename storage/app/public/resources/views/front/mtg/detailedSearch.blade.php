@extends('layouts.app')
@section('title','Detailed Search')
@section('description', "Find and Trade MTG Singles, Sealed Products, and Complete Sets. Explore the UK's Exclusive Card Market Now!")
@push('css')
<link href="{{asset('front/styles/tagify.css')}}" rel="stylesheet">
@endpush
@section('content')

<div class="container-fluid px-0">
    <section>
        @include('front.components.breadcrumb')
    </section>
    <section>
        <div class="container px-md-0">
            <div class="row mx-md-0 m-2">
                <div class="col-md-12 py-5">
                    <h1 class="text-site-primary text-center fw-bolder">Detailed Search</h1>
                </div>
                <form class="shadow_site p-md-5 p-3" method="GET" action="{{route('mtg.detailed.search')}}">
                    <div class="row py-3">
                        <div class="col-md-4">
                            <label for="name" class="fw-bold fs-5">Product Name Contains:</label>
                            <p class="sm-text text-body-secondary fst-italic">Enter all or part of the name of the product</p>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-8 pe-0">
                                    <input type="text" id="name" name="name" class="form-control form-control-lg form-control-site-lg border-site-primary rounded-0 text-center" placeholder="e.g: 'Bolas'">
                                </div>
                                <div class="col-4 ps-0">
                                    <div class="">
                                        <select name="exact_card_name" class="form-select rounded-0 form-select-lg border-site-primary mb-2">
                                            <option class="form-control" value="false" selected>Partial Search</option>
                                            <option class="form-control" value="true">Exact Search</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-md-4">
                            <label for="within_text" class="fw-bold fs-5">Search Within Text:</label>
                            <p class="sm-text text-body-secondary fst-italic">Enter oracle/text ability of a card</p>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="within_text" name="within_text" class="form-control form-control-lg form-control-site-lg border-site-primary rounded-0 text-center" placeholder="e.g : 'Scratch on back'">
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-md-4">
                            <label class="fw-bold fs-5">Format - Legal In:</label>
                            <p class="sm-text text-body-secondary fst-italic">Select one or more formats</p>
                        </div>
                        <div class="col-md-8">
                            <select name="category_1" class="form-select rounded-0 form-select-lg border-site-primary mb-2">
                                <option class="form-control" selected disabled>Choose Format 1</option>
                                <option class="form-control" value="standard">standard</option>
                                <option class="form-control" value="pioneer">pioneer</option>
                                <option class="form-control" value="modern">modern</option>
                                <option class="form-control" value="legacy">legacy</option>
                                <option class="form-control" value="pauper">pauper</option>
                                <option class="form-control" value="vintage">vintage</option>
                                <option class="form-control" value="commander">commander</option>
                                <option class="form-control" value="oldschool">oldschool</option>
                                <option class="form-control" value="premodern">premodern</option>
                            </select>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-md-4">
                            <label class="fw-bold fs-5">Card Colors:</label>
                            <p class="sm-text text-body-secondary fst-italic">Select one or more color</p>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="text-center pe-3 w-auto">
                                    <input type="checkbox" id="myCheckbox1" value="1" name="color[]">
                                    <label for="myCheckbox1" class="p-0 m-0">
                                        <img src="{{asset('images/colors/white.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder">White</p>
                                </div>
                                <div class="text-center pe-3 w-auto">
                                    <input type="checkbox" id="myCheckbox2" value="2"  name="color[]">
                                    <label for="myCheckbox2" class="p-0 m-0">
                                        <img src="{{asset('images/colors/blue.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder">Blue</p>
                                </div>
                                <div class="text-center pe-3 w-auto">
                                    <input type="checkbox" id="myCheckbox3" value="3"  name="color[]">
                                    <label for="myCheckbox3" class="p-0 m-0">
                                        <img src="{{asset('images/colors/black.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder">Black</p>
                                </div>
                                <div class="text-center pe-3 w-auto">
                                    <input type="checkbox" id="myCheckbox4" value="4"  name="color[]">
                                    <label for="myCheckbox4" class="p-0 m-0">
                                        <img src="{{asset('images/colors/red.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder">Red</p>
                                </div>
                                <div class="text-center pe-3 w-auto">
                                    <input type="checkbox" id="myCheckbox5" value="5"  name="color[]">
                                    <label for="myCheckbox5" class="p-0 m-0">
                                        <img src="{{asset('images/colors/green.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder">Green</p>
                                </div>
                                <div class="text-center pe-3 w-auto">
                                    <input type="checkbox" id="myCheckbox6" value="6"  name="color[]">
                                    <label for="myCheckbox6" class="p-0 m-0">
                                        <img src="{{asset('images/colors/colorless.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder">Colorless</p>
                                </div>
                                <div class="text-center pe-3 w-auto">
                                    <input type="checkbox" id="myCheckbox7" value="7"  name="color[]">
                                    <label for="myCheckbox7" class="p-0 m-0">
                                        <img src="{{asset('images/colors/multicolor.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder">Multicolor</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-md-4">
                            <label for="card_type" class="fw-bold fs-5">Card Type:</label>
                            <p class="sm-text text-body-secondary fst-italic">Enter multiple options</p>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="card_type" name="card_type" class="py-0 tags form-control form-control-lg form-control-site-lg border-site-primary rounded-0 text-center" placeholder="e.g : 'Warior' , 'Bolas' ">
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-md-4">
                            <label class="fw-bold fs-5">Card characteristics:</label>
                            <p class="sm-text text-body-secondary fst-italic">Select one or more characteristics</p>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="text-center pe-3 w-auto">
                                    <input type="checkbox" id="myCheckbox8" value="foil" name="characterstics[]">
                                    <label for="myCheckbox8" class="p-0 m-0">
                                        <img src="{{asset('images/characterstics/foil.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder">Foil</p>
                                </div>
                                <div class="text-center pe-3 w-auto">
                                    <input type="checkbox" id="myCheckbox9" value="non_foil" name="characterstics[]">
                                    <label for="myCheckbox9" class="p-0 m-0">
                                        <img src="{{asset('images/characterstics/non-foil.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder">Non-Foil</p>
                                </div>
                                <div class="text-center pe-3 w-auto">
                                    <input type="checkbox" id="myCheckbox10" value="etched" name="characterstics[]">
                                    <label for="myCheckbox10" class="p-0 m-0">
                                        <img src="{{asset('images/characterstics/etched.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder">Etched</p>
                                </div>
                                <div class="text-center pe-3 w-auto">
                                    <input type="checkbox" id="myCheckbox11" value="signed" name="characterstics[]">
                                    <label for="myCheckbox11" class="p-0 m-0">
                                        <img src="{{asset('images/characterstics/signed.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder">Signed</p>
                                </div>
                                <div class="text-center pe-3 w-auto">
                                    <input type="checkbox" id="myCheckbox12" value="graded" name="characterstics[]">
                                    <label for="myCheckbox12" class="p-0 m-0">
                                        <img src="{{asset('images/characterstics/graded.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder">Graded</p>
                                </div>
                                <div class="text-center pe-3 w-auto">
                                    <input type="checkbox" id="myCheckbox13" value="altered" name="characterstics[]">
                                    <label for="myCheckbox13" class="p-0 m-0">
                                        <img src="{{asset('images/characterstics/altered.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder">Altered</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-md-4">
                            <label class="fw-bold fs-5">Convert Mana Cost:</label>
                            <p class="sm-text text-body-secondary fst-italic">Select condition then value</p>
                        </div>
                        <div class="col-md-4">
                            <select name="cmc_order" class="form-select rounded-0 form-select-lg border-site-primary mb-2">
                                <option class="form-control" value=">">More Than, ></option>
                                <option class="form-control" value="<">Less Than, <</option>
                                <option class="form-control" value="=">Equal To, =</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="number" name="cmc_value" min="0" class="form-control form-control-lg form-control-site-lg border-site-primary rounded-0 text-center" placeholder="e.g :'5' ">
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-md-4">
                            <label for="name" class="fw-bold fs-5">Power & Toughness:</label>
                            <p class="sm-text text-body-secondary fst-italic">Select power/toughness, condition ,value</p>
                        </div>
                        <div class="col-md-2">
                            <select name="strength" class="form-select rounded-0 form-select-lg border-site-primary px-2 mb-2  fs-md-9">
                                <option class="form-control" value="power" selected>power</option>
                                <option class="form-control" value="toughness">toughness</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="strength_order" class="form-select rounded-0 form-select-lg border-site-primary px-2 mb-2 fs-md-9">
                                <option class="form-control" value=">">More Than, ></option>
                                <option class="form-control" value="<">Less Than, <</option>
                                <option class="form-control" value="=">Equal To, =</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="number" min="0" name="strength_value" class="form-control form-control-lg form-control-site-lg border-site-primary rounded-0 text-center" placeholder="e.g :'5'">
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-md-4">
                            <label class="fw-bold fs-5">Rarity:</label>
                            <p class="sm-text text-body-secondary fst-italic">Select one or more</p>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="text-center pe-3 w-auto">
                                    <input type="checkbox" id="myCheckbox14" value="common" name="rarity">
                                    <label for="myCheckbox14" class="p-0 m-0">
                                        <img src="{{asset('images/rarity/common.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder">Common</p>
                                </div>
                                <div class="text-center pe-3 w-auto">
                                    <input type="checkbox" id="myCheckbox15" value="uncommon" name="rarity">
                                    <label for="myCheckbox15" class="p-0 m-0">
                                        <img src="{{asset('images/rarity/uncommon.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder">Uncommon</p>
                                </div>
                                <div class="text-center pe-3 w-auto">
                                    <input type="checkbox" id="myCheckbox16" value="rare" name="rarity">
                                    <label for="myCheckbox16" class="p-0 m-0">
                                        <img src="{{asset('images/rarity/rare.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder">Rare</p>
                                </div>
                                <div class="text-center pe-3 w-auto">
                                    <input type="checkbox" id="myCheckbox17" value="mythic" name="rarity">
                                    <label for="myCheckbox17" class="p-0 m-0">
                                        <img src="{{asset('images/rarity/mythic.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder">Mythic</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-md-4">
                            <label class="fw-bold fs-5">Special Card:</label>
                            <p class="sm-text text-body-secondary fst-italic">Choose one or more</p>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="text-center pe-3 w-auto ">
                                    <input type="checkbox" id="myCheckbox18" value="double_side" name="special[]">
                                    <label for="myCheckbox18" class="p-0 m-0">
                                        <img src="{{asset('images/cardType/double-sided.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder fs-sm-7">Double-Sided</p>
                                </div>
                                <div class="text-center pe-3 w-auto ">
                                    <input type="checkbox" id="myCheckbox19" value="token" name="special[]">
                                    <label for="myCheckbox19" class="p-0 m-0">
                                        <img src="{{asset('images/cardType/token.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder fs-sm-7">Token</p>
                                </div>
                                {{-- <div class="text-center pe-3 w-auto ">
                                    <input type="checkbox" id="myCheckbox20" value="double_face" name="special[]">
                                    <label for="myCheckbox20" class="p-0 m-0">
                                        <img src="{{asset('images/cardType/double-face.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder fs-sm-7">Double-Faced</p>
                                </div> --}}
                                <div class="text-center pe-3 w-auto ">
                                    <input type="checkbox" id="myCheckbox21" value="oversized" name="special[]">
                                    <label for="myCheckbox21" class="p-0 m-0">
                                        <img src="{{asset('images/cardType/oversized.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder fs-sm-7">Oversized</p>
                                </div>
                                <div class="text-center pe-3 w-auto ">
                                    <input type="checkbox" id="myCheckbox22" value="art" name="special[]">
                                    <label for="myCheckbox22" class="p-0 m-0">
                                        <img src="{{asset('images/cardType/art.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder fs-sm-7">Art</p>
                                </div>
                                <div class="text-center pe-3 w-auto ">
                                    <input type="checkbox" id="myCheckbox23" value="other" name="special[]">
                                    <label for="myCheckbox23" class="p-0 m-0">
                                        <img src="{{asset('images/cardType/other.png')}}">
                                    </label>
                                    <p class="sm-text fw-bolder fs-sm-7">Other</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-warning rounded-0"><span class="fw-bold">Other:</span> Contain Schemes, Planes & Tokens</div>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-md-4">
                            <label for="set_name" class="fw-bold fs-5">Set:</label>
                            <p class="sm-text text-body-secondary fst-italic">Enter part or all of the set's name</p>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-8 pe-0">
                                    <input type="text" id="set_name" name="set_name" class="form-control form-control-lg form-control-site-lg border-site-primary rounded-0 text-center" placeholder="e.g : 'Commander'">

                                </div>
                                <div class="col-4 ps-0">
                                    <div class="">
                                        <select name="exact_set_name" class="form-select rounded-0 form-select-lg border-site-primary mb-2">
                                            <option class="form-control" value="false" selected>Partial Search</option>
                                            <option class="form-control" value="true">Exact Search</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-md-4">
                            <label for="artist_name" class="fw-bold fs-5">Artist's Name:</label>
                            <p class="sm-text text-body-secondary fst-italic">Enter all or part of the artist's name.</p>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="artist_name" name="artist_name" class="form-control form-control-lg form-control-site-lg border-site-primary rounded-0 text-center" placeholder="e.g : 'Anya'">
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-md-4">
                            <label for="condition" class="fw-bold fs-5">Minimum Card Condition:</label>
                            <p class="sm-text text-body-secondary fst-italic">Select one or more formats</p>
                        </div>
                        <div class="col-md-8">
                            <select name="condition" id="condition" class="form-select rounded-0 form-select-lg border-site-primary">
                                <option class="form-control" selected="" disabled="">Select one...</option>
                                <option class="form-control" value="NM">Near Mint</option>
                                <option class="form-control" value="LP">Light Play</option>
                                <option class="form-control" value="MP">Moderate Play</option>
                                <option class="form-control" value="HP">Heavy Play</option>
                                <option class="form-control" value="DMG">Damaged</option>
                            </select>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-md-4">
                            <label for="language" class="fw-bold fs-5">Language:</label>
                            <p class="sm-text text-body-secondary fst-italic">Type and select the card language</p>
                        </div>
                        <div class="col-md-8">
                            <select name="language" id="language" class="form-select rounded-0 form-select-lg border-site-primary">
                                <option class="form-control " selected="" disabled="">Select one...</option>
                                <option class="form-control " value="en">English</option>
                                <option class="form-control" value="de">German</option>
                                <option class="form-control" value="fr">French</option>
                                <option class="form-control" value="it">Italian</option>
                                <option class="form-control" value="pt">Portuguese</option>
                                <option class="form-control" value="sp">Spanish</option>
                                <option class="form-control" value="ru">Russian</option>
                                <option class="form-control" value="zhs">Chinese</option>
                                <option class="form-control" value="kr">Korean</option>
                                <option class="form-control" value="jp">Japanese</option>
                                <option class="form-control" value="ph">Phyrexian</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 py-3 text-center">
                        <button type="submit" class="btn  btn-site-primary  px-4 nav-link-info ">Search Now!</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

@endsection

@push('js')
<script src="{{asset('front/scripts/jQuery.tagify.min.js')}}"></script>
<script>
    $('.tags').tagify();
</script>
@endpush
