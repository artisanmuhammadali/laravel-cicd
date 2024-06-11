<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="magic the gathering, card market, mtg, trading cards, very friendly sharks, vfs mtg, vfs uk, vfs, magic the gathering cards, magic card market, magic singles, mtg cards, mtg singles uk, uk mtg singles, sell mtg cards uk, buy mtg cards uk">
    <title>Invite Friends, Earn Rewards - Join Very Friendly Sharks' Referral Program</title>
    <meta name="description" content="Share the Love of Card Trading - Refer Friends and Get Rewarded for Every Purchase. Join Now!">
    <meta name="robots" content="noindex,follow">
    <link rel="icon" type="image/x-icon" href="{{$setting['favicon'] ?? ''}}" />
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans:300,400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite('resources/css/app.scss')
    <style>
    .bg-cards-img{
        background-image:linear-gradient(rgba(33, 48, 86, 1), rgba(0, 0, 0, 0.5)), url("images/magic/component/Rectangle(1).png");
    }
    </style>
     @stack('css')
    @vite('resources/css/app.scss')
</head>
<body class="font-sans antialiased">
    <div class="row bg_dark_shark m-0">
        <div class="col-12 p-0">
            <nav class="navbar navbar-expand-lg nav-border p-0">
                <div class="container">
                    <a class=" navbar-brand pe-md-5 me-md-4" href="{{route('index')}}"><img width="150"
                            src="{{asset('images/banner/logo/horizontallogo1.png')}}"></a>
                    <a class="nav-link text-white hide-on-large" href="#"><img class="icshoppingCartOff"
                            src="{{asset('images/banner/ic-shopping-cart-off@2x.png')}}" alt=""></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
                        <ul class="navbar-nav  mb-2 mb-lg-0 justify-content-end">
                            <li class="nav-item px-4">
                                <a class="nav-link nav-light-text fw-lighter md-text" href="{{route('index')}}">Homepage</a>
                            </li>
                            <li class="nav-item pe-4">
                                <a class="nav-link nav-light-text fw-lighter md-text" href="{{route('help')}}">Help</a>
                            </li>
                            @if(auth()->user())
                            <li class="nav-item px-4">
                                <a href="{{route('user.account')}}" class="nav-link nav-url nav-light-text fw-lighter md-text">Account</a>
                            </li>
                            <li class="nav-item px-2">
                                <form method="POST" action="{{route('logout')}}">
                                    @csrf
                                    <button class="nav-link nav-url nav-light-text fw-lighter md-text"  type="submit">Logout</button>
                                </form>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <div class="container-fluid px-0">
        <section>
            <div class="welcome-section mt-md-5 pb-md-5 ">
                <div class="container">
                    <div class="row justify-content-center pt-3">
                        <div class="col-12 d-flex justify-content-center ">
                            <img width="200" loading="lazy" alt="welcome logo" src="{{$setting['logo'] ?? ""}}">
                        </div>
                        <div class="col-12 text-center mt-4">
                            <h1 class="text-site-primary Welcome-Friendly pro_range_heading_2_area">{{$setting['pro_range_heading_2'] ?? ""}}</h1>
                        </div>
                        <div class="col-12 text-center my-3">
                            <h4 class="collectible_card pro_range_heading_2_btm_area">{{$setting['pro_range_heading_2_btm'] ?? ""}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section>
            <div class="container">
                <div class="row justify-content-center mt-3 mb-5">
                    
                    <div class="col-md-8 regForm shadow_site p-md-5 p-3" id="registartion">
                        <h3 class="text-site-primary text-center fs-1 fw-bold mb-3">Registration</h3>
                        @include('front.components.register')
                    </div>
                </div>
            </div>
        </section>
        <section class="artical_section launching-in-visibility_area">
            <div class="container {{$setting['launching-in-visibility'] ?? ''}}">
                <div class="row justify-content-center text-center artical_section">
                    <div class="col-md-12 ">
                        <h4 class="text-site-primary Welcome-Friendly my-5 launching-in-heading_area">{{$setting['launching-in-heading'] ?? ""}}</h4>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="count-box bg-dark-blue text-white border-site-primary border p-4 rounded-site">
                            <h3 class="count-text fw-bold pro_range_learn_area" id="days">1</h3>
                            <p class="mb-2">Days</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="count-box bg-dark-blue text-white border-site-primary border p-4 rounded-site">
                            <h3 class="count-text fw-bold " id="hours">1</h3>
                            <p class="mb-2">Hours</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="count-box bg-dark-blue text-white border-site-primary border p-4 rounded-site">
                            <h3 class="count-text fw-bold " id="minutes">1</h3>
                            <p class="mb-2">Minutes</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="count-box bg-dark-blue text-white border-site-primary border p-4 rounded-site">
                            <h3 class="count-text fw-bold " id="seconds">1</h3>
                            <p class="mb-2">Seconds</p>
                        </div>
                    </div>
                    <div class="col-md-10 text-white my-5">
                        <p class="fs-5 referal-guide-text launching-in-text_area">{{$setting['launching-in-text'] ?? ""}}
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

    <footer class="footer_section">
        <div class="container">
            @include('front.include.footer')
        </div>
    </footer>
    @include('front.modals.login')
    @include('front.modals.expPageFilter')
    @vite(['resources/js/app.js', 'resources/js/custom.js'])
    <script type="module">
    $( document ).ready(function() {
        loadRecaptcha()
        countdownCounter();
    });
    @if(vfsWebConfig() == false)
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
    @else
        function countdownCounter(){
            const second = 1000, minute = second * 60, hour = minute * 60, day = hour * 24;
            let today = new Date(),
            dd = String(today.getDate()).padStart(2, "0"),
            mm = String(today.getMonth() + 1).padStart(2, "0"),
            yyyy = today.getFullYear(),
            nextYear = yyyy + 1,
            dayMonth = "10/30/",
            birthday = '2024-04-10';


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
    @endif
    function loadRecaptcha() {
        var script = document.createElement('script');
        script.src = 'https://www.google.com/recaptcha/api.js';
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);
    }
    $(document).on('click','.showRegForm',function(){
        $('.regForm').removeClass('d-none');
    })
    $(document).on('click','.pagescroll',function(){
        $('body,html').animate({ scrollTop: 1000 }, 1000);
    })
    </script>
    @vite(['resources/js/app.js', 'resources/js/custom.js'])

</body>
</html>


