@extends('layouts.app')
@section('title','Expansion')
@push('css')
@endpush
@section('content')

<div class="container-fluid px-0">
        <section>
            <div class="filter-section mt-5">
                <div class="container ">
                @include('front.components.expansionTabHeader')
                </div>
            </div>
        </section>
        <section class="append_cards">
        @include('front.mtg.expansion.components.expansionTabs')
    </section>
</div>

@endsection

@push('js')
@include('front.mtg.expansion.components.searchScript')
@endpush
