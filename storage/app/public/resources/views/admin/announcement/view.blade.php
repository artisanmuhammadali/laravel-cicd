@extends('admin.layout.app')
@section('title','Dashboard')
@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <form action="{{route('admin.announcement.save')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{$request->id ?? null}}">
                <input type="hidden" name="type" value="{{$request->type}}">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card ">
                            <div class="card-header card-header-primary card-header-icon">
                                <h5 class="card-title">{{ucfirst($request->type)}} Announcement Bar</h5>
                                <hr>
                            </div>
                            <div class="card-body ">
                            <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Label</label>
                                            <input type="text" name="label" value="{{$item->label ?? ""}}"  class="form-control">
                                        </div>
                                        @error('label')
                                            <p class="text-danger text-start">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Background Color</label>
                                            <input type="color" name="background" value="{{$item->background ?? ""}}"  class="form-control">
                                        </div>
                                        @error('background')
                                            <p class="text-danger text-start">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Announcement Text</label>
                                            <textarea class="text" id="editor" name="text" cols="150" rows="10">{{$item->text ?? ""}}</textarea>
                                        </div>
                                        @error('text')
                                            <p class="text-danger text-start">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Start Date</label>
                                            <input type="date" name="start_from" value="{{$item->view_start ?? ""}}" class="form-control">
                                        </div>
                                        @error('start_from')
                                            <p class="text-danger text-start">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Ending date</label>
                                            <input type="date" name="end_on" value="{{$item->view_end ?? ""}}" class="form-control">
                                        </div>
                                        @error('end_on')
                                            <p class="text-danger text-start">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Button Text</label>
                                            <input type="text" name="btn_text" value="{{$item->btn_text ?? ""}}" class="form-control">
                                        </div>
                                        @error('btn_text')
                                            <p class="text-danger text-start">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label >Button Link</label>
                                            <input type="text" name="btn_link" value="{{$item->btn_link ?? ""}}" class="form-control">
                                        </div>
                                        @error('btn_link')
                                            <p class="text-danger text-start">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
    
</script>
@endpush
