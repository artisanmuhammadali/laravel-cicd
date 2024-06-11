                <div class="card ">
                    <div class="card-header card-header-primary card-header-icon">
                        <h5 class="card-title">General Info</h5>
                        <hr>
                    </div>
                    <div class="card-body ">
                    <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Company Name</label>
                                    <input type="text" name="company_name" class="form-control" value="{{$setting['company_name'] ?? ''}}">
                                </div>
                            </div>
                    		<div class="col-md-6">
                    			<div class="form-group">
                    				<label>Email</label>
                    				<input type="text" name="email" class="form-control" value="{{$setting['email'] ?? ''}}">
                    			</div>
                    		</div>
                    		<div class="col-md-6">
                    			<div class="form-group">
                    				<label >Address</label>
                    				<input type="text" name="address" class="form-control" value="{{$setting['address'] ?? ''}}">
                    			</div>
                    		</div>
                    	</div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">submit</button>
                    </div>
                </div>