
<div class="modal-content" data-select2-id="36">
    <div class="modal-header bg-transparent pb-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body pb-2 px-sm-4 mx-50 ">
        <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Address</h1>
        <span class="text-danger">Note: Please Provide a valid UK address</span>
        <form id="addNewAddressForm" action="{{route('user.address.store') }}" method="POST" class="row gy-1 gx-2 submit_form">
            @csrf
            <input type="hidden" name="id" value="{{$address->id ?? ""}}">
            <div class="col-12">
                <label class="form-label" for="name">Address Label</label>
                <input type="text" id="name" name="name" value="{{$address->name ?? ""}}" class="form-control " required placeholder="John" data-msg="Please enter your Address Name">
            </div>
            <div class="col-6">
                <label class="form-label" for="modalAddressCountry">Country</label>
                <input type="text" id="modalAddressCountry" class="form-control " required  value="United Kingdom" disabled>
            </div>
            <div class="col-6">
                <label class="form-label" for="type">Type</label>
                @if($id != null)
                <select name="type" class="form-select" id="type">
                    <option class="form-control" value="primary"{{$address->type == "primary" ? 'selected' : ''}}>Primary</option>
                    <option class="form-control" value="secondary" {{$address->type == "secondary" ? 'selected' : ''}}>Secondary</option>
                </select>
                @else
                <select name="type" class="form-select" id="type">
                    <option class="form-control" value="primary">Primary</option>
                    <option class="form-control" value="secondary" selected>Secondary</option>
                </select>
                @endif
            </div>
            <div class="col-12">
                <label class="form-label" for="street_number">House number & Street name ( Address Line 1 )</label>
                <input type="text" id="street_number" value="{{$address->street_number ?? ""}}" name="street_number" class="form-control " required placeholder="12, Business Park">
            </div>
            <div class="col-12">
                <label class="form-label" for="street_number">House number & Street name ( Address Line 2 )</label>
                <div id="custom-search-input">
                    <div class="input-group">
                        <input id="autocomplete_search" name="address_2" type="text" class="form-control addressFields" placeholder="" />
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6">
                <label class="form-label" for="city">City</label>
                <input type="text" id="city" value="{{$address->city ?? ""}}" name="city" class="form-control " required placeholder="London">
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label" for="postal_code">Postal Code</label>
                <input type="text" id="postal_code" value="{{$address->postal_code ?? ""}}" name="postal_code" class="form-control " required placeholder="99950">
            </div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary me-1 mt-2 waves-effect waves-float waves-light submit_btn">Submit</button>
                <button type="reset" class="btn btn-outline-secondary mt-2 waves-effect primary-hover" data-bs-dismiss="modal" aria-label="Close">
                    Discard
                </button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAv-dmNya7R72r5JP2TMZ2YwSuTB17UqWg&libraries=places"></script>

<script>

  google.maps.event.addDomListener(window, 'load', initialize);

    function initialize() {

      var input = document.getElementById('autocomplete_search');

      var autocomplete = new google.maps.places.Autocomplete(input, {componentRestrictions:{country:["uk"]}});

      autocomplete.addListener('place_changed', function () {

      var place = autocomplete.getPlace();

      // place variable will have all the information you are looking for.

        var address = place.address_components;
      var city = $('#city').val(address[3].long_name)
      var postal_code =  $('#postal_code').val(address[6].long_name);
     $(".address_id").remove();   


    });

  }

</script>