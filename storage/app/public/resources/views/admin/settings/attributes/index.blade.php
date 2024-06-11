@extends('admin.layout.app')
@section('title','Dashboard')
@push('css')
<link rel="stylesheet" href="{{ asset('admin/assets/dashboard/css/dataTables.bootstrap4.min.css') }}" />
@endpush
@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section id="row-grouping-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom d-flex justify-content-between">
                                <h4 class="card-title text-capitalize">Attributes</h4>
                                <div class="">
                                    <a data-target="#attributeModal" href="{{route('admin.sw.attributes.store')}}"
                                        class="btn btn-primary model_submission">Add
                                        Attribute</a>
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

<div class="modal fade" id="attributeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Attribute</h5>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" enctype="multipart/form-data" id="model_form">
                @csrf
                <div class="modal-body">
                    <label>Name</label>
                    <input class="form-control title_box" name="name" required type="text">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
@include('admin.components.datatablesScript')

<script>
         $(document).on('click', '.model_submission', function (e) {
            e.preventDefault();
            let target = $(this).data('target');
            let url = $(this).attr('href');
            let title = $(this).data('title');
            $('#model_form').attr('action',url);
            $('.title_box').val(title);
            $(target).modal('show');
        })
</script>
@endpush
