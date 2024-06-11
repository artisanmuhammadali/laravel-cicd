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
                    <input type="text" name="notFound_title" class="form-control"
                        value="{{$setting['notFound_title'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Page Meta Description</label>
                    <textarea rows="7" name="notFound_metaData" class="form-control">{{$setting['notFound_metaData'] ?? ''}}</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">submit</button>
    </div>
</div>
