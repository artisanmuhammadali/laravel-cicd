@extends('layouts.app')
@section('title',$seo->title ?? "")
@section('description',$seo->meta_description ?? "")
@push('css')
@endpush
@section('content')

<div class="container-fluid px-0">
    @if(isset($set->banner))
        @include('front.components.sw.set.has-banner',['detail'=>$seo ?? $set , 'banner'=>$set->banner])
    @else
        @include('front.components.sw.set.no-banner',['detail'=>$seo ?? $set])
    @endif
    

    {{-- for single cards --}}
    @if(isset($list[0]))
        @if($list[0]->card_type == "single")
        <section>
            <div class="filter-section mt-5">
                <div class="container ">
                @include('front.components.expansionTabHeader')
                </div>
            </div>
        </section>
        <section class="append_cards">
            @include('front.sw.expansion.components.expansionTabs')
        </section>
        @else
        <section>
            <div class="product-section">
                <div class="container">
                    <div class="row py-5">
                        @foreach($list as $item)
                            @include('front.components.sw.'.$list[0]->card_type.'.card',['item'=>$item])
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
@include('front.sw.expansion.components.searchScript')
@endpush
