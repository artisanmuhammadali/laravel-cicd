<div class="modal-content" data-select2-id="36">
    <div class="modal-header bg-transparent">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body pb-5 px-sm-4 mx-50">
        <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Edit Collection</h1>
        <form action="{{route('user.collection.sw.save')}}" class="submit_form" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{$item->id}}">
            <input type="hidden" name="form_type" value="modal">
            <input type="hidden" name="card_type" value="{{$item->card_type}}">
            <input type="hidden" name="card_id" value="{{$item->sw_card_id}}">
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="mb-2">
                        <label class="form-label" for="blog-edit-category">Characteristics</label>
                        <div class="demo-inline-spacing">
                            <div class="form-check me-0 form-check-info">
                                @php($foil = $item->sw_card_type == "single" ? $item->card->foil : $item->card->set->foil)
                                @if($foil == 0)
                                <input type="checkbox" class="form-check-input" name="foil" id="colorCheck1" disabled>
                                @else
                                <input type="checkbox" class="form-check-input" name="foil" id="colorCheck1" {{$item->foil ? "checked" : ""}}>
                                @endif
                                <label class="form-check-label" for="colorCheck1">Foil</label>
                            </div>
                            <div class="form-check me-0 form-check-secondary">
                                <input type="checkbox" class="form-check-input" name="altered" id="colorCheck2"  {{$item->altered ? "checked" : ""}}>
                                <label class="form-check-label" for="colorCheck2">Altered</label>
                            </div>
                            <div class="form-check me-0 form-check-success">
                                <input type="checkbox" class="form-check-input" name="graded" id="colorCheck3"  {{$item->graded ? "checked" : ""}}>
                                <label class="form-check-label" for="colorCheck3">Graded</label>
                            </div>
                            <div class="form-check me-0 form-check-warning">
                                <input type="checkbox" class="form-check-input" name="signed" id="colorCheck6"  {{$item->signed ? "checked" : ""}}>
                                <label class="form-check-label" for="colorCheck6">Signed</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="mb-2">
                        <label class="form-label">Language</label>
                        @if($item->mtg_card_type == "completed")
                            @if($item->card->card_languages)
                            <div class="row mb-3">
                                @foreach($item->card->card_languages  as $key=> $lang)
                                <div class="form-group col-6">
                                    <label for="{{$key}}"  class="small">{{$lang}}</label>
                                    <input type="checkbox"  name="languages[{{$key}}]" id="{{$key}}">
                                </div>
                                @endforeach
                            </div>
                            @else
                            <label for="en">English</label>
                            <input type="checkbox" name="languages[en]" id="en">
                            @endif
                        @else    
                            <select class="form-select" name="language">
                                <option selected disabled>Select Language</option>
                                @if($item->card->card_languages)
                                    @foreach($item->card->card_languages  as $key=> $lang)
                                    <option class="form-control" value="{{$key}}" {{$item->language == $key ? "selected" : ""}}>{{$lang}}</option>
                                    @endforeach
                                @else
                                <option class="form-control" value="en" selected>English</option>
                                @endif
                            </select>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="mb-2">
                        <label class="form-label" for="blog-edit-title">Price</label>
                        <input type="number" name="price" value="{{$item->price}}" step="0.01" min="0.01" id="blog-edit-title" class="form-control"
                            placeholder="1">
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="mb-2">
                        <label class="form-label" for="blog-edit-title">Quantity</label>
                        <input type="number" name="quantity" value="{{$item->quantity}}" min="1" id="blog-edit-title" class="form-control"
                            placeholder="1">
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="mb-2">
                        <label class="form-label"  for="blog-edit-status">Condition</label>
                        <select class="form-select" name="condition" id="blog-edit-status">
                            <option class="form-control" value="NM" {{$item->condition == "NM" ? "selected" : ""}}>NM</option>
                            <option class="form-control" value="LP" {{$item->condition == "LP" ? "selected" : ""}}>LP</option>
                            <option class="form-control" value="MP" {{$item->condition == "MP" ? "selected" : ""}}>MP</option>
                            <option class="form-control" value="HP" {{$item->condition == "HP" ? "selected" : ""}}>HP</option>
                            <option class="form-control" value="D" {{$item->condition == "D" ? "selected" : ""}}>Dmg</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 mb-2">
                    <div class="border rounded p-2 mb-2">
                        <h4 class="mb-1">Image</h4>
                        <div class="d-flex flex-column flex-md-row">
                            <img src="{{$item->img}}" id="blog-feature-image"
                                class="rounded me-2 mb-1 mb-md-0" width="170" height="110"
                                alt="Blog Featured Image">
                            <div class="featured-info">
                                <small class="text-muted">Required image resolution 800x400, image size
                                    10mb.</small>
                                <div class="d-inline-block">
                                    <input class="form-control" name="photo" type="file" id="blogCustomFile"
                                        accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                    <textarea class="form-control mb-2" name="note" rows="4" placeholder="Note">{{$item->note}}</textarea>
                </div>
                <div class="col-12 mt-50 d-flex justify-content-end">
                    <button type="submit"
                        class="btn btn-primary me-1 waves-effect waves-float waves-light">Save
                        Changes</button>
                        <button type="button" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="{{asset('admin/js/scripts/forms/form-select2.js')}}"></script>