<div class="d-flex justify-content-center">
    @if($item->is_active)
        {{-- <a href="{{ route('admin.sw.expansion.edit', $item->id) }}"
            class="btn btn-primary w-50p dropdown-item me-1" title="Edit">
            <i class='fa fa-edit'></i>
        </a> --}}
        <a href="{{ route('admin.sw.expansion.seo', $item->id) }}"
            class="btn btn-warning w-50p dropdown-item me-1" title="Seo">
            <i class='fa fa-tools'></i>
        </a>
        {{-- <a href="#" data-id="{{ $item->id }}" class="btn btn-warning w-50p dropdown-item clone_set" title="Clone">
            <i class='fa fa-copy'></i>
        </a> --}}
        <a onclick="confirmationAlert('{{ route('admin.sw.expansion.inactive', $item->id) }}')"
            class="dropdown-item delete-btn btn btn-danger w-auto ms-1" data-bs-toggle="tooltip" data-bs-placement="top"
            title="Deactivate" data-bs-original-title="De-Active">
            <i class="fa fa-ban" aria-hidden="true"></i>
        </a>
    @else
        {{-- <a data-target="#attributeModal" title="Update Release Date" class="btn btn-warning open_modal me-25"
            data-url="{{ route('admin.sw.expansion.modal', $item->id) }}" data-type="date">
            <i class='fa fa-edit'></i>
        </a>
        <a  title="Update Set" class="btn btn-secondary  me-25"
            href="{{ route('admin.sw.expansion.api.update', $item->code) }}">
            <i class='fa fa-edit'></i>
        </a> --}}
        
        @if($item->released_at <= now()->format('Y-m-d') )
            <a href="{{ route('admin.sw.expansion.active', $item->id) }}" title="Active Set" class="btn btn-primary"><i
            class="fa fa-solid fa-link"></i></a>
        @endif
    @endif
</div>
