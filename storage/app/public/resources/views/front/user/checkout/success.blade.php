@extends('layouts.app')
@section('title','Thank You')
@push('css')
@endpush
@section('content')

<section>
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12 text-center my-3">
                <img src="{{asset('images/home/success.jpg')}}" alt="">
                    <h1>Thank you.</h1>
                    <p class="lead w-lg-50 mx-auto">Your order has been placed successfully.</p>
                    <p class="w-lg-50 mx-auto">View your <a class="hover-blue" href="{{route('user.order.index',['buy','pending'])}}">order</a>. We have notified the seller and they will immediately process your order.</p>
            </div>
        </div>
    </div>
</section>

@endsection

@push('js')

@endpush
