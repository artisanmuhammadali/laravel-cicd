<div>

    @php($page = $page ?? null)
    <form action="{{ $route }}" method="POST" enctype="multipart/form-data" id="myForm">
        @csrf
        @if($method != 'POST')
        @method('PUT')
        @endif
        <input type="hidden" value="mtg" name="type">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="bold">Title</label>
                    <input type="text" required value="{{$page ? $page->title : ''}}" name="title"
                        class="form-control generateSlug" placeholder="Title">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="bold">Short Title</label>
                    <input type="text" required value="{{$page ? $page->short_title : ''}}" name="short_title"
                        class="form-control" placeholder="Short Title">
                </div>
            </div>
            <div class="col-lg-6 mt-1">
                <div class="form-group">
                    <label>Slug ( {{URL::to('/')}}/<span class="slug_string_area">{{$page ? $page->slug : ''}}</span>
                        )</label>
                    <input type="text" required value="{{$page ? $page->slug : ''}}" name="slug"
                        class="form-control slug_string" placeholder="Slug">
                </div>
            </div>
            <div class="col-lg-6 mt-1">
                <div class="form-group">
                    <label>Display Location</label>
                    <select name="types[]" class="form-control select2" multiple>
                        @foreach(appearanceType() as $app)
                        @php($selected = $page && isExistInArray($page->appearance_type,$app) ? 'selected' : '')
                        @php($visibleName = appearanceTypeVisibleName($app , 'single'))
                        <option {{$selected}}>{{$visibleName}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-12 mt-1">
                <div class="form-group">
                    <label>Meta Description</label>
                    <textarea rows="4" name="meta_description" class="form-control w-100"
                        placeholder="Description">{!! $page ? $page->meta_description : '' !!}</textarea>
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

<div class="modal fade" id="mediaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Media</h5>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body appendMediaUrls">

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
