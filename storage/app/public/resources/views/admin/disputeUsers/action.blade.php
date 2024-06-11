<div class="d-flex">
    <a data-url="{{route('admin.dispute.modal',$query->seller->id)}}"  class="open_modal btn btn-outline-primary me-3 waves-effect " data-bs-toggle="tooltip" data-bs-placement="top" title="Change Seller Account Status" data-bs-original-title="Change Seller Account Status">
        <i class="fa fa-server" aria-hidden="true"></i>
    </a>
    <a data-url="{{route('admin.dispute.modal',$query->buyer->id)}}"  class="open_modal btn btn-outline-info me-3 waves-effect " data-bs-toggle="tooltip" data-bs-placement="top" title="Change Buyer Account Status" data-bs-original-title="Change Buyer Account Status">
        <i class="fa fa-server" aria-hidden="true"></i>
    </a>
    <a href="{{route('admin.orders.detail',$query->id)}}" target="_blank"  class="btn btn-outline-warning me-3 waves-effect " data-bs-toggle="tooltip" data-bs-placement="top" title="View Order Detail" data-bs-original-title="View Order Detail">
        <i class="fa fa-arrow-right" aria-hidden="true"></i>
    </a>
</div>