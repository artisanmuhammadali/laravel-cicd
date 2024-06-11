
@extends('layouts.app')
@section('title','Seller program')
@section('description','')
@push('css')
@endpush
@section('content')
<style>

</style>
<div class="container-fluid px-0">
    <section>
        <div class="container-md">
            <div class="row my-5">
                <div class="col-12">
                    <div class="row ">
                        <div class="col-12 text-center">
                            <h1 class="text-site-primary Welcome-Friendly pro_range_heading_2_area">Seller Survey</h1>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row   justify-content-center">
                    <div class="  col-md-12 col-12 text-center">
                    <form action="{{route('seller.survey.store')}}" method="post" id="surveyForm"  class=" p-md-5 p-3" enctype="multipart/form-data" >
                        @csrf
                        <div class="">
                            <ol type="1" class="ps-0">
                                @foreach($question as $qus)
                                <div class="shadow_site p-3 mb-3 fw-bolder">
                                    <li class="question_c ms-3">
                                        <div class="d-flex justify-content-between ">
                                            <label class="fw-bold text-start fst-italic seller-fs" name="{{$qus->option}}">{{$qus->option}}</label>
                                        </div>
                                        @if($qus->type == 'Text')
                                         <textarea name="question[{{$qus->id}}]" rows="3" class="text_field form-control"maxlength="500" value=""></textarea>
                                        @else
                                        <ol type="a">
                                            @foreach($qus->answers as $answer)
                                            <li>
                                                <div class=" text-start ms-2 mt-1 d-flex">
                                                    <input class="form-check-input radio_btn" type="radio" name="question[{{$qus->id}}]" value="{{$answer->id}}" id="{{$answer->id}}">
                                                    <label class="form-check-label fw-normal ps-2" for="{{$answer->id}}">
                                                        {{$answer->option}}
                                                    </label>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ol>
                                        @endif
                                    </li>
                                </div>
                                @error('{{$qus->option}}')
                                    <p class="text-danger text-start">{{ $message }}</p>
                                @enderror
                                @endforeach
                            </ol>
                        </div>

                                
                                <div class="row mt-2 text-start ">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-site-primary btn-lg px-5" title="Submit Form">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection


@push('js')
<script>
    var ques = 0;
    var questionAnswered = 0;
    var count = 0;
    $(document).ready(function () {
        $('#surveyForm').submit(function (e) {
            e.preventDefault();
            var ques = 0;
            var count = 0;
            $('.question_c').each(function () {
                ques = ques+1;
                questionAnswered =  $(this).find('.radio_btn:checked').length > 0;
                if (questionAnswered == '1') {
                    count = count + 1;
                }
            });
          
            $('.text_field').each(function () {
                let vall =  $(this).val();

                if (vall) {
                    count = count + 1;
                }
            });


            if (ques == count) {
                this.submit();
            } else {
                toastr.error("Please Complete your survey first");
            }
        });
    });
</script>
@endpush