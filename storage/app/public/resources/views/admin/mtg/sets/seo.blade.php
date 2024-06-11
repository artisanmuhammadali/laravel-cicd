@extends('admin.layout.app')
@section('title','Dashboard')
@push('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">
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
                                <h4 class="card-title">{{request()->type ? ucfirst(request()->type) : ''}} Seo Description - {{$set->name}}</h4>
                                <div class="d-flex">
                                    @if(request()->type)
                                    <a href="{{route('admin.mtg.sets.seo',$set->id)}}" class="btn btn-primary mx-1">Main Set</a>
                                    @endif
                                    @if($set->single_count)
                                    <a href="{{route('admin.mtg.sets.seo',$set->id)}}?type=single" class="btn btn-primary mx-1">Single</a>
                                    @endif
                                    @if($set->sealed_count)
                                    <a href="{{route('admin.mtg.sets.seo',$set->id)}}?type=sealed" class="btn btn-primary mx-1">Sealed</a>
                                    @endif
                                    @if($set->completed_count)
                                    <a href="{{route('admin.mtg.sets.seo',$set->id)}}?type=completed" class="btn btn-primary mx-1">Complete</a>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body mt-2">

                                <form method="POST" action="{{route('admin.mtg.sets.seo.store',$id)}}" class=""
                                    enctype="multipart/form-data">
                                    @csrf
                                    @if(request()->type)
                                    <input type="hidden" name="type" value="{{request()->type}}">
                                    @endif
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label>Set Name</label>
                                                <input type="text" name="name" class="form-control" required
                                                    placeholder="Enter Title" value="{{$set->name}}" />
                                                @error('title')
                                                <p class="error">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" name="title" class="form-control" required
                                                    placeholder="Enter Title" value="{{!request()->type ? $set->title : $seo->title}}" />
                                                @error('title')
                                                <p class="error">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2 {{!request()->type ? "" : "d-none"}}">
                                            <div class="form-group">
                                                <label>URL</label>
                                                <input type="text" name="slug" class="form-control" required
                                                    placeholder="Enter Slug" value="{{$set->slug}}" />
                                                @error('slug')
                                                <p class="error">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label>H1</label>
                                                <input type="text" name="heading" class="form-control" required
                                                    placeholder="Enter  Heading" value="{{!request()->type ?$set->heading : $seo->heading}}" />
                                                @error('heading')
                                                <p class="error">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label>H2</label>
                                                <input type="text" name="sub_heading" class="form-control" required
                                                    placeholder="Enter Sub Heading" value="{{!request()->type ?$set->sub_heading : $seo->sub_heading}}" />
                                                @error('sub_heading')
                                                <p class="error">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label>Meta Description</label>
                                                <textarea rows="5" name="meta_description" class="form-control" required
                                                   > {{!request()->type ?$set->meta_description : $seo->meta_description}} </textarea>
                                                @error('meta_description')
                                                <p class="error">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        @if(!request()->type)
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label>Icon</label>
                                                <input type="file" name="icon_img" data-default-file="{{$set->icon}}" class="dropify" accept=".png, .jpg, .jpeg, .gif, .svg">
                                                @error('icon_img')
                                                <p class="error">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Banner</label>
                                                <input type="file" name="banner_img" data-default-file="{{$set->banner}}" class="dropify" accept=".png, .jpg, .jpeg, .gif, .svg">
                                                @error('banner_img')
                                                <p class="error">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-md-12 mt-2">
                                            <button type="submit" class="btn btn-primary submit_btn">
                                                Submit
                                            </button>
                                        </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<script>
     $('.dropify').dropify({
        messages: {
        'default': '',
        'replace': '',
        'remove':  'Remove',
        'error':   'Ooops, something wrong happended.'
    }
     });
</script>
@endpush
