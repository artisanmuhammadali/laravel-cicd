@extends('admin.layout.app')
@section('title','Dashboard')
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
                                <h4 class="card-title text-capitalize">{{$item->name}}</h4>
                            </div>
                            <div class="card-body mt-2">
                                <form method="POST" action="{{route('admin.sw.products.update')}}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name ="card" value="{{$item->id}}">
                                    <label>Change Expension</label>
                                    <select class="form-control select2 sets">
                                        @foreach($sets as $set)
                                        <option class="form-control" value="{{$set->id}}"  data-name="{{$set->name}}"
                                            data-type="{{$set->custom_type}}" {{$item->sw_set_id == $set->id ? 'selected' : ''}}>{{$set->name}}</option>
                                        @endforeach
                                    </select>

                                    <button class="btn btn-primary mt-2">Submit</button>
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
@endpush
