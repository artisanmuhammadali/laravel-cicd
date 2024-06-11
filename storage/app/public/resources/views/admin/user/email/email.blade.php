@extends('admin.layout.app')
@section('title','Email')
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
            <section class="invoice-preview-wrapper">
                <div class="row invoice-preview">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header border-bottom d-flex justify-content-between">
                                <h4 class="card-title text-capitalize">Email</h4>
                            </div>
                            <div class="card-body">
                                 <form action="{{route('admin.user.email.send')}}" method="POST" enctype="multipart/form-data">
                                     @csrf
                                     <input type="hidden" name="id" value="{{$user->id}}">
                                    <div class="row mb-4 mt-5">
                                        <label class="fw-bolder">Email: {{$user->email}}</label>
                                        <div class="col-12 mt-2">
                                            <label class="fw-bolder">Subject</label>
                                            <input type="text" class="form-control" name="subject" required>
                                            @error('subject')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-12 mt-2">
                                            <label class="fw-bolder">Body</label>
                                            <textarea name="body" id="editor" class="editor"></textarea>
                                            @error('body')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-12 mt-2">
                                            <label class="fw-bolder">Preview</label>
                                            <div class="card text-start">
                                                <div class="card-body">
                                                    @include('admin.marketing.preview')
                                                </div>
                                            </div>
                                            
                                        </div>

                                    </div>
                                    <div class="d-flex justify-content-end">
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
@endsection

@push('js')
@include('admin.components.ckeditor2')

<script>
    $(document).ready(function(){
    $(document).on('change','.editor',function(){
        alert($(this).val());
    })
    })
</script>
@endpush


