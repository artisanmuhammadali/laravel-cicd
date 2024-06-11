<div class="row mt-5">
    <h4>Select Options</h4>
</div>
<div class="row">
    @foreach ($ourHeader as $key=>$header)
        <div class="col-12 col-sm-6 mb-1">
            <label class="form-label" for="accountFirstName">{{$key}}</label>
        </div>
        <div class="col-12 col-sm-6 mb-1">
            <select name="{{$header}}" class="form-select prevent-repeated required" >
            <option class="form-control" selected disabled>Select</option>
            @foreach($csvOptions as $OpKey =>$option)
                <option class="form-control" value="{{$OpKey}}" class="Option{{$OpKey}}" data-op="{{$OpKey}}">{{$option}}</option>
            @endforeach
            </select>
        </div>
    @endforeach
</div>
<div class="row justify-content-end">
    <button class="btn btn-primary w-auto">Submit</button>
</div>
<script>
// get all select elements
var selects = document.querySelectorAll('.prevent-repeated');
// get all select elements

// keep track of selected options
var selectedOptions = new Map();

// add event listener to each select element
selects.forEach(select => {
  select.addEventListener('change', event => {
    // get the selected option
    var selectedOption = event.target.value;

    // check if the option is already selected
    if (selectedOptions.has(select)) {
      const previousOption = selectedOptions.get(select);
      if (previousOption !== selectedOption) {
        enableOptionInOtherSelects(previousOption);
        disableOptionInOtherSelects(selectedOption);
        selectedOptions.set(select, selectedOption);
      }
    } else {
      disableOptionInOtherSelects(selectedOption);
      selectedOptions.set(select, selectedOption);
    }

    event.target.style.borderColor = '#5da3dc';
  });
});

function enableOptionInOtherSelects(option) {
  selects.forEach(s => {
    if (s !== event.target) {
      const otherOption = s.querySelector(`option[value="${option}"]`);
      otherOption.disabled = false;
    }
  });
}

function disableOptionInOtherSelects(option) {
  selects.forEach(s => {
    if (s !== event.target) {
      const otherOption = s.querySelector(`option[value="${option}"]`);
      otherOption.disabled = true;
    }
  });
}
</script>