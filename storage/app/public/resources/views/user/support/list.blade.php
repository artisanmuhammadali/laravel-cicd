@extends('user.layout.app')
@section('title','Support')
@push('css')
    <link rel="stylesheet" href="{{ asset('user/css/dataTables.bootstrap5.min.css') }}"/>
@endpush
@section('content')
<div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
    <div class="content-body">
        <section class="app-user-app-user-view-account d-flex justify-content-center-account justify-content-center overflow-hidden  ps-md-2">
            <div class="row w-100" id="table-hover-row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Support Tickets</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover datatables">
                                    <thead>
                                        <tr>
                                            <th>Subject</th>
                                            <th>Description</th>
                                            <th>Priority</th>
                                            <th>Status</th>
                                            <th>Created on</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($list as $item)
                                        <tr>
                                            <td>
                                                {{$item->subject}}
                                            </td>
                                            <td>
                                                {{$item->description}}
                                            </td>
                                            <td>
                                                {{$item->priority}}
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{$item->status}}</span>
                                            </td>
                                            <td>
                                                {{customDate($item->created_at ,'d/m/Y')}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@push('js')
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
