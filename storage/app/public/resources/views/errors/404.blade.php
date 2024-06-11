@extends('layouts.app')
@section('title', "Page Not Found")
@push('css')
@endpush
@section('content')
<div class="section text-center my-5">
    <h1 class="error">404</h1>
    <div class="page">Ooops!!! The page you are looking for is not found</div>
    <a class="back-home" href="{{route('index')}}">Back to home</a>
</div>

@endsection

@push('js')

@endpush
