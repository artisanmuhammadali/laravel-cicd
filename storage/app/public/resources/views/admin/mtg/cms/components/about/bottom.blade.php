<div class="card ">
    <div class="card-header card-header-primary card-header-icon">
        <h5 class="card-title">Bottom Section</h5>
        <hr>
    </div>
    <div class="card-body ">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Heading 1</label>
                    <input type="text" name="about_us_bottom_1" class="form-control"
                        value="{{$setting['about_us_bottom_1'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Heading 2 Bottom text</label>
                    <textarea rows="7" name="about_us_bottom_2_btm" class="form-control rich_area">
                                    {{$setting['about_us_bottom_2_btm'] ?? ''}}</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">submit</button>
    </div>
</div>
