<div class="row">
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Page Title</label>
            <input type="text" name="about_page_title" class="form-control setting_field"
                data-class="about_page_title" value="{{$setting['about_page_title'] ?? ''}}">
        </div>
    </div>
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Banner Image
            @if(isset($setting['about_us_banner']))
                <a href="{{$setting['about_us_banner']}}" target="_blank"><i class="fa fa-download"></i></a>
                @endif
            </label>
            <input type="file" class="form-control dropify upload_image" data-class="about_us_banner" name="about_us_banner">
        </div>
    </div>

    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Heading 1</label>
            <input type="text" name="about_us_heading_1" class="form-control setting_field"
                data-class="about_us_heading_1" value="{{$setting['about_us_heading_1'] ?? ''}}">
        </div>
    </div>
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Heading 2</label>
            <input type="text" name="about_us_heading_2" class="form-control setting_field"
                data-class="about_us_heading_2" value="{{$setting['about_us_heading_2'] ?? ''}}">
        </div>
    </div>
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Bottom text</label>
            <textarea rows="7" id="editor" name="about_us_heading_2_btm" data-class="about_us_heading_2_btm"
                class="form-control setting_field"> {{$setting['about_us_heading_2_btm'] ?? ''}}</textarea>
        </div>
    </div>

    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Product 1 img
            @if(isset($setting['about_us_1_img']))
                <a href="{{$setting['about_us_1_img']}}" target="_blank"><i class="fa fa-download"></i></a>
                @endif
            </label>
            <input type="file" class="form-control dropify upload_image" data-class="about_us_1_img" name="about_us_1_img">
        </div>
    </div>

    <hr>

    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Heading 1</label>
            <input type="text" name="about_us_middle_heading_1" class="form-control setting_field"
                data-class="about_us_middle_heading_1" value="{{$setting['about_us_middle_heading_1'] ?? ''}}">
        </div>
    </div>
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Heading 2</label>
            <input type="text" name="about_us_middle_heading_2" class="form-control setting_field"
                data-class="about_us_middle_heading_2" value="{{$setting['about_us_middle_heading_2'] ?? ''}}">
        </div>
    </div>
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Bottom text</label>
            <textarea rows="7" name="about_us_middle_heading_2_btm" data-class="about_us_middle_heading_2_btm"
                class="form-control setting_field"> {{$setting['about_us_middle_heading_2_btm'] ?? ''}}</textarea>
        </div>
    </div>

    <div class="col-md-12 py-2 mb-2">
        <div class="form-group">
            <label class="fw-bold">Product img 
            @if(isset($setting['about_us_middle_img']))
                <a href="{{$setting['about_us_middle_img']}}" target="_blank"><i class="fa fa-download"></i></a>
                @endif
            </label>
            <input type="file" class="form-control dropify upload_image" data-class="about_us_middle_img" name="about_us_middle_img">
        </div>
    </div>

    <hr>
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Heading</label>
            <input type="text" name="about_us_bottom_1" class="form-control setting_field"
                data-class="about_us_bottom_1" value="{{$setting['about_us_bottom_1'] ?? ''}}">
        </div>
    </div>
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Bottom text</label>
            <textarea rows="7" name="about_us_bottom_2_btm" data-class="about_us_bottom_2_btm"
                class="form-control setting_field"> {{$setting['about_us_bottom_2_btm'] ?? ''}}</textarea>
        </div>
    </div>
    <div class="col-md-6">
        <button class="btn btn-primary">Submit</button>
    </div>
</div>
