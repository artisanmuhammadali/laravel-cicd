<div class="card ">
    <div class="card-header card-header-primary card-header-icon">
        <h5 class="card-title">Logos</h5>
        <hr>
    </div>
    <div class="card-body ">
        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="favicon">KYB upload limit</label>
                    <input type="text" class="form-control" name="kyc_upload_limit"
                    value="{{$setting['kyc_upload_limit'] ?? ''}}">
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">submit</button>
    </div>
</div>
<div class="card ">
    <div class="card-header card-header-primary card-header-icon">
        <h5 class="card-title">Logos</h5>
        <hr>
    </div>
    <div class="card-body ">
        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    <label for="favicon">Favicon</label>
                    <input type="file" class="dropify" name="favicon" data-default-file="{{$setting['favicon'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="logo">Logo</label>
                    <input type="file" class="dropify" name="logo" data-default-file="{{$setting['logo'] ?? ''}}">
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">submit</button>
    </div>
</div>
