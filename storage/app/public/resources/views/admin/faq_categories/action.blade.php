<div class="d-flex justify-content-center">
    <a href="{{ route('admin.mtg.cms.faq_categories.update', $query->id) }}"
       data-title="{{$query->title}}"
       data-target="#FaqCategoryModal"
       class="mx-1 dropdown-item btn btn-primary btn btn-primary model_submission ">
        <i class="fa fa-edit"></i>
    </a>
    <a  onclick="deleteAlert('{{ route('admin.mtg.cms.faq_categories.destroy', $query->id) }}')"
       class="dropdown-item delete-btn btn btn-danger mr-10p btn btn-danger">
        <i class="fa fa-trash"></i>
    </a>
</div>