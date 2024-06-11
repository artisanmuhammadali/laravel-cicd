@extends('admin.layout.app')
@section('title','Dashboard')
@push('css')
<link rel="stylesheet" href="{{ asset('admin/assets/dashboard/css/dataTables.bootstrap4.min.css') }}" />
@endpush
@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section id="row-grouping-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom d-flex justify-content-between">
                                <h4 class="card-title text-capitalize">Redirect</h4>
                                <div class="">
                                    <button class="btn btn-icon btn-outline-success waves-effect downloadData" title="Export in Excel" data-type="redirects">
                                        <i data-feather='file-text'></i>
                                    </button>
                                    <a data-target="#attributeModal"
                                        class="btn btn-primary open_modal" data-url="{{route('admin.redirect.modal')}}">Add
                                        Redirect</a>
                                </div>
                            </div>
                            <div class="card-body mt-2">
                                <div class="table-responsive">
                                    <table class="table  table-striped datatables">
                                        <thead>
                                            <tr>
                                                <th class="text-center" scope="row">#</th>
                                                <th class="text-center" scope="col">From Url</th>
                                                <th class="text-center" scope="col">Redirect To Url</th>
                                                <th class="text-center" scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($list as $item)
                                            <tr>
                                                <th class="text-center" scope="row">{{$loop->iteration}}</th>
                                                <td class="text-center">{{$item->from}}</td>
                                                <td class="text-center">{{$item->to}}</td>
                                                <td class="d-flex justify-content-center ">
                                                    <a class="dropdown-item btn btn-primary w-auto open_modal me-1" data-url="{{route('admin.redirect.modal')}}" data-id="{{$item->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit">
                                                         <i class="fa fa-edit" ></i>
                                                     </a>
                                                     <a onclick="deleteAlert('{{ route('admin.redirect.delete', $item->id) }}')"
                                                        class="dropdown-item delete-btn btn btn-danger w-auto mr-10p" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete">
                                                         <i class="fa fa-trash" ></i>
                                                     </a>
                                                </td>
                                            </tr>
                                            <?php
                                                $avgJson[$loop->iteration]['#'] = $loop->iteration;
                                                $avgJson[$loop->iteration]['From Url'] = $item->from;
                                                $avgJson[$loop->iteration]['Redirect To Url'] = $item->to;
                                            ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <input type="hidden" value="{{json_encode($avgJson)}}" id="redirects"> 
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>


@endsection

@push('js')
@include('admin.components.export-pdf-excel')
<script src="{{asset('user/js/jquery.dataTable.min.js')}}"></script>
<script>
    $(document).ready(function () {
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