<div class="row">
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Page Title</label>
            <input type="text" name="sw_page_title" class="form-control setting_field"
                data-class="sw_page_title" value="{{$setting['sw_page_title'] ?? ''}}">
        </div>
    </div>
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Page Meta Description</label>
            <input type="text" name="sw_page_meta" class="form-control setting_field"
                data-class="sw_page_meta" value="{{$setting['sw_page_meta'] ?? ''}}">
        </div>
    </div>
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Banner Background Image
            @if(isset($setting['sw_banner_background']))
                <a href="{{$setting['sw_banner_background']}}" target="_blank"><i class="fa fa-download"></i></a>
                @endif
            </label>
            <input type="file" class="form-control dropify upload_image" data-class="sw_banner_background"
                name="sw_banner_background" data-type="background">
        </div>
    </div>

    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Banner Upper Image
            @if(isset($setting['sw_banner_upper']))
                <a href="{{$setting['sw_banner_upper']}}" target="_blank"><i class="fa fa-download"></i></a>
                @endif
            </label>
            <input type="file" class="form-control dropify upload_image" data-class="sw_banner_upper" name="sw_banner_upper">
        </div>
    </div>

    <hr>
    
    <div class="col-md-12 py-2">
        <button class="btn btn-primary">Submit</button>
    </div>
</div>
