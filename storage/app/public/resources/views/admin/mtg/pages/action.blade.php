<div class="d-flex justify-content-center">
    <a href="{{ route('admin.mtg.cms.page.design', $query->slug) }}" title="Design" class=" dropdown-item btn btn-warning w-50p">
        <i class="fa fa-palette mr-50"></i>
    </a>
    <a href="{{ route('admin.mtg.cms.pages.edit', $query->id) }}"  title="Edit" class="mx-1 dropdown-item btn btn-primary w-50p">
        <i class="fa fa-edit mr-50"></i>
    </a>
    <a onclick="deleteAlert('{{ route('admin.mtg.cms.pages.destroy', $query->id) }}')"
        class="dropdown-item delete-btn btn btn-danger w-50p mr-10p"  title="Delete">
        <i class="fa fa-trash mr-50"></i>
    </a>
</div>

