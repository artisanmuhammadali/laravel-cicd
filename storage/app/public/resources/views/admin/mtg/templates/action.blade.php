<div class="d-flex justify-content-center">
    <a href="{{ route('admin.mtg.cms.templates.edit', $query->id) }}" class="dropdown-item btn btn-primary w-50p me-1">
        <i class="fa fa-edit mr-50"></i>
    </a>
    <a onclick="deleteAlert('{{ route('admin.mtg.cms.templates.destroy', $query->id) }}')"
        class="dropdown-item delete-btn btn btn-danger w-50p mr-10p">
        <i class="fa fa-trash mr-50"></i>
    </a>
</div>
