@extends('admin.layout.app')
@section('title',$page->title)
@push('css')
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
                                <h4 class="card-title">Page - {{$page->title}}</h4>
                            </div>
                            <div class="card-body mt-2">
                                <form action="{{route('admin.mtg.cms.pages.update',$page->id)}}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row mb-4">
                                        <div class="col-4">
                                            <label class="fw-bolder">Title: <span
                                                    class="fw-normal">{{$page ? $page->title : ''}}</span></label>
                                        </div>
                                        <div class="col-4">
                                            <label class="fw-bolder">Slug: <span class="fw-normal">(
                                                    {{URL::to('/')}}/{{$page ? $page->slug : ''}})</span></label>
                                        </div>
                                        <div class="col-4">
                                            <label class="fw-bolder">Display Location: <span
                                                    class="fw-normal">{{$page ? $page->appearance_type : ''}}</span></label>
                                        </div>
                                    </div>
                                    {{--<div class="image_selector import_templates"
                                        data-url="{{route('admin.mtg.cms.templates.list')}}">
                                        <span><i class="fa fa-plus"></i></span>
                                    </div>--}}
                                    <label class="fw-bolder">Description</label>
                                    <textarea name="content" id="editor"
                                        class="editor">{!! $page ? $page->content : '' !!}</textarea>


                                    <hr>
                                    <h2>Table Of Contents</h2>
                                    <div class="append_content">
                                        @if($page->contents->count() > 0)
                                        @foreach($page->contents as $key => $c)
                                        
                                        @php($col = $key == 0 ? '6' : '5')
                                        <div class="row">
                                        <input value="{{$c->id}}" name="con_ids[]" type="hidden">
                                            <div class="col-{{$col}}">
                                                <label class="fw-bolder">content:</label>
                                                <input name="table_content[]" id="" class="form-control"
                                                    value="{{$c->content}}">
                                            </div>
                                            <div class="col-6">
                                                <label class="fw-bolder">Target:</label>
                                                <input name="table_target[]" id="" class="form-control"
                                                    value="{{$c->link}}">
                                            </div>
                                            @if($col == 5)
                                            <div class="col-1">
                                                <button type="button" class="remove_content btn btn-danger mt-2"><i
                                                        class="fa fa-trash"></i></button>
                                            </div>
                                            @endif
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="row">
                                            <input  name="con_ids[]" type="hidden">
                                            <div class="col-6">
                                                <label class="fw-bolder">content:</label>
                                                <input name="table_content[]" id="" class="form-control">
                                            </div>
                                            <div class="col-6">
                                                <label class="fw-bolder">Target:</label>
                                                <input name="table_target[]" id="" class="form-control">
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-success m-1 add_content">Add
                                            Content</button>
                                        <button type="submit" class="btn btn-primary m-1">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<div class="modal fade" id="templateModal" tabindex="-1" role="dialog" aria-labelledby="templateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="max-width: 700px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="templateModalLabel">Templates</h5>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body appendTemplates">
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
@include('admin.components.ckeditor1')

<script>
    $(document).on('click', '.add_content', function () {
        let html = `<div class="row">
                                            <div class="col-5">
                                                <label class="fw-bolder">content:</label>
                                                <input name="table_content[]" id="" class="form-control">
                                            </div>
                                            <div class="col-6">
                                                <label class="fw-bolder">Target:</label>
                                                <input name="table_target[]" id="" class="form-control">
                                            </div>
                                            <div class="col-1">
                                                <button type="button" class="remove_content btn btn-danger mt-2"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </div>`;
        $('.append_content').append(html);

    })
    $(document).on('click', '.remove_content', function () {
        $(this).closest('.row').remove();

    })
    $(document).on('click', '.import_templates', function () {
        let url = $(this).data('url');
        $.ajax({
            type: "GET",
            data: {},
            url: url,
            success: function (response) {
                $('.appendTemplates').html(response.html);
                $('#templateModal').modal('show');
            }
        });
    })

    $(document).on('click', '.copy_template', function () {
        var val = Math.floor(1000 + Math.random() * 9000);
        $('.randomId').text(val);
        var textToCopy = $(this).closest('.row').find('.copy_content').html();
        var tempTextarea = $('<textarea>');
        $('#templateModal').append(tempTextarea);
        tempTextarea.val(textToCopy).select();
        document.execCommand('copy');
        tempTextarea.remove();
        toastr.success('Successfully Copied');
    });

</script>
@endpush
