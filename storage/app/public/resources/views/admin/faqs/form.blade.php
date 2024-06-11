<div>
    @php($faq = $faq ?? null)
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
                    <input type="text" required value="{{$faq ? $faq->question : ''}}" name="question"
                        class="form-control " placeholder="Question">
                </div>
            </div>
          
            <div class="col-lg-12 mt-1">
                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id" class="form-control form-select" >
                        @foreach($categories as $category)
                        @php($selected = $faq && $category->id == $faq->category_id ? 'selected' : '')
                        <option {{$selected}} value="{{$category->id}}">{{$category->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-12 mt-1">
                <div class="form-group">
                    <label>Answer</label>
                    <textarea rows="4" name="answer" class="form-control w-100 ckeditor"
                        placeholder="Description">{!! $faq ? $faq->answer : '' !!}</textarea>
                </div>
            </div>
            <div class="col-lg-12 mt-2">
                <div class="form-group ">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-danger">Cancel</button>
                </div>
            </div>
        </div>
    </form>
</div>

