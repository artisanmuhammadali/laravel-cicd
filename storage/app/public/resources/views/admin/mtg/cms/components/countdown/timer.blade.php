            <div class="card ">
                <div class="card-header card-header-primary card-header-icon">
                    <h5 class="card-title">Timer Section</h5>
                    <hr>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Heading</label>
                                <input type="text" name="timer_heading" class="form-control"
                                    value="{{$setting['timer_heading'] ?? ''}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Launching Date</label>
                                <input type="text" name="year" id="fp-default"
                                    class="form-control flatpickr-basic flatpickr-input active" placeholder="YYYY-MM-DD"
                                    readonly="readonly" value="{{$setting['year'] ?? ''}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Day label</label>
                                <input type="text" name="days" class="form-control" value="{{$setting['days'] ?? ''}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Hours label</label>
                                <input type="text" name="hours" class="form-control" value="{{$setting['hours'] ?? ''}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Minutes label</label>
                                <input type="text" name="minutes" class="form-control" value="{{$setting['minutes'] ?? ''}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Seconds label</label>
                                <input type="text" name="seconds" class="form-control" value="{{$setting['seconds'] ?? ''}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Page Context</label>
                                <textarea rows="7" name="cke_comsoon_pg_context" class="form-control rich_area">
                                    {{$setting['cke_comsoon_pg_context'] ?? ''}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Buy label</label>
                                <input type="text" name="ill_buy" class="form-control" value="{{$setting['ill_buy'] ?? ''}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sell label</label>
                                <input type="text" name="ill_sell" class="form-control" value="{{$setting['ill_sell'] ?? ''}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Intrested in both label</label>
                                <input type="text" name="ill_both" class="form-control" value="{{$setting['ill_both'] ?? ''}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Share with text</label>
                                <input type="text" name="share_with_friends" class="form-control"
                                    value="{{$setting['share_with_friends'] ?? ''}}">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">submit</button>
                </div>
            </div>
