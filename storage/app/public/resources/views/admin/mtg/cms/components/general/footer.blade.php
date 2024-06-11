                <div class="card ">
                    <div class="card-header card-header-primary card-header-icon">
                        <h5 class="card-title">Footer</h5>
                        <hr>
                    </div>
                    <div class="card-body ">
                    <div class="row">
                    		{{--<div class="col-md-4">
                    			<!-- <div class="form-group">
                    				<label>Selling Heading</label>
                    				<input type="text" name="footer_haeding1"  class="form-control" value="{{$setting['footer_haeding1'] ?? ''}}">
                    			</div>
                    		</div>
                    		<div class="col-md-4">
                    			<div class="form-group">
                    				<label>Buying Heading</label>
                    				<input type="text" name="footer_haeding2"  class="form-control" value="{{$setting['footer_haeding2'] ?? ''}}">
                    			</div>
                    		</div>
                    		<div class="col-md-4">
                    			<div class="form-group">
                    				<label>Article Heading</label>
                    				<input type="text" name="footer_haeding3"  class="form-control" value="{{$setting['footer_haeding3'] ?? ''}}">
                    			</div> -->
                    		</div>--}}
                    		<div class="col-md-12">
                    			<div class="form-group">
                    				<label>Copyright Text</label>
                    				<textarea rows="4" name="copyright_text"  class="form-control" >{{$setting['copyright_text'] ?? ''}}</textarea>
                    			</div>
                    		</div>
                    		<div class="col-md-12">
                    			<div class="form-group">
                    				<label>Bottom Note</label>
                    				<textarea rows="4" name="bottom_note"  class="form-control" >{!!$setting['bottom_note'] ?? ''!!}</textarea>
                    			</div>
                    		</div>
                    	</div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">submit</button>
                    </div>
                </div>