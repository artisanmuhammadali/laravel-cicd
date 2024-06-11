
@extends('layouts.app')
@section('title','Servey Completed')
@section('description','')
@push('css')
@endpush
@section('content')
<style>

</style>
<div class="container-fluid px-0">
    <section>
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-12 text-center my-3">
                    <img src="{{asset('images/home/success.jpg')}}" alt="">
                        <h1>Hello {{auth()->user()->full_name}}</h1>
                        <p class="lead w-lg-50 mx-auto"> Thank you for applying to our seller's programme, you will be contacted via email in the next few days to let you know if the application has been successful.</p>
                        <a class="btn btn-site-primary" href="{{route('index')}}">Continue</a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection


@push('js')
@endpush