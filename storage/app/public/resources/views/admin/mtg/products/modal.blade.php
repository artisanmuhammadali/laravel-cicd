<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Card Seo</h5>
        <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form action="{{route('admin.mtg.products.store')}}" method="post" enctype="multipart/form-data" class="submit_form">
        @csrf
        <input type="hidden" name="id" value="{{$item->id ?? ""}}">
        <div class="modal-body">
            <label>Title</label>
            <input class="form-control title_box" name="title" value="{{$item->seo->title ?? ""}}" required type="text">
            <label>Meta Description</label>
            <input class="form-control title_box" name="meta_description" value="{{$item->seo->meta_description ?? ""}}" required type="text">
            <label>Heading</label>
            <input class="form-control title_box" name="heading" value="{{$item->seo->heading ?? ""}}" required type="text">
            <label>Sub Heading</label>
            <input class="form-control title_box" name="sub_heading" value="{{$item->seo->sub_heading ?? ""}}" required type="text">
            <label>Weight</label>
            <input class="form-control title_box" name="weight" value="{{$item->weight ?? ""}}" required type="number">
            <label>Set Code</label>
            <select name="set_code"  class="form-control select2">
                @foreach($sets as $set)
                <option class="form-control" value="{{$set->code}}" {{$set->code == $item->set_code ? "selected" : ""}}>{{$set->name}}</option>
                @endforeach
            </select>
            @if($item->card_type == "sealed")
            <label>Image</label>
            <input type="file" class="form-control title_box" name="image" value="{{$item->png_image ?? ""}}">
            @endif
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Submit">Custom Type</button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function(){
        $('.select2').select2({
            width: '100%'
        });
    })
</script>