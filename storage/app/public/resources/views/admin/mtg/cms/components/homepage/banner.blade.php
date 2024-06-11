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
                                <input type="text" name="pro_range_title" class="form-control"
                                    value="{{$setting['pro_range_title'] ?? ''}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Page Meta Description</label>
                                <textarea rows="7" name="pro_range_metaData" class="form-control">
                                    {{$setting['pro_range_metaData'] ?? ''}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Banner Image 1</label>
                                <input type="file" class="dropify" name="banner_img" accept=".png, .jpg, .jpeg, .gif, .svg"
                                    data-default-file="{{$setting['banner_img'] ?? ''}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label >Banner Image 2</label>
                                <input type="file" class="dropify" name="banner_img_2" accept=".png, .jpg, .jpeg, .gif, .svg"
                                    data-default-file="{{$setting['banner_img_2'] ?? ''}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">submit</button>
                </div>
            </div>
