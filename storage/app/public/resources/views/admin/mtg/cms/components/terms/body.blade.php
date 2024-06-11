<div class="card ">
    <div class="card-header card-header-primary card-header-icon">
        <h5 class="card-title">Body Section</h5>
        <hr>
    </div>
    <div class="card-body ">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Page Context</label>
                    <textarea rows="7" name="terms_pg_context" class="form-control rich_area">
                                    {{$setting['terms_pg_context'] ?? ''}}</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">submit</button>
    </div>
</div>
