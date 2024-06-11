<div class="row">
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Page Title</label>
            <input type="text" name="home_title" class="form-control setting_field"
                data-class="home_title" value="{{$setting['home_title'] ?? ''}}">
        </div>
    </div>
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Page Meta Description</label>
            <input type="text" name="home_meta" class="form-control setting_field"
                data-class="home_meta" value="{{$setting['home_meta'] ?? ''}}">
        </div>
    </div>
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Banner
            @if(isset($setting['banner_img']))
                <a href="{{$setting['banner_img']}}" target="_blank"><i class="fa fa-download"></i></a>
                @endif
            </label>
            <input type="file" class=" form-control dropify upload_image" data-class="banner_img" name="banner_img"
                accept=".png, .jpg, .jpeg, .gif, .svg" data-default-file="{{$setting['banner_img'] ?? ''}}" data-type="background">
        </div>
    </div>

    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Heading 1</label>
            <input type="text" name="pro_range_heading_1" class="form-control setting_field"
                data-class="pro_range_heading_1" value="{{$setting['pro_range_heading_1'] ?? ''}}">
        </div>
    </div>
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Product 1 img 
            @if(isset($setting['product_1_img']))
                <a href="{{$setting['product_1_img']}}" target="_blank"><i class="fa fa-download"></i></a>
                @endif
            </label>
            <input type="file" class="form-control dropify upload_image" data-class="product_1_img" name="product_1_img"
                accept=".png, .jpg, .jpeg, .gif, .svg" data-default-file="{{$setting['product_1_img'] ?? ''}}">
        </div>
    </div>

    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Product 2 img 
            @if(isset($setting['product_2_img']))
                <a href="{{$setting['product_2_img']}}" target="_blank"><i class="fa fa-download"></i></a>
                @endif
            </label>
            <input type="file" class=" form-control dropify upload_image" name="product_2_img" data-type="background"
                data-class="product_2_img" accept=".png, .jpg, .jpeg, .gif, .svg"
                data-default-file="{{$setting['product_2_img'] ?? ''}}">
        </div>
    </div>

    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Product 3 img
            @if(isset($setting['product_3_img']))
                <a href="{{$setting['product_3_img']}}" target="_blank"><i class="fa fa-download"></i></a>
                @endif
            </label>
            <input type="file" class=" form-control dropify" name="product_3_img" accept=".png, .jpg, .jpeg, .gif, .svg"
              data-class="product_3_img"  data-default-file="{{$setting['product_3_img'] ?? ''}}">
        </div>
    </div>

    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Heading 2</label>
            <input type="text" name="pro_range_heading_2" class="form-control setting_field"
             data-class="pro_range_heading_2"   value="{{$setting['pro_range_heading_2'] ?? ''}}">
        </div>
    </div>
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Heading 2 Bottom text</label>
            <textarea rows="7" name="pro_range_heading_2_btm" class="form-control rich_area setting_field" data-class="pro_range_heading_2_btm">
                                    {{$setting['pro_range_heading_2_btm'] ?? ''}}</textarea>
        </div>
    </div>
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Page Context</label>
            <textarea rows="7" name="pro_range_pg_context" class="form-control rich_area setting_field" data-class="pro_range_pg_context">
                                    {{$setting['pro_range_pg_context'] ?? ''}}</textarea>
        </div>
    </div>
    <div class="col-md-6 py-2">
        <div class="form-group">
            <label class="fw-bold">Learn more btn</label>
            <input type="text" name="pro_range_learn" class="form-control setting_field"
                value="{{$setting['pro_range_learn'] ?? ''}}" data-class="pro_range_learn">
        </div>
    </div>
    <div class="col-md-6 py-2">
        <div class="form-group">
            <label class="fw-bold">Learn more btn link</label>
            <input type="text" name="pro_range_learnLink" class="form-control setting_field"
                value="{{$setting['pro_range_learnLink'] ?? ''}}" data-class="pro_range_learnLink">
        </div>
    </div>
    <hr>
    <label class="fw-bolder">Launching In Timer</label>
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Visibility</label>
            <select class="form-control" name="launching-in-visibility">
                <option value="d-none" {{$setting['launching-in-visibility'] == "d-none" ? "selected" : ""}} >Hide</option>
                <option value="d-block" {{$setting['launching-in-visibility'] == "d-block" ? "selected" : ""}}>Show</option>
            </select>
            
        </div>
    </div>
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Heading</label>
            <input type="text" name="launching-in-heading" class="form-control setting_field"
                value="{{$setting['launching-in-heading'] ?? ''}}" data-class="launching-in-heading">
        </div>
    </div>
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Timer</label>
            <input type="date" name="launching-in-timer" class="form-control setting_field"
                value="{{$setting['launching-in-timer'] ?? ''}}" data-class="launching-in-timer">
        </div>
    </div>
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Launching In Bottom text</label>
            <textarea rows="7" name="launching-in-text" class="form-control rich_area setting_field" data-class="launching-in-text">
            {{$setting['launching-in-text'] ?? ''}}</textarea>
        </div>
    </div>
    <hr>
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Email Logo
            @if(isset($setting['email_logo']))
                <a href="{{$setting['email_logo']}}" target="_blank"><i class="fa fa-download"></i></a>
                @endif
            </label>
            <input type="file" class=" form-control dropify" name="email_logo" accept=".png, .jpg, .jpeg, .gif, .svg"
              data-class="email_logo"  data-default-file="{{$setting['email_logo'] ?? ''}}">
        </div>
    </div>
    @include('front.components.buy_sell_cms_form')
    <div class="col-md-6">
            <button class="btn btn-primary">Submit</button>
    </div>
</div>
