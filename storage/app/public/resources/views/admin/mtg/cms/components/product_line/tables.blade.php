<div class="card ">
    <div class="card-header card-header-primary card-header-icon">
        <h5 class="card-title">Tables</h5>
        <hr>
    </div>
    <div class="card-body ">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Page Title</label>
                    <input type="text" name="proline_title" class="form-control"
                        value="{{$setting['proline_title'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Page Meta Description</label>
                    <textarea rows="7" name="proline_metaData" class="form-control">
                                    {{$setting['proline_metaData'] ?? ''}}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Banner</label>
                    <input type="file" class="dropify" name="proline_banner" accept=".png, .jpg, .jpeg, .gif, .svg"
                        data-default-file="{{$setting['terms_banner_img'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Table 1 heading</label>
                    <input type="text" name="proline_table_1_haeding" class="form-control"
                        value="{{$setting['proline_table_1_haeding'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Table 2 heading</label>
                    <input type="text" name="proline_table_2_haeding" class="form-control"
                        value="{{$setting['proline_table_2_haeding'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Table 3 heading</label>
                    <input type="text" name="proline_table_3_haeding" class="form-control"
                        value="{{$setting['proline_table_3_haeding'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Newlly added Page Title</label>
                    <input type="text" name="proline_table_1_title" class="form-control"
                        value="{{$setting['proline_table_1_title'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Best Sellers Page Title</label>
                    <input type="text" name="proline_table_2_title" class="form-control"
                        value="{{$setting['proline_table_2_title'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Bargains Page Title</label>
                    <input type="text" name="proline_table_3_title" class="form-control"
                        value="{{$setting['proline_table_3_title'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Newlly added Page Meta</label>
                    <input type="text" name="proline_table_1_meta" class="form-control"
                        value="{{$setting['proline_table_1_meta'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Best Sellers Page Meta</label>
                    <input type="text" name="proline_table_2_meta" class="form-control"
                        value="{{$setting['proline_table_2_meta'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Bargains Page Meta</label>
                    <input type="text" name="proline_table_3_meta" class="form-control"
                        value="{{$setting['proline_table_3_meta'] ?? ''}}">
                </div>
            </div>

        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">submit</button>
    </div>
</div>
