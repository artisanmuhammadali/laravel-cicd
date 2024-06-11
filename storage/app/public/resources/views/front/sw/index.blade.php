@extends('layouts.app')
@section('title', $setting['swt_page_title'] ?? "")
@section('description', $setting['swt_page_meta'] ?? "")
@push('css')

@endpush
@section('content')
<style>

</style>
<div class="container-fluid px-0">
    <section>
        @include('front.components.breadcrumb')
    </section>
    @include('front.components.general.banner',['frontImage' => $setting['sw_banner_upper'] ?? null, 'backgroundImage' => $setting['sw_banner_background'] ?? null])
    <section>
        @include('front.components.buy-and-sell',['headingTag' => 'h1'])
    </section>
</div>
@endsection

@push('js')


@endpush
