<div class="col-lg-12 col-12 order-2 order-lg-1">
    <div class="card border-0 py-4">
        <div class="card-header bg-white border-0 d-flex justify-content-between">
            <h3 class="mb-75 ms-5">Survey</h3>
        </div>
        <div class="card-body py-0">
            {{-- <div class="col-lg-8 d-flex justify-content-center">
                <ol type="1">
                    @foreach($survey as $key => $s)
                        <li>
                            <div class="d-flex justify-content-between">
                                <label class="fw-bold text-start">{{$key}}</label>
                            </div>
                            
                            <div class=" text-start ms-2">
                                <label class="form-check-label">
                                    {{$s->answer}}
                                    @if($s->type != 'Text')
                                        @if($s->status == 1)
                                        <span class="text-danger"><i data-feather='x'></i></span>
                                        @else
                                        <span class="text-success"><i data-feather='check'></i></span>
                                        @endif 
                                    @endif
                                </label>
                                
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div> --}}
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-11">
                        @foreach($survey as $key => $s)
                        <div class="survey-q p-3 my-2">
                            <div class="row">
                                <div class="col-11">
                                    <h3 class="fst-italic">
                                        {{$s->question}}
                                    </h3>
                                </div>
                                <div class="col-1 d-flex justify-content-center">
                                    @if($s->type != 'Text')
                                        @if($s->status == 1)
                                            <div class="circle bg-danger  d-flex justify-content-center align-items-center">
                                                <span class="text-white fs-1 fw-bolder"><i data-feather='x' class="survey"></i></span>
                                            </div>
                                        @else
                                            <div class="circle bg-success d-flex justify-content-center align-items-center">
                                                <span class="text-white fs-1 fw-bolder"><i data-feather='check' class="survey"></i></span>
                                            </div>
                                        @endif 
                                    @endif
                                </div>
                            </div>
                            <div class="mt-2 mx-2 d-flex align-items-center alert alert-secondary p-2">
                                <p class="fs-4 my-auto me-auto">{{$s->answer}}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>