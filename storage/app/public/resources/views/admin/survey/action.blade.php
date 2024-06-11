<div class="d-flex justify-content-center">
    <a href="{{ route('admin.surveys.edit', $query->id) }}" class="mx-1 dropdown-item btn btn-primary w-50p">
        <i class="fa fa-edit mr-50"></i>
    </a>
    <a onclick="deleteAlert('{{ route('admin.surveys.destroy', $query->id) }}')"
        class="dropdown-item delete-btn btn btn-danger w-50p mr-10p">
        <i class="fa fa-trash mr-50"></i>
    </a>
</div>