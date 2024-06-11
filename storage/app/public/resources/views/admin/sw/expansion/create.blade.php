@extends('admin.layout.app')
@section('title','Dashboard')
@push('css')
@include('admin.components.timepikerStyle')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">
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
                                <h4 class="card-title">Add Expansion</h4>
                            </div>
                            <div class="card-body mt-2">

                                <form method="POST" action="{{route('admin.sw.expansion.store')}}" class=""
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="name" class="form-control" required
                                                    placeholder="Enter Name" value="" />
                                                @error('name')
                                                <p class="error">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label>Code</label>
                                                <input type="text" name="code" class="form-control" required
                                                    placeholder="Enter Code" value="" />
                                                @error('code')
                                                <p class="error">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label>Release Date</label>
                                                <input type="text" name="published_at" id="fp-default" class="form-control flatpickr-basic flatpickr-input active" placeholder="YYYY-MM-DD" readonly="readonly">
                                                @error('published_at')
                                                <p class="error">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

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
@include('admin.components.timepikerScript')
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
