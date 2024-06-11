<div class="d-flex justify-content-center">
    <a class="dropdown-item btn btn-primary w-auto  open_modal me-1" data-url="{{route('admin.mtg.custom-type.modal')}}" data-id="{{$item->id}}">
    <i class="fa fa-edit"></i>
</a>
    <a  onclick="deleteAlert('{{ route('admin.mtg.custom-type.destroy', $item->id) }}')"
       class="dropdown-item delete-btn btn btn-danger mr-10p btn btn-danger">
        <i class="fa fa-trash"></i>
    </a>
</div>