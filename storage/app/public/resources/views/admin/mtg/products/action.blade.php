<div class="d-flex">
    <a href="{{route('admin.mtg.products.seo' ,$item->id)}}" class="btn btn-warning me-1 dropdown-item"
        title="Seo" >
        <i class='fa fa-tools'></i>
    </a>
    <button class="btn btn-danger w-50p dropdown-item " onclick="deleteAlert('{{ route('admin.mtg.products.destroy', $item->id) }}')" title="Delete">
        <i class='fa fa-trash'></i>
    </button>
    @if(!$item->is_active)
        <a href="{{ route('admin.mtg.products.active', $item->id) }}" class="btn btn-success ms-1"
            title="Active">
            <i class="fa fa-bars"></i>
        </a>
    @endif
    @if($type == 'new_arrival' || $type == "single")
        <a href="{{ route('admin.mtg.products.update.new', $item->id) }}" class="btn btn-secondary ms-1"
            title="Update ">
            <i class="fa fa-file"></i>
        </a>
    @endif
</div>


