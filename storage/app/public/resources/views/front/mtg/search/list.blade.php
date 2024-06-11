@extends('layouts.app')
@section('title','Search Result')
@section('description', "Find and Trade MTG Singles, Sealed Products, and Complete Sets. Explore the UK's Exclusive Card Market Now!")
@push('css')
<link href="{{asset('front/styles/tagify.css')}}" rel="stylesheet">
@endpush
@section('content')
<div class="container-fluid px-0">
    <section>
        <div class="product-section">
            <div>
                <div class="filter-section mt-5">
                    <div class="container">
                        @include('front.components.expansionTabHeader',['detailSearch' => 'true'])
                    </div>
                </div>
                <section class="append_cards">
                   @include('front.mtg.expansion.components.expansionTabs')
                </section>
            </div>
    </section>
</div>
@endsection
@push('js')
@include('front.mtg.expansion.components.searchScript')
@endpush
