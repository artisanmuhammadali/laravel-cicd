@php($template = $template ?? null)
<form action="{{ $route }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    @if($method != 'POST')
    @method('PUT')
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="{{$template ? $template->title : ''}}">
            </div>
        </div>
        <div class="col-md-12">
            
            <div class="form-group">
                <label>Content</label>
                <textarea name="content" id="editor" class="editor">{!! $template ? $template->content : '' !!}</textarea>
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
