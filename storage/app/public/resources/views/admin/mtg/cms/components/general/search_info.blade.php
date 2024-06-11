                <div class="card ">
                    <div class="card-header card-header-primary card-header-icon">
                        <h5 class="card-title">Search Info</h5>
                        <hr>
                    </div>
                    <div class="card-body ">
                    <div class="row">
                    		<div class="col-md-12">
                    			<div class="form-group">
                    				<label>Search Title</label>
                    				<input type="text" name="search_title"  class="form-control" value="{{$setting['search_title'] ?? ''}}">
                    			</div>
                    		</div>
                            <div class="col-md-12">
                    			<div class="form-group">
                    				<label for="favicon">Background Image</label>
                    				<input type="file" class="dropify" name="search_bg_img" data-default-file="{{$setting['search_bg_img'] ?? ''}}">
                    			</div>
                    		</div>
                    		<div class="col-md-6">
                    			<div class="form-group">
                    				<label>View all text</label>
                    				<input type="text" name="search_all" class="form-control" value="{{$setting['search_all'] ?? ''}}">
                    			</div>
                    		</div>
                    		<div class="col-md-6">
                    			<div class="form-group">
                    				<label >Detail search text</label>
                    				<input type="text" name="search_detail" class="form-control" value="{{$setting['search_detail'] ?? ''}}">
                    			</div>
                    		</div>
                    	</div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">submit</button>
                    </div>
                </div>