            <div class="card ">
                <div class="card-header card-header-primary card-header-icon">
                    <h5 class="card-title">Product Range Section</h5>
                    <hr>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Heading 1</label>
                                <input type="text" name="pro_range_heading_1" class="form-control"
                                    value="{{$setting['pro_range_heading_1'] ?? ''}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Product 1 img</label>
                                <input type="file" class="dropify" name="product_1_img" accept=".png, .jpg, .jpeg, .gif, .svg"
                                    data-default-file="{{$setting['product_1_img'] ?? ''}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Product 2 img</label>
                                <input type="file" class="dropify" name="product_2_img" accept=".png, .jpg, .jpeg, .gif, .svg"
                                    data-default-file="{{$setting['product_2_img'] ?? ''}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Product 3 img</label>
                                <input type="file" class="dropify" name="product_3_img" accept=".png, .jpg, .jpeg, .gif, .svg"
                                    data-default-file="{{$setting['product_3_img'] ?? ''}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Heading 2</label>
                                <input type="text" name="pro_range_heading_2" class="form-control"
                                    value="{{$setting['pro_range_heading_2'] ?? ''}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Heading 2 Bottom text</label>
                                <textarea rows="7" name="pro_range_heading_2_btm" class="form-control rich_area">
                                    {{$setting['pro_range_heading_2_btm'] ?? ''}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Page Context</label>
                                <textarea rows="7" name="pro_range_pg_context" class="form-control rich_area">
                                    {{$setting['pro_range_pg_context'] ?? ''}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Learn more btn</label>
                                <input type="text" name="pro_range_learn" class="form-control"
                                    value="{{$setting['pro_range_learn'] ?? ''}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Learn more btn link</label>
                                <input type="text" name="pro_range_learnLink" class="form-control"
                                    value="{{$setting['pro_range_learnLink'] ?? ''}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">submit</button>
                </div>
            </div>
            <!-- done -->
