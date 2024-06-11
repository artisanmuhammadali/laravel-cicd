<div class="d-flex justify-content-center">
    <a href="{{ route('admin.sw.attributes.update', $item->id) }}"
       data-title="{{$item->name}}"
       data-target="#attributeModal"
       class="dropdown-item btn btn-primary btn btn-primary model_submission me-1">
        <i class="fa fa-edit"></i>
    </a>
    <a  onclick="deleteAlert('{{ route('admin.sw.attributes.destroy', $item->id) }}')"
       class="dropdown-item delete-btn btn btn-danger mr-10p btn btn-danger">
        <i class="fa fa-trash"></i>
    </a>
</div>