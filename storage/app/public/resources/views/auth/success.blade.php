@extends('layouts.app')
@section('title','Welcome to VFS - Start Trading Cards Now!')
@section('description','Successfully registered with Very Friendly Sharks! Dive into the best UK card trading experience and start buying or selling today.')
@push('css')
<meta name="robots" content="noindex,follow">

@endpush
@section('content')

<section>
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12 text-center my-3">
                <img src="{{asset('images/home/success.jpg')}}" alt="">
                    <h1>Thank you.</h1>
                    <p class="lead w-lg-50 mx-auto">You have been registerd successfully.</p>
                    <a class="btn btn-site-primary" href="{{route('index')}}">Continue</a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('js')
<script>
    $(document).ready(function()
    {
        window.location.href = "/";
    })
</script>
@endpush
