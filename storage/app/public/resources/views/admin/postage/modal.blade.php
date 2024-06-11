<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Postage</h5>
        <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form action="{{route('admin.postage.store')}}" method="post" enctype="multipart/form-data" class="submit_form">
        @csrf
        <input type="hidden" name="id" value="{{$item->id ?? ""}}">
        <div class="modal-body">
            <label>Name</label>
            <input class="form-control title_box" name="name" value="{{$item->name ?? ""}}" required type="text">
            <label>Service Price</label>
            <input class="form-control title_box" type="number" min="0" step="any" name="price" value="{{$item->price ?? ""}}" required>
            <label>Max Order Price</label>
            <input class="form-control title_box" type="number" min="0" step="any" name="max_order_price" value="{{$item->max_order_price ?? ""}}" required type="number">
            <label>Weight Limit</label>
            <input class="form-control title_box" name="weight" value="{{$item->weight ?? ""}}" required type="number">
            <label>Is Trackable</label>
            <select name="is_trackable" class="form-select" required>
                <option class="form-control" value="1">Yes</option>
                <option class="form-control" value="0">No</option>
            </select>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>