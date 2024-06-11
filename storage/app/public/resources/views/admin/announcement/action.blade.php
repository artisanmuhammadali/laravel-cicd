<div class="d-flex justify-content-center">
    <a class="dropdown-item btn btn-primary w-auto  me-50" href="{{route('admin.announcement.view',[$item->type , $item->id])}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" data-bs-original-title="Edit">
        <i class="fa fa-edit" ></i>
    </a>
    <a onclick="confirmationAlert('{{ route('admin.announcement.delete', $item->id) }}')"
    class="dropdown-item delete-btn btn btn-danger w-auto mr-10p" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-bs-original-title="Delete">
        <i class="fa fa-trash" ></i>
    </a>
</div>