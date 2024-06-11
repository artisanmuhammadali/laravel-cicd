@extends('layouts.app')
@section('title',$page->title)
@section('description',$page->meta_description)
@push('css')

@endpush
@section('content')
<div class="container  my-5">
    <div class="row">
        @if($page->contents->count() > 0)
        {{--<div class="col-12 d-md-block d-lg-none">
            <div class="scroll_div">
                <select class="form-control table_of_contents_list_i form-select">
                    <option>select</option>
                    @foreach($page->contents as $c)
                    <option data-idd="#tar{{$c->id}}">{{$c->content}}</option>
                    @endforeach
                </select>
            </div>
        </div>
            --}}
        <div class="col-md-3 d-md-none d-lg-block">
            <div class="table_of_contents table_of_contents_list theme-border mx-0 px-4 pt-3 bg-gry">
                <h5 class="text-center theme-text">Table of Contents</h5>

                @foreach($page->contents as $c)
                <li class="fw-bold"><a href="#tar{{$c->id}}" data-target="{{$c->link}}"
                        data-idd="tar{{$c->id}}">{{$c->content}}</a>
                </li>
                @endforeach
            </div>
        </div>

        @endif
        @php($col = $page->contents->count() > 0 ? 9 : 12)
        <div class="content_body ck_fix col-12 col-lg-{{$col}}">
            {!! $page->content !!}
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
    $(document).ready(function () {
        $('.accordion-collapse, .my_accordion_collapse').removeClass('accordion_show');
        // $('.accordion-collapse, .my_accordion_collapse').addClass('accordion_show');
    });

     $(document).on('click','.my_accordion',function () {
        // let that = $(this).nextAll(".my_accordion_collapse").first();
        // if(!that.hasClass('accordion_show'))
        // {
        //     alert(12);
        //     that.addClass('accordion_show');
        //     that.removeClass('accordion_hide');
        // }
        // else
        // {
        //     alert(222);
        //     that.removeClass('accordion_show');
        //     that.addClass('accordion_hide');
        // }
         $(this).nextAll(".my_accordion_collapse").first().toggleClass('accordion_show');
     });
    @if($bar)

    $(document).ready(function () {
        $('.accordion-collapse').removeClass('show');
        // Function to add id="one" attribute to elements containing specific text
        function addIdToMatchingText(textToMatch, idToAdd) {
            // Traverse all elements in the document
            $('.content_body').find('*').contents().filter(function () {
                return this.nodeType === 3 && this.textContent.includes(textToMatch);
            }).each(function () {
                // Add id="one" attribute to the immediate parent element of the matched text
                $(this).parent().attr('id', idToAdd);
            });
        }

        $('.table_of_contents_list a').each(function () {
            let tex = $(this).data('target');
            let idd = $(this).data('idd');
            addIdToMatchingText(tex, idd);
        });
        // Call the function with the specific text to match and the id to add
    });
    @endif

    $(document).on('change', ".table_of_contents_list_i", function () {
        let idd = $('option:selected', this).data('idd');
        $('html, body').scrollTop($(idd).offset().top);
    });

</script>
@endpush
