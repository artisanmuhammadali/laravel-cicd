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
                                <h4 class="card-title text-capitalize">Sets - {{$currentSet->name}}</h4>
                            </div>
                            <div class="card-body mt-2">
                                <div>
                                    <select class="form-control select2 sets">
                                        <option class="form-control" value="">Select</option>
                                        @foreach($sets as $set)
                                        <option class="form-control" value="{{$set->id}}" data-name="{{$set->name}}"
                                            data-type="{{$set->custom_type}}">{{$set->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <hr>
                                <form method="POST" action="{{route('admin.mtg.sets.update',$id)}}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Custom Type</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="append">
                                                @foreach($currentSet->childs as $child)
                                                @if($child->is_active == 1)
                                                <tr class="child-{{$child->id}}">
                                                    <td>{{$child->name}}</td>
                                                    <td>
                                                        <select class="form-select" name="custom_type[{{$child->id}}]">

                                                            @foreach($types as $type)
                                                            @php($selected = $child->custom_type == $type->name ?
                                                            'selected' : '')
                                                            <option class="form-control" {{$selected}} value="{{$type->name}}">
                                                                {{$type->name}}</option>
                                                            @endforeach
                                                    </td>
                                                    <td><a onclick="deleteAlert('{{ route('admin.mtg.sets.removeChild', $child->id) }}')" class=" btn btn-danger delete-btn"><i
                                                                class="fa fa-trash"></i></a></td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <hr>
                                    <label>Select Type</label>
                                    <select class="form-control" name="type">
                                        @foreach(setTypes() as $t)
                                        @php($selected = $t == $currentSet->type ? 'selected' : '')
                                        <option class="form-control" {{$selected}} value="{{$t}}">
                                            {{$t}}</option>
                                        @endforeach
                                    </select>

                                    <button class="btn btn-primary mt-2">Submit</button>
                                </form>


                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header  border-bottom d-flex justify-content-between mb-1">
                                <h4 class="card-title text-capitalize">Set Languages</h4>
                                <div class="d-flex">
                                    <button class="btn btn-primary  px-1" data-bs-target="#languageModal" title="Add Language"  data-bs-toggle="modal">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                    <button class="btn btn-warning ms-1  px-1" data-bs-target="#editLanguageModal" title="Update Language"  data-bs-toggle="modal">
                                        <i class="fa fa-paint-brush" aria-hidden="true"></i>

                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                @if(count($currentSet->language) > 0)
                                @foreach ($currentSet->language as $language)
                                    <div class="col-md-2">
                                        <span class="badge bg-primary">{{$language->value}}</span>
                                    </div>
                                @endforeach
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header  border-bottom d-flex justify-content-between mb-1">
                                <h4 class="card-title text-capitalize">Set Legalities</h4>
                                <div class="d-flex">
                                    <button class="btn btn-primary px-1" data-bs-target="#legalityModal" title="Add Legalities"  data-bs-toggle="modal">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                    <button class="btn btn-warning ms-1  px-1" data-bs-target="#editLegalityModal" title="Update Legalities"  data-bs-toggle="modal">
                                        <i class="fa fa-paint-brush" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                @foreach (mtgSetLegality($currentSet->id) as $legality)
                                    <div class="col-md-2">
                                        <span class="badge bg-success text-capitalize">{{$legality}}</span>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@include('admin.mtg.sets.language.add');
@include('admin.mtg.sets.language.edit');
@include('admin.mtg.sets.legality.add');
@include('admin.mtg.sets.legality.edit');
@endsection

@push('js')
<script>
    $(document).ready(function () {
        $(document).on('change', '.sets', function () {
            let val = $(this).val();
            let lenghtt = $('.child-' + val).length;
            if (!val || lenghtt > 0) {
                return false;
            }
            let custom_type = $('.sets').select2().find(":selected").data("type");
            let name = $('.sets').select2().find(":selected").data("name");

            let html = `<tr class="child-${val}">
                                                <td>${name}</td>
                                                <td>
                                                <select class="form-control" name="custom_type[${val}]">
                                                @foreach($types as $type)
                                                <option class="form-control" value="{{$type->name}}">{{$type->name}}</option>
                                                @endforeach
                                                </td>
                                                <td><button class="close_row btn btn-danger"><i class="fa fa-trash"></button></td>
                                            </tr>`
            $('.append').prepend(html);
        })
        $(document).on('click', '.close_row', function () {
            $(this).closest('tr').remove();
        })
    })

</script>
@endpush
