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
                                <h4>Create {{ucfirst($type)}} Product</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('admin.mtg.products.single.sard.save')}}" method="post" enctype="multipart/form-data" class="submit_form">
                                @csrf
                                    <input type="hidden" name="card_type" class="card_type" value="{{$type}}">
                                    <input type="hidden" name="is_arrival" class="is_arrival" value="{{$type2}}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Name</label>
                                            <input class="form-control card_name required" name="name"  type="text">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Set Name</label>
                                            <select name="set_name"  class="form-control select2 set_name required">
                                                <option class="from-conrtol" value="">Select one..</option>
                                                @foreach($sets as $set)
                                                <option class="form-control" value="{{$set->name}}" >{{$set->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if($type == "sealed")
                                        <div class="col-md-6">
                                            <label>Type</label>
                                            <select name="other_card_type"  class="form-control select2 other_card_type required">
                                                <option class="from-conrtol" value="">Select one..</option>
                                                @foreach(mtgSealedTypes() as $selaledType)
                                                <option class="form-control" value="{{$selaledType}}" >{{$selaledType}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @else
                                        <div class="col-md-6">
                                            <label>Rarity</label>
                                            <select name="rarity"  class="form-control select2 required">
                                                <option class="from-conrtol" value="">Select one..</option>
                                                @foreach(mtgCardsRarity() as $rarity)
                                                <option class="form-control" value="{{$rarity}}" >{{$rarity}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif
                                        <div class="col-md-6">
                                            <label>Weight</label> 
                                            <input class="form-control required" name="weight" type="number">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>
                                                Title
                                                (<span class="title_length">0</span>)
                                            </label>
                                            <input class="form-control card_title required" name="title"  type="text">
                                            <span class="badge badge-light-warning w-100">
                                                <i class="fa fa-exclamation-triangle me-75" aria-hidden="true"></i>
                                                Optimal Title character length should be 70 
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Heading</label>
                                            <input class="form-control card_heading required" name="heading"  type="text">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Sub Heading</label>
                                            <input class="form-control card_subheading required" name="sub_heading"  type="text">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Url Slug</label>
                                            <input class="form-control card_slug required" name="slug"  type="text">
                                        </div>
                                        <div class="col-md-12">
                                            <label>
                                                Meta Description
                                                (<span class="meta_length">0</span>)
                                            </label>
                                            <textarea class="form-control card_meta required" name="meta_description" ></textarea>
                                            <span class="badge badge-light-warning w-100">
                                                <i class="fa fa-exclamation-triangle me-75" aria-hidden="true"></i>
                                                Optimal Meta Description character length should be 156 
                                            </span>
                                        </div>
                                        @if($type == "sealed")
                                        <div class="col-md-12">
                                            <label>Image</label>
                                            <input type="file" class="form-control dropify required" name="png_img"  accept=".png, .jpg, .jpeg, .gif, .svg">
                                        </div>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Create">Create</button>
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
<script>
    var string = '';
    var title = '';
    var heading = '';
    var subheading = '';
    var slug = '';

    $(document).on('change','.other_card_type , .set_name',function(){
        createCardSeo();
    })
    $(document).on('keyup','.card_name',function(){
        createCardSeo();
    })
    function createCardSeo()
    {
        var set_name = $('.set_name').val();
        var card_name = $('.card_name').val();
        var card_type = $('.card_type').val();
        var other_cards_type =$('.other_card_type').val();

        var metaArr = {
            'sealed':' products today ',
            'completed':'',
        };
        var titleArr = {
            'sealed' : 'MTG Sealed Products',
            'completed' : set_name,
        };
        var subHaedArr = {
            'sealed':"Browse MTG Sealed Products To Buy and Sell "+other_cards_type +" Products & More",
            'completed':"Browse MTG Complete Sets To Buy and Sell Your Magic The Gathering Cards",
        };
        var meta = "Buy & sell " + set_name+ ' '+  metaArr[card_type] +" on our UK-Only card market, today! Very Friendly Sharks is easy to use, with the best prices online.";
        if (meta.length > 156) {
            var meta = "Buy & sell " +set_name+ " "+ metaArr[card_type] +" on our UK-Only card market, today! Very Friendly Sharks is easy to use, trusted & safe.";
        }
        if (meta.length > 156) {
            var meta = "Buy & sell " + set_name+ " "+ metaArr[card_type] +" on our UK-Only card market, today! Very Friendly Sharks is easy to use.";
        }
        if (meta.length > 156) {
            var meta = "Buy & sell " + set_name+ " "+ metaArr[card_type] +" on our UK-Only card market, today!";
        }

        string = card_name+" | "+titleArr[card_type]+" | VFS Card Market";
        var card_title = string;
        title =card_title.replace(/   /g, ' ');
        $('.title_length').text(title.length);
        $('.meta_length').text(meta.length);
        heading = card_name;
        subheading = subHaedArr[card_type];
        slug = createSlug(card_name);

        $('.card_title').val(title);
        $('.card_heading').val(heading);
        $('.card_subheading').val(subheading);
        $('.card_meta').val(meta);
        $('.card_slug').val(slug);
    }
    function stringToShort(input,limit)
    {
        while (input.length > limit) {
            words = input.split(' ');
            words.pop();
            input = words.join('');
        }
        return input.replace(/[ \t\n\r\0\x0B!@#$%^&*()_+[\]{}|;':,./<>?\\"]/g, ' ');
    }
    function createSlug(input) {
        var slug = input.toLowerCase().replace(/\s+/g, '-');
        slug = slug.replace(/[^\w-]/g, '');
        return slug;
    }

</script>
@endpush
