<div class="row">
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Page Title</label>
            <input type="text" name="mtg_page_title" class="form-control setting_field"
                data-class="mtg_page_title" value="{{$setting['mtg_page_title'] ?? ''}}">
        </div>
    </div>
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Page Meta Description</label>
            <input type="text" name="mtg_page_meta" class="form-control setting_field"
                data-class="mtg_page_meta" value="{{$setting['mtg_page_meta'] ?? ''}}">
        </div>
    </div>
    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Banner Background Image
            @if(isset($setting['mtg_banner_backgorund']))
                <a href="{{$setting['mtg_banner_backgorund']}}" target="_blank"><i class="fa fa-download"></i></a>
                @endif
            </label>
            <input type="file" class="form-control dropify upload_image" data-class="mtg_banner_backgorund"
                name="mtg_banner_backgorund" data-type="background">
        </div>
    </div>

    <div class="col-md-12 py-2">
        <div class="form-group">
            <label class="fw-bold">Banner Upper Image
            @if(isset($setting['mtg_banner_upper']))
                <a href="{{$setting['mtg_banner_upper']}}" target="_blank"><i class="fa fa-download"></i></a>
                @endif
            </label>
            <input type="file" class="form-control dropify upload_image" data-class="mtg_banner_upper" name="mtg_banner_upper">
        </div>
    </div>

    <hr>
    
    @include('front.components.buy_sell_cms_form')
    <div class="col-md-12 py-2">
        <button class="btn btn-primary">Submit</button>
    </div>
</div>
