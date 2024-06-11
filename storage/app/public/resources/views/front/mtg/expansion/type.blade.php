@extends('layouts.app')
@section('title',$seo->title ?? "")
@section('description',$seo->meta_description ?? "")
@push('css')
@endpush
@section('content')

<div class="container-fluid px-0">
    @if(isset($main_set->banner))
        @include('front.components.set.has-banner',['detail'=>$seo , 'banner'=>$main_set->banner])
    @else
        @include('front.components.set.no-banner',['detail'=>$seo])
    @endif

    {{-- for single cards --}}
    @if(isset($list[0]))
    @if($list[0]->card_type == "single")
    <section>
        <div class="filter-section mt-md-5 mt-2">
            <div class="container ">
            @include('front.components.expansionTabHeader')
            </div>
        </div>
    </section>
    <section class="append_cards">
        @include('front.mtg.expansion.components.expansionTabs')
    </section>
    @else
    <section>
        <div class="product-section">
            <div class="container">
                <div class="row py-5">
                    @foreach($list as $item)
                        @include('front.components.'.$list[0]->card_type.'.card',['item'=>$item])
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    @endif
</div>

@endsection

@push('js')

@include('front.mtg.expansion.components.searchScript')
@endpush
