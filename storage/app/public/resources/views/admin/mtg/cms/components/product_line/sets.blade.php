<div class="card ">
    <div class="card-header card-header-primary card-header-icon">
        <h5 class="card-title">Sets</h5>
        <hr>
    </div>
    <div class="card-body ">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Set Haeding 1</label>
                    <input type="text" name="proline_set_1_haeding" class="form-control"
                        value="{{$setting['proline_set_1_haeding'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Set haeding 2</label>
                    <input type="text" name="proline_set_2_haeding" class="form-control"
                        value="{{$setting['proline_set_2_haeding'] ?? ''}}">
                </div>
            </div>

        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">submit</button>
    </div>
</div>
