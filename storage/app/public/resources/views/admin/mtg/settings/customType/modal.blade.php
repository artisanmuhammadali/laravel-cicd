<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Custom Type</h5>
        <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form action="{{route('admin.mtg.custom-type.store')}}" method="post" enctype="multipart/form-data" class="submit_form">
        @csrf
        <input type="hidden" name="id" value="{{$item->id ?? ""}}">
        <div class="modal-body">
            <label>Name</label>
            <input class="form-control title_box" name="name" value="{{$item->name ?? ""}}" required type="text">
        </div>
        {{-- <div class="modal-body">
            <label>Slug</label>
            <input class="form-control title_box" name="slug" value="{{$item->slug ?? ""}}" required type="text">
        </div> --}}
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>