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
                                <h4 class="card-title text-capitalize">Standard Sets</h4>
                                <div class="">
                                    <a data-target="#attributeModal"
                                        class="btn btn-primary open_modal" data-url="{{route('admin.mtg.standard.set.modal')}}">Add
                                        Standard Sets</a>
                                </div>
                            </div>
                            <div class="card-body mt-2">
                                <div class="table-responsive">
                                    <table class="table  datatables">
                                        <thead>
                                            <tr>
                                                <th class="text-center" scope="row">#</th>
                                                <th class="text-center" scope="col">Icon</th>
                                                <th class="text-center" scope="col">Name</th>
                                                <th class="text-center" scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($Standard_list as $item)
                                            <tr>
                                                <td class="text-center">{{$loop->iteration}}</td>
                                                <td class="text-center">
                                                    <img class="myDIV h4Btn" src="{{$item->mtgset->icon}}" alt="{{$item->mtgset->name}}" width="50px">
                                                    <div class="hide hand h4" style="left: 32rem; top: 0px !important;">
                                                        <img class="rounded-3 lozad" alt="{{$item->mtgset->name}}" width="250" src="{{$item->mtgset->icon}}"  />
                                                    </div>
                                                </td>
                                                <td class="text-center">{{$item->mtgset->name}}</td>
                                                
                                                <td class="">
                                                     <div class="d-flex justify-content-center w-50">
                                                        <a onclick="deleteAlert('{{ route('admin.mtg.standard.set.delete', $item->id) }}')"
                                                            class="dropdown-item delete-btn btn btn-danger mr-10p text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete">
                                                            <i class="fa fa-trash" ></i>
                                                        </a>
                                                     </div>
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
</div>


@endsection
@push('js')
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
