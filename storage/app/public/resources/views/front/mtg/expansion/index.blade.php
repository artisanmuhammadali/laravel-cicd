@extends('layouts.app')
@section('title', 'Expansion Sets | Magic The Gathering | VFS Card Market')
@push('css')
@endpush
@section('content')
<div class="container-fluid px-0">
    <section>
        @include('front.components.breadcrumb')
    </section>
      
    <section>
        <div class="col-12 text-center mt-md-5">
            <h1 class="text-site-primary Welcome-Friendly">Choose Your MTG Expansion or Set</h1>
        </div>
        <div class="filter-section mt-md-5 pb-3">
            <div class="container ">
                <div class="row shadow_site py-3 d-flex align-items-center">
                    <div class="col-lg-4  me-auto d-flex align-items-center mb-lg-0 mb-2">
                        <div class="input-group input-group-lg ">
                            <div class="input-group rounded-0">
                                <input class="form-control form-select-lg  border border-site-primary rounded-0 border-end-0 expansionSearch input-text" type="text" placeholder="Search" aria-label="Search">
                                <span class="input-group-text border-site-primary bg-white border-start-0 rounded-0" id="basic-addon2">
                                    <i class="fa fa-times expSearchCross d-none" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 mb-lg-0 mb-2 ps-lg-0">
                        <select class="form-select form-select-lg border border-site-primary rounded-0 input-text" id="parameter" aria-label="Default select example">
                            <option class="form-control" value="released_at">Release Date</option>
                            <option class="form-control" value="name">Alphabetical</option>
                            <option class="form-control" value="legality" data-url="{{route('mtg.expansion.index')}}">Legality</option>
                        </select>
                    </div>
                    <div class="col-lg-3 mb-lg-0 mb-2 ps-lg-0">
                        <select class="form-select form-select-lg border border-site-primary rounded-0 text-capitalize input-text" id="alignment" aria-label="Default select example">
                            <option class="form-control" value="desc">Descending</option>
                            <option class="form-control" value="asc">Ascending</option>
                        </select>
                    </div>
                    <div class="col-lg-2 text-end ps-lg-0">
                        <button class="btn btn-site-primary btn-lg rounded-0 reset_legality_filter w-100 input-text">Reset</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="expansion-section pb-5">
            <div class="container renderExpansions">
                @include('front.mtg.expansion.components.expList')
            </div>
        </div>
    </section>
</div>


@endsection

@push('js')

<script>
    $(document).ready(function(){
        PgExpReleaseDateSorting('desc');
    })
    function PgExpReleaseDateSorting(align) {
        var expUl = $(".expSet");
        var spUl = $(".spSet");

        var listExp = expUl.find("li:gt(0)");
        var listSp = spUl.find("li:gt(0)");
        PgReleaseDateSorting(listExp, expUl, align);
        PgReleaseDateSorting(listSp, spUl, align);
    }
    // sorting expansion according to release date
    function PgReleaseDateSorting(list, ul, align) {
        list.sort(function (a, b) {
            var a = $(a).attr("data-date"),
                b = $(b).attr("data-date");
            if (align == "asc") {
                return new Date(a) - new Date(b);
            } else {
                return new Date(b) - new Date(a);
            }
        }).appendTo(ul);
    }

    // format legality filter
    let endpoint = '{{url()->full()}}';
    let url = '{{url()->full()}}';
    let format1 = '';
    $(document).on('click', '.apply_legality_filter', function () {
        format1 = $('.format1').val();
        legalityFilter(format1)
    })
    $(document).on('click', '.reset_legality_filter', function () {
        format1 = "";
        legalityFilter(format1)
    })

function legalityFilter(format1)
{
    url = url.split('?')[0];
    
    $.ajax({
        type: "GET",
        data: {
            format1: format1,
        },
        url: url,
        success: function (response) {
            $('.renderExpansions').html(response.html)
        PgExpReleaseDateSorting('desc');

        },
    });
}
</script>
@endpush
