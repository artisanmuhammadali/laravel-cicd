<div class="card ">
    <div class="card-header card-header-primary card-header-icon">
        <h5 class="card-title">Banner Section</h5>
        <hr>
    </div>
    <div class="card-body ">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Page Title</label>
                    <input type="text" name="terms_title" class="form-control"
                        value="{{$setting['terms_title'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Page Meta Description</label>
                    <textarea rows="7" name="terms_metaData" class="form-control">
                                    {{$setting['terms_metaData'] ?? ''}}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Image</label>
                    <input type="file" class="dropify" name="terms_banner_img" accept=".png, .jpg, .jpeg, .gif, .svg"
                        data-default-file="{{$setting['terms_banner_img'] ?? ''}}">
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">submit</button>
    </div>
</div>
