@extends('layouts.app')
@section('title', $setting['home_title'] ?? "")
@section('description', $setting['home_meta'] ?? "")
@push('css')
<link rel="stylesheet" href="{{ asset('Owl_carousel/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('Owl_carousel/css/owl.theme.default.min.css') }}">
<style>
    .owl-carousel .owl-item img{
        object-fit: contain !important;
    }
</style>
@endpush
@section('content')

<div class="">
   <section>
        <div class="welcome-section mt-2 pb-5 d-none d-md-block">
            <div class="container">
                <div class="row justify-content-center pt-md-5 pt-0">
                    <div class="col-12 d-flex justify-content-center d-none d-md-block text-center">
                        <img width="200" loading="lazy" alt="welcome logo" src="{{$setting['logo'] ?? ""}}">
                    </div>
                    <div class="col-12 text-center mt-4">
                        <h1 class="text-site-primary Welcome-Friendly pro_range_heading_2_area">{{$setting['pro_range_heading_2'] ?? ""}}</h1>
                    </div>
                    <div class="col-12 text-center my-3">
                        <h2 class="collectible_card pro_range_heading_2_btm_area">{{$setting['pro_range_heading_2_btm'] ?? ""}}</h2>
                    </div>
                    <div class="col-12 text-center pro_range_pg_context_area">
                        <p class="text-center">{{$setting['pro_range_pg_context'] ?? ""}}</p>
                        <a href="{{$setting['pro_range_learnLink'] ?? ""}}" class="btn btn-site-primary mt-2 fs-5 px-3 pro_range_learn_area" title="{{$setting['pro_range_learn'] ?? ""}}">{{$setting['pro_range_learn'] ?? ""}}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="artical_section launching-in-visibility_area">
        <div class="container {{$setting['launching-in-visibility'] ?? ''}}">
            <div class="row justify-content-center text-center artical_section">
                @if(vfsWebConfig() == false)
                <div class="col-md-12 ">
                    <h4 class="text-site-primary Welcome-Friendly my-5 launching-in-heading_area">{{$setting['launching-in-heading'] ?? ""}}</h4>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="count-box bg-dark-blue text-white border-site-primary border p-4 rounded-site">
                        <h4 class="count-text fw-bold pro_range_learn_area" id="days">1</h4>
                        <p class="mb-2">Days</p>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="count-box bg-dark-blue text-white border-site-primary border p-4 rounded-site">
                        <h4 class="count-text fw-bold " id="hours">1</h4>
                        <p class="mb-2">Hours</p>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="count-box bg-dark-blue text-white border-site-primary border p-4 rounded-site">
                        <h4 class="count-text fw-bold " id="minutes">1</h4>
                        <p class="mb-2">Minutes</p>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="count-box bg-dark-blue text-white border-site-primary border p-4 rounded-site">
                        <h4 class="count-text fw-bold " id="seconds">1</h4>
                        <p class="mb-2">Seconds</p>
                    </div>
                </div>
                @endif
                <div class="col-md-10 text-white my-3 my-md-5">
                    <p class="fs-5 referal-guide-text launching-in-text_area product-listing-mobile-text">{{$setting['launching-in-text'] ?? ""}}
                    Find out more <a href="{{getPagesRoute('referral-faqs')}}">here</a>.
                    **Very Friendly Sharks <a href="{{getPagesRoute('terms-conditions')}}">Terms and conditions</a> apply.</p>
                </div>
            </div>
        </div>
    </section>
    <section>
        @include('front.components.buy-and-sell')
    </section>

</div>
<input type="hidden" id="launching-timer-date" value="{{launchingTimer() ?? '2024-02-01'}}">
@endsection

@push('js')
@if(vfsWebConfig() == false)
<script>
    $( document ).ready(function() {
        countdownCounter();
    });
    function countdownCounter(){
        const second = 1000, minute = second * 60, hour = minute * 60, day = hour * 24;
        let today = new Date(),
        dd = String(today.getDate()).padStart(2, "0"),
        mm = String(today.getMonth() + 1).padStart(2, "0"),
        yyyy = today.getFullYear(),
        nextYear = yyyy + 1,
        dayMonth = "10/30/",
        birthday = $('#launching-timer-date').val();


        const countDown = new Date(birthday).getTime(),
            x = setInterval(function() {    

            const now = new Date().getTime(),
            distance = countDown - now;

            document.getElementById("days").innerText = Math.floor(distance / (day)),
            document.getElementById("hours").innerText = Math.floor((distance % (day)) / (hour)),
            document.getElementById("minutes").innerText = Math.floor((distance % (hour)) / (minute)),
            document.getElementById("seconds").innerText = Math.floor((distance % (minute)) / second);
        }, 0)
    }
</script>
@endif
<script src="{{ asset('Owl_carousel/js/owl.carousel.min.js') }}"></script>
<script>
    $('.owl-carousel-product-line').owlCarousel({
        loop: true,
        margin: 10,
        dots: false,
        nav: false,
        items: 4,
        slideBy: 4,
        autoplay: true,
        // autoplayTimeout: 10000,
        autoplayHoverPause: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            768: {
                items: 3
            },
            1025: {
                items: 4
            }
        }
    })
</script>

@endpush
