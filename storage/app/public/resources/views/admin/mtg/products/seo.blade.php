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
                            <div class="card-header">
                                <h4>Seo</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('admin.mtg.products.store')}}" method="post" enctype="multipart/form-data" class="submit_form">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$item->id ?? ""}}">
                                    <div>
                                        <label>Product Name</label>
                                        <input class="form-control title_box" name="title" value="{{$item->name ?? ""}}" required type="text">
                                        <label>Title</label>
                                        <input class="form-control title_box" name="title" value="{{$item->seo->title ?? ""}}" required type="text">
                                        <label>Meta Description</label>
                                        <input class="form-control title_box" name="meta_description" value="{{$item->seo->meta_description ?? ""}}" required type="text">
                                        <label>Heading</label>
                                        <input class="form-control title_box" name="heading" value="{{$item->seo->heading ?? ""}}" required type="text">
                                        <label>Sub Heading</label>
                                        <input class="form-control title_box" name="sub_heading" value="{{$item->seo->sub_heading ?? ""}}" required type="text">
                                        <label>Weight</label>
                                        <input class="form-control title_box" name="weight" value="{{$item->weight ?? ""}}" required type="number">
                                        <label>Url Slug</label>
                                        <input class="form-control title_box" name="slug" value="{{$item->slug ?? ""}}" required type="text">
                                        <label>Set Code</label>
                                        <select name="set_code"  class="form-control select2">
                                            @foreach($sets as $set)
                                            <option class="form-control" value="{{$set->code}}" {{$set->code == $item->set_code ? "selected" : ""}}>{{$set->name}}</option>
                                            @endforeach
                                        </select>
                                        @if($item->card_type == "completed")
                                        <label>Rarity</label>
                                        <select name="rarity"  class="form-control select2">
                                            <option selected disabled>Select Rarity</option>
                                            @foreach(mtgCardsRarity() as $rarity)
                                            <option class="form-control" value="{{$rarity}}" {{$rarity == ucfirst($item->rarity) ? "selected" : ""}}>{{$rarity}}</option>
                                            @endforeach
                                        </select>
                                        @endif
                                        @if($item->card_type == "sealed")
                                        <label>Image</label>
                                        <input type="file" class="form-control title_box dropify" name="image"  accept=".png, .jpg, .jpeg, .gif, .svg" data-default-file="{{$item->png_image}}">
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Update">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header  border-bottom d-flex justify-content-between mb-1">
                                <h4 class="card-title text-capitalize">Card Languages</h4>
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
                            @if($item->card_languages)
                                @foreach ($item->card_languages as $key => $language)
                                    <div class="col-md-2">
                                        <span class="badge bg-primary">{{$language}}</span>
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
                                <h4 class="card-title text-capitalize">Card Legalities</h4>
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
                                @if($item->legalities)
                                    @foreach (json_decode($item->legalities) as $key =>$legality)
                                    @if($legality == "legal")
                                        <div class="col-md-2">
                                            <span class="badge bg-success text-capitalize">{{$key}}</span>
                                        </div>
                                    @endif
                                    @endforeach
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </section>
        </div>
    </div>
</div>
@include('admin.mtg.products.language.add');
@include('admin.mtg.products.language.edit');
@include('admin.mtg.products.legality.add');
@include('admin.mtg.products.legality.edit');
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
