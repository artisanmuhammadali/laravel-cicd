@php($ans = $ans ?? '')
@php($is_false = $is_false ?? false)
@php($checked = $is_false ? 'checked' : '')
@php($col = $key == 0 ? '12' : '10')
<div class="row rowss">
    <div class="col-lg-{{$col}}">
        <div class="form-group">
            <label class="bold d-flex">Option
               ( <div class="form-check ml-2">
                    <input type="checkbox" name="is_false[{{$key}}]" {{$checked}}  value="1" class="form-check-input is_false"
                        id="is_false[{{$key}}]">
                    <label class="form-check-label" for="is_false[{{$key}}]">Is this false answer?</label>
                </div> )
            </label>
            <input type="text"  value="{{$ans}}" name="answers[]"
                class="form-control " placeholder="Answer">
        </div>
    </div>
    @if($key > 0)
    <div class="col-lg-2">
        <button type="button" class="btn btn-danger mt-2  remove_more_question"><i class="fa fa-trash"></i></button>
    </div>
    @endif
</div>