            <div class="card ">
                <div class="card-header card-header-primary card-header-icon">
                    <h5 class="card-title">Comming Soon Section</h5>
                    <hr>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" class="dropify" name="comsoon_image"
                                    data-default-file="{{$setting['comsoon_image'] ?? ''}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Left Text</label>
                                <input type="text" name="comsoon_left_text" class="form-control"
                                    value="{{$setting['comsoon_left_text'] ?? ''}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Right Text</label>
                                <textarea rows="7" name="comsoon_right_text" class="form-control rich_area">
                                    {{$setting['comsoon_right_text'] ?? ''}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bottom Text</label>
                                <textarea rows="7" name="comsoon_bottom_text" class="form-control rich_area">
                                    {{$setting['comsoon_bottom_text'] ?? ''}}</textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">submit</button>
                </div>
            </div>
