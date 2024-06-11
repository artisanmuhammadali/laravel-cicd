                <div class="card ">
                    <div class="card-header card-header-primary card-header-icon">
                        <h5 class="card-title">Social Media Links</h5>
                        <hr>
                    </div>
                    <div class="card-body ">
                    <div class="row">
                    		<div class="col-md-6">
                    			<div class="form-group">
                    				<label>Facebook</label>
                    				<input type="link" name="facebook"  class="form-control" value="{{$setting['facebook'] ?? ''}}">
                    			</div>
                    		</div>
                    		<div class="col-md-6">
                    			<div class="form-group">
                    				<label>Twitter</label>
                    				<input type="link" name="twitter"  class="form-control" value="{{$setting['twitter'] ?? ''}}">
                    			</div>
                    		</div>
                    		<div class="col-md-6">
                    			<div class="form-group">
                    				<label>Instagram</label>
                    				<input type="link" name="instagram"  class="form-control" value="{{$setting['instagram'] ?? ''}}">
                    			</div>
                    		</div>
                    		<div class="col-md-6">
                    			<div class="form-group">
                    				<label>YouTube</label>
                    				<input type="link" name="youtube"  class="form-control" value="{{$setting['youtube'] ?? ''}}">
                    			</div>
                    		</div>
                    		<div class="col-md-6">
                    			<div class="form-group">
                    				<label>Threads</label>
                    				<input type="link" name="discord"  class="form-control" value="{{$setting['discord'] ?? ''}}">
                    			</div>
                    		</div>
                    	</div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">submit</button>
                    </div>
                </div>