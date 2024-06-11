@extends('user.layout.app')
@section('title','Orders')
@push('css')
<link rel="stylesheet" href="{{ asset('user/css/dataTables.bootstrap5.min.css') }}"/>
<style>
    @media (max-width: 576px) {
  .mb-sm-3c {
    margin-bottom: 1rem !important;
  }
}
    </style>
@endpush
@section('content')
<div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
    <div class="content-body">
        <section class="invoice-preview-wrapper px-md-2">
            <div class="row invoice-preview">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{$type && $type == "buy" ? 'Purchases' : 'Sales'}}</h4>
                        </div>
                        <div class="card-body">
                            <nav>
                                <div class="nav nav-tabs d-flex d-block" id="nav-tab" role="tablist">
                                    @foreach($navs as $key => $nav)
                                    <a title="{{$nav}}" href="{{ route('user.order.index',[$type ,$nav]) }}"
                                        class="nav-link text-capitalize {{$nav == $slug ? "active" : ""}}"
                                        type="button"><i class="{{$key}}"></i><span class="d-sm-none d-xs-none d-none d-md-block">{{$nav}}</span>
                                        <span
                                            class="d-sm-none d-xs-none d-none d-md-block ms-25 {{$nav == $slug ? "bg-primary" : 'bg-secondary' }} badge rounded-pill cart-span">
                                            {{getOrderCount($nav , $type)}}
                                        </span>
                                    </a>
                                    @endforeach
                                </div>
                            </nav>

                            <div class="table-responsive java_custom_datatables">
                                <table class="table table-hover datatables">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" class="checkall"></th>
                                            <th><span class="d-md-table-cell d-none">Action</span><span class="d-md-none d-block" title="Actions"><i class="fa fa-tasks"></i></span></th>
                                            <th class="d-md-table-cell d-none">Order Id</th>
                                            @if($type == "buy")
                                            <th>Seller</th>
                                            @else
                                            <th>Buyer</th>
                                            @endif
                                            <th class="d-md-table-cell d-none">Transaction Id</th>
                                            <th>Price</th>
                                            @if($slug == "refunded")
                                            <th class="d-md-table-cell d-none">Refund Amount</th>
                                            @endif
                                            <th class="d-md-table-cell d-none">Status</th>
                                            <th class="d-md-table-cell d-none">Placed On</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($list as $item)
                                        <tr class="box_{{$slug}}" data-id="{{$item->id}}">
                                            <td>
                                                <input type="checkbox" class="checkboxes checkb"
                                                    data-id="{{$item->id}}">
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{route('user.order.detail',[$item->id ,$type])}}"
                                                        type="button"
                                                        class="btn btn-icon btn-outline-warning waves-effect"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                        data-bs-original-title="Order Detail">
                                                        <i class="fa fa-info d-block d-md-none d-lg-none d-xl-none"></i>
                                                       <span class="d-sm-none d-none d-md-block"> View Detail </span>
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="d-md-table-cell d-none">
                                                {{-- {{$loop->iteration}} --}}
                                                {{$item->id}}
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    @if($type == "buy")
                                                    <img src="{{$item->seller->main_image}}" class="me-75" height="20"
                                                        width="20" alt="Angular">
                                                    <span class="fw-bold"><a
                                                            href="{{route('profile.index',$item->seller->user_name)}}"
                                                            target="_blank">{{$item->seller->user_name}}</a></span>
                                                    @else
                                                    <img src="{{$item->buyer->main_image}}" class="me-75" height="20"
                                                        width="20" alt="Angular">
                                                    <span class="fw-bold"><a
                                                            href="{{route('profile.index',$item->buyer->user_name)}}"
                                                            target="_blank">{{$item->buyer->user_name}}</a></span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="d-md-table-cell d-none">
                                                {{$item->transaction_id}}
                                            </td>
                                            <td>
                                                £ {{$item->total}}
                                            </td>
                                            @if($slug == "refunded")
                                            <td class="d-md-table-cell d-none">
                                                £ {{$item->refund_amount}}
                                            </td>
                                            @endif
                                            <td class="d-md-table-cell d-none">
                                                <span
                                                    class="badge {{$item->status == 'completed' ? 'bg-success' : 'bg-primary'}} text-uppercase">
                                                    {{$item->status}}
                                                </span>

                                            </td>
                                            <td class="d-md-table-cell d-none">
                                                {{$item->created_at->format('Y/m/d')}}
                                            </td>

                                           
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$list->links()}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 collectionActionDiv d-none bg-site-primary px-2 py-1 text-center">
                    <div>
                        @if($type != 'buy')
                        <!-- <a href="{{route('user.order.bulk.download.pdf')}}?typee=pending&idd=1" class="btn btn-warning " data-type="{{$slug}}">Download PDF </a> -->
                        @if($slug == 'pending')
                        <button class="btn btn-warning bulk_down mb-sm-3c" data-name="shipmentLabel" data-bulk="label" data-type="{{$slug}}">Download
                            Shipment Labels <i class="fa fa-download"></i></button>
                        @endif
                        <button class="btn btn-warning bulk_down" data-name="orderSummary" data-bulk="summary" data-type="{{$slug}}"> Download
                            Order Summaries <i class="fa fa-download"></i></button>
                        @endif

                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@push('js')
<script>
    let idd = [];
    let typee = 'pending';
    let bulk = '';
    let dataName = '';
    $(document).on('click', '.bulk_down', function () {
        bulk = $(this).data('bulk');
        typee = $(this).data('type');
        dataName = $(this).data('name');
        $('.checkb:checked').each(function () {
            idd.push($(this).data('id'));
        });
        bulkPdfAjax();
        // $(".box_" + typee).each(function (index) {
        //     idd = $(this).data('id');
        //     bulkPdfAjax()
        // });
        toastr.success('Successsfully Downloaded');
    })

    function bulkPdfAjax() {
        $.ajax({
            type: "GET",
            data: {
                idd: idd,
                typee: typee,
                bulk: bulk,
            },
            url: '{{route('user.order.bulk.download.pdf')}}',
            xhrFields: {
                responseType: 'blob'
            },
            success: function (response) {
                if (response.error) {
                    toastr.error(response.error);
                }

                var blob = new Blob([response]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = dataName+".pdf";
                link.click();
            },
            error: function (blob) {
                console.log(blob);
            }
        });
    }

</script>
<script src="{{asset('user/js/jquery.dataTable.min.js')}}"></script>
<script>
    $(document).ready(function(){

           // Datatable Initalized
           var table = $('.datatables').DataTable({
               "sort": false,
               "ordering": false,
               "pagingType": "full_numbers",
               responsive: true,
               language: {
                   search: "_INPUT_",
                   searchPlaceholder: "Search records",
               }
           });
       })
</script>
@endpush
