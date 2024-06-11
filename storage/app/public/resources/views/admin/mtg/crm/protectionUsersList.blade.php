
@extends('admin.layout.app')
@section('title','Dashboard')
@push('css')
@include('admin.components.timepikerStyle')
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
            <section class="invoice-preview-wrapper">
                <div class="row invoice-preview">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header border-bottom ">
                                <h4 class="card-title text-capitalize">Protection Accounts List</h4>
                                <div>
                                    <button class="btn btn-icon btn-outline-success waves-effect downloadData" title="Export in Excel"
                                        data-type="list">
                                        <i data-feather='file-text'></i>
                                    </button>
                                    <!-- <button class="btn btn-icon btn-outline-danger waves-effect downloadData downloadPdf" id="downloadPdf" title="Export in PDF" data-type="deletedUserListValue">
                                        <i data-feather='printer'></i>
                                    </button> -->
                                </div>
                            </div>
                            <div class="card-body mt-2">

                                <div class="table-responsive">
                                    <table class="table table-hover datatables">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $user)
                                            <tr>
                                                <td>
                                                    {{$user->full_name}}
                                                </td>
                                                <td>
                                                    {{$user->email}}
                                                </td>
                                                <td>
                                                    {{$user->role}}
                                                </td>
                                                <td>
                                                    <a href="{{route('admin.user.detail',[$user->id , 'info'])}}"
                                                        target="_blank"
                                                        class="btn btn-outline-warning me-3 waves-effect "
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Detail"
                                                        data-bs-original-title="User Detail"><i
                                                            class="fa fa-bars"></i></a>
                                                    <a href="{{route('admin.mtg.conversation',$user->id)}}" target="_blank" class="btn btn-outline-success me-3 waves-effect " title="Chat"><i class="fa fa-comments" aria-hidden="true"></i></a>

                                                </td>

                                            </tr>
                                            <?php
                                                $list[$loop->iteration]['name'] = $user->full_name;
                                                $list[$loop->iteration]['email'] = $user->email;
                                                $list[$loop->iteration]['role'] = $user->role;
                                            ?>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <input type="hidden" value="{{json_encode($list)}}" id="list">
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
@include('admin.components.timepikerScript')
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
