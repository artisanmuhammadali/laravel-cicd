@extends('admin.layout.app')
@section('title','Dashboard')
@push('css')
@endpush
@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section id="row-grouping-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom d-flex justify-content-between">
                                <h4 class="card-title text-capitalize">Survey</h4>
                            </div>
                            <div class="card-body mt-2">
                                @include('admin.survey.form',['route' => route('admin.surveys.update',$question->id),'method' => 'PUT'])
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    let count = 0;
    $(document).on('click','.add_more_question',function(){
        count++;
        let html = `<div class="row"><div class="col-lg-10">
                        <div class="form-group">
                            <label class="bold d-flex">Option
                               ( <div class="form-check ml-2">
                                    <input type="checkbox" name="is_false[${count}]" value="1" class="form-check-input is_false"
                                        id="is_false1">
                                    <label class="form-check-label" for="is_false1">Is this false answer?</label>
                                </div> )
                            </label>
                            <input type="text"  value="" name="answers[]"
                                class="form-control " placeholder="Answer">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-danger mt-2  remove_more_question"><i class="fa fa-trash"></i></button>
                    </div>
                    </div>
                    `;

        $('.append_options').append(html);
    })

    $(document).on('click','.remove_more_question',function(){
       $(this).closest('.row').remove();
       count--;
    });
    $(document).ready(function(){
        let optionType = $('.question_type').val();
        optionStatus(optionType)
    })
    $(document).on('change','.question_type',function(){
        let optionType = $('.question_type').val();
        optionStatus(optionType)
    })
    function optionStatus(optionType){
        if(optionType == 'Text')
        {
            $('.optionBox').hide();
        }
        else
        {
            $('.optionBox').show();
        }
    }
</script>
@endpush
