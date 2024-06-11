<div class="row">
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Page Title</label>
            <input type="text" name="term_page_title" class="form-control setting_field"
                data-class="term_page_title" value="{{$setting['term_page_title'] ?? ''}}">
        </div>
    </div>
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Heading</label>
            <input type="text" name="terms_heading" class="form-control setting_field"
                data-class="terms_heading" value="{{$setting['terms_heading'] ?? ''}}">
        </div>
    </div>
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Bottom text</label>
            <textarea rows="7" name="terms_description" data-class="terms_description"
                class="form-control setting_field"> {{$setting['terms_description'] ?? ''}}</textarea>
        </div>
    </div>
    <div class="col-md-6">
        <button class="btn btn-primary">Submit</button>
    </div>
</div>
