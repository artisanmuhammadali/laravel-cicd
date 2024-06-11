@extends('admin.layout.app')
@section('title','Dashboard')
@push('css')
<style>
    .scroll-submit {
        display: inline-block;
        position: fixed;
        bottom: 5%;
        right: 30px;
        z-index: 99;
    }
    .hover_image{
    position: absolute;
    z-index: 9;
}
</style>
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
                            <h3 class="px-2 pt-2">
                                Apply Attributes
                            </h3>
                            <div class="card-body">
                                <div class="row w-100">
                                    <div class="col-md-3">
                                        <div class="w-100">
                                            <select name="set_id" class="form-control get_products select2 w-100 set_select">
                                                <option class="form-control" value="" selected disabled>Select Set</option>
                                                @foreach($sets as $set)
                                                <option value="{{$set->code}}">{{$set->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="w-100">
                                            <select name="rarity" class="form-control  select2 w-100 rarity">
                                                <option class="form-control" value="" selected disabled>Select Rarity</option>
                                                @foreach(mtgCardsRarity() as $r)
                                                <option value="{{$r}}">{{$r}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="w-100">
                                            <input name="from_number" class="from_number form-control check_set" disabled value="" placeholder="From Collector Number">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="w-100">
                                            <input name="to_number" class="to_number form-control check_set" disabled value="" placeholder="To Collector Number">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="w-100">
                                            <input name="collector_symbol" class="collector_symbol form-control check_set" disabled value=""  placeholder="Collector Symbol">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-primary filter_card_btn" type="button"  title="Filter" >Filter</button>
                                    </div>
                                </div>


                                <hr>

                                <div class="append_products">

                                </div>
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
<script src="{{asset('admin/js/dragcheck.js')}}"></script>
<script type="text/javascript">
    $(document).on('click', '.filter_card_btn', function () {
        let code = $('.get_products').val();
        let rarity = $('.rarity').val();
        let from_number = $('.from_number').val();
        let to_number = $('.to_number').val();
        let symbol = $('.collector_symbol').val();
        $.ajax({
            type: "GET",
            data: {
                code: code,rarity:rarity, from_number:from_number,to_number:to_number,symbol:symbol
            },
            url: "{{route('admin.mtg.cards.append.products')}}",
            success: function (response) {
                $('.append_products').html(response.html)
                $('table tbody').dragcheck({
                    container: 'tr', // Using the tr as a container
                    onSelect: function (obj, state) {
                        obj.prop('checked', state);
                    }
                });
            },
        });
    })

$(document).on('change','.set_select',function(){
    $(".check_set").prop('disabled', false);
})
$(document).on('change','.select_all',function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
})

$(document).on('mouseenter','.hover_imgBtn',function(){
    $(this).closest("div").find(".hover_image").removeClass('d-none');
    $(this).closest("div").find(".hover_image").css("left", 50).css("top",0);
});
$(document).on('mouseleave','.hover_imgBtn',function(){
    $(this).closest("div").find(".hover_image").addClass('d-none');
});
</script>

@endpush
