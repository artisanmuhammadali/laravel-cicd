<div class="d-flex justify-content-center">
    <a href="{{ route('admin.sw.products.seo', $query->id) }}"
       class="dropdown-item btn btn-primary btn btn-primary model_submission me-1">
        <i class="fa fa-tools"></i>
    </a>
    <a  onclick="deleteAlert('{{ route('admin.sw.products.destroy', $query->id) }}')"
       class="dropdown-item delete-btn btn btn-danger mr-10p btn btn-danger">
        <i class="fa fa-trash"></i>
    </a>
    
</div>