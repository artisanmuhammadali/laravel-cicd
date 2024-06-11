@php($media = $media ?? null)
<form action="{{ $route }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    @if($method != 'POST')
    @method('PUT')
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Image</label>
                <input type="file" name="file" class="dropify" accept=".png, .jpg, .jpeg, .gif, .svg" data-default-file="{{$media ? 'https://img.veryfriendlysharks.co.uk/'.$media->url : ''}}">
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
