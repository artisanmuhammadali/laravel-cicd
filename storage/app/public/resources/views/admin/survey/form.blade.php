<div>
    @php($question = $question ?? null)
    <form action="{{ $route }}" method="POST" enctype="multipart/form-data" id="myForm">
        @csrf
        @if($method != 'POST')
        @method('PUT')
        @endif
        <input type="hidden" value="mtg" name="type">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label class="bold">Question</label>
                    <input type="text" required value="{{$question ? $question->option : ''}}" name="question"
                        class="form-control " placeholder="Question">
                </div>
            </div>
            <div class="col-lg-12 mt-2">
                <div class="form-group">
                    <label class="bold">Question Type</label>
                    <select class="form-control question_type" name="question_type">
                        @php($selected = $question && $question->type == 'Options' ? 'selected' : '')
                        <option {{$selected}}>Options</option>
                        @php($selected = $question && $question->type == 'Text' ? 'selected' : '')
                        <option {{$selected}}>Text</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-12 mt-2 optionBox">
                <h2>Options</h2>
            </div>
            <div class="col-lg-12 optionBox">
                <div class=" append_options">
                @if($question && $question->answers->count() > 0)
                 @foreach($question->answers as $key => $answer)
                    @include('admin.survey.components.answerField',['key' => $key, 'ans' => $answer->option,'is_false' => $answer->status])
                 @endforeach
                 @else
                     @include('admin.survey.components.answerField',['key' => 0])
                 @endif
                </div>
                <div class="w-100 text-end mt-1">
                <button type="button" class="btn btn-success add_more_question" >Add More</button>
                </div>
            </div>


            <div class="col-lg-12 mt-2">
                <div class="form-group ">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>
