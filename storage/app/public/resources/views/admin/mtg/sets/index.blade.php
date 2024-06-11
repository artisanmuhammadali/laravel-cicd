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
                                <h4 class="card-title text-capitalize">{{str_replace('_',' ',$type)}} - Sets</h4>
                                <div class="">
                                    {{-- @if($type != "new_arrival") --}}
                                    <a  href="{{route('admin.mtg.sets.create',$type)}}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Add {{$type}} sets">Add
                                    Set</a>
                                    {{-- @endif --}}
                                </div>
                            </div>
                            <div class="card-body mt-2">
                                <div class="table-responsive">
                                    {{ $dataTable->table(['class' => 'table text-center table-striped w-100'],true) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<div class="modal fade" id="cloneModal" tabindex="-1" role="dialog" aria-labelledby="cloneModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Clone</h5>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{route('admin.mtg.sets.clone')}}" class="" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="set_idd" name="set_id" value="">
                <div class="modal-body">
                <div class="col-md-12 mb-2">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required placeholder="Enter Name"
                            value="" />
                        <label>Code</label>
                        <input type="text" name="code" class="form-control" required placeholder="Enter Code"
                            value="" />
                    </div>
                </div>
                </div>
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Clone</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
@include('admin.components.datatablesScript')

<script>
    $(document).on('click', '.clone_set', function () {
      let id = $(this).data('id');
      $('.set_idd').val(id);
      $('#cloneModal').modal('show');
    })

</script>
@endpush
