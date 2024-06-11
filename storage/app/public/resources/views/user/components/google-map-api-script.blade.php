@php($apiUrl="https://maps.googleapis.com/maps/api/js?key=".env('GOOGLE_MAP_KEY')."&libraries=places")
<script  type="text/javascript" src="{{$apiUrl}}"></script>

<script>

post = '{{$address ? $address->postal_code : ''}}';
locality = '{{$address ? $address->city : ''}}';
  google.maps.event.addDomListener(window, 'load', initialize);

    function initialize() {

      var input = document.getElementById('autocomplete_search');

      var autocomplete = new google.maps.places.Autocomplete(input, {componentRestrictions:{country:["uk"]}});

      autocomplete.addListener('place_changed', function () {

      var place = autocomplete.getPlace();
       post =  extractCode(place.adr_address);
       locality =  extractLocality(place.adr_address);

     $('#postal_code').val(post);
        $('#city').val(locality);
      $(".address_id").remove();   


    });

  }
  $(document).on('keyup','.auto_searchh', function(){
     $('.postal_code').val('');
     $('.city').val('');
     post = '';
     locality = '';
  })

  function extractCode(str) {
    let stss =  /<span[^>]+class="[^"]*postal-code[^"]*"[^>]*>\s*([^<]+)\s*<\/span>/i.test(str);
    return  stss ? str.match(/<span class="postal-code">([^<]+)<\/span>/)[1] : '';
  }

  function extractLocality(str) {
      let stss =  /<span[^>]+class="[^"]*locality[^"]*"[^>]*>\s*([^<]+)\s*<\/span>/i.test(str);
      return stss ? str.match(/<span class="locality">([^<]+)<\/span>/)[1] : '';

 }
</script>