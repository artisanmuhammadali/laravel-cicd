<div class="d-flex">
    <button type="button" class="btn btn-icon btn-outline-primary waves-effect me-1 open_modal" data-url="{{route('user.collection.edit',$item->id)}}">
        <i data-feather='edit-2'></i>
    </button>
    <button type="button" class="btn btn-icon btn-outline-danger waves-effect " onclick="deleteAlert('{{route('user.collection.delete',$item->id)}}')">
        <i data-feather='trash-2'></i>
    </button>
</div>

