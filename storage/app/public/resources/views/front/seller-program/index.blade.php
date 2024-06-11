
@extends('layouts.app')
@section('title',"Join the Elite VFS Seller's Programme Today!")
@section('description','Unlock exclusive rewards and join a community of top-tier 
Magic: the Gathering sellers on Very Friendly Sharks. Limited slots available – 
apply now!')

@push('css')<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
/>
<style>
    .back_ground_image{
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover; 
        background-color: black;
        background-image: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("../../public/../images/home/2024-05-13-Sellers-Program-Banner-3.png");
    
    }

    .circle {
        font-weight: bold;
        padding: 15px 20px;
        border-radius: 50%;
        background-color: #96670E;
        color: #ffff;
        max-height: 50px;
        z-index: 2;
    }

    .how-it-works.row {
        display: flex;
    }

    .how-it-works.row .col-2 {
        display: inline-flex;
        align-self: stretch;
        align-items: center;
        justify-content: center;
    }

    .timeline div {
        padding: 0;
        height: 40px;
    }

    .timeline hr {
        border-top: 3px solid #96670E;
        margin: 0;
        top: 17px;
        position: relative;
    }

    .timeline .col-2 {
        display: flex;
        overflow: hidden;
    }

    .timeline .corner {
        border: 3px solid #96670E;
        width: 100%;
        position: relative;
        border-radius: 15px;
    }

    .timeline .top-right {
        left: 50%;
        top: -51%;
    }

    .timeline .left-bottom {
        left: -50%;
        top: calc(50% - 3px);
    }

    .timeline .top-left {
        left: -50%;
        top: -51%;
    }

    .timeline .right-bottom {
        left: 50%;
        top: calc(50% - 3px);
    }
    hr {
        margin: 1rem 0;
        color: inherit;
        border: 0;
        border-top: var(--bs-border-width) solid;
        opacity: inherit !important;
    }
    .view-100 {
        height: 100vh !important;
    }

    *{padding: 0; margin: 0; box-sizing: border-box;}
/* body{height: 900px;} */
header {
    background-image: linear-gradient( rgba(0, 0, 0, 0.5), hsla(0, 0%, 0%, 0.5)), url("../../public/../images/home/2024-05-13-Sellers-Program-Banner-3.png");
	text-align: center;
	width: 100%;
	height: auto;
	background-size: cover;
	background-attachment: fixed;
	position: relative;
	overflow: hidden;
	border-radius: 0 0 85% 85% / 15%;
}
header .overlay{
	width: 100%;
	height: 100%;
	padding: 50px;
	color: #FFF;
	text-shadow: 1px 1px 1px #333;
  /* background-image: linear-gradient( 135deg, #9f05ff69 10%, #fd5e086b 100%); */
	
}

h1 {
	/* font-family: 'Dancing Script', cursive; */
	font-size: 80px;
	margin-bottom: 30px;
}

h3, p {
	/* font-family: 'Open Sans', sans-serif; */
	margin-bottom: 30px;
}

button {
	border: none;
	outline: none;
	padding: 10px 20px;
	border-radius: 50px;
	color: #333;
	background: #fff;
	margin-bottom: 50px;
	box-shadow: 0 3px 20px 0 #0000003b;
}
button:hover{
	cursor: pointer;
}



#quote_one {
  color: #fff;
  font-size: 24px;
  padding: 20px 30px;
  width: 400px;
  height: 280px;
  background: #001d35;
  -moz-border-radius: 30px;
  -webkit-border-radius: 30px;
  border-radius: 30px;
  position: relative;
}

#quote_one:before {
  content: '';
  background: inherit;
  z-index: -1;
  position: absolute;
  height: 13%;
  width: 13%;
  bottom: 25%;
  left: 100%;
  -moz-border-radius-bottomright: 100% 60%;
  -webkit-border-bottom-right-radius: 100% 60%;
  border-bottom-right-radius: 100% 60%;
}
#quote_one:after {
  content: '';
  background: #fff;
  z-index: -1;
  position: absolute;
  height: 16%;
  width: 16%;
  bottom: 30%;
  left: 99%;
  -moz-border-radius-bottomright: 100% 60%;
  -webkit-border-bottom-right-radius: 100% 60%;
  border-bottom-right-radius: 100% 60%;
  -moz-transform: rotate(25deg);
  -ms-transform: rotate(25deg);
  -webkit-transform: rotate(25deg);
  transform: rotate(25deg);
}
#quote_two {
  color: #fff;
  font-size: 24px;
  padding: 20px 30px;
  width: 400px;
  height: 280px;
  background: #001d35;
  -moz-border-radius: 30px;
  -webkit-border-radius: 30px;
  border-radius: 30px;
  position: relative;
}
#quote_two:before {
  transform: scaleX(-1);
  content: '';
  background: inherit;
  z-index: -1;
  position: absolute;
  height: 13%;
  width: 13%;
  bottom: 25%;
  right: 100%;
  -moz-border-radius-bottomright: 100% 60%;
  -webkit-border-bottom-right-radius: 100% 60%;
  border-bottom-right-radius: 100% 83%;
}
#quote_two:after {

  content: '';
  background: #fff;
  z-index: -1;
  position: absolute;
  height: 16%;
  width: 16%;
  bottom: 30%;
  right: 99%;
  -moz-border-radius-bottomright: 100% 60%;
  -webkit-border-bottom-right-radius: 100% 60%;
  border-bottom-right-radius: 100% 60%;
  -moz-transform: rotate(25deg);
  -ms-transform: rotate(25deg);
  -webkit-transform: rotate(25deg);
  transform: rotate(25deg);
}

#quote_one p{
        font-size: 16px;
    }
    #quote_two p{
        font-size: 16px;
    }

@media only screen and (max-width: 1030.9px) {
    #quote_one p{
        font-size: 12px;
    }
    #quote_two p{
        font-size: 12px;
    }
    
}
@media only screen and (max-width: 500.9px) {
    #quote_one {
        max-width: 300px;
        height: 200px !important;
    }
    #quote_two {
        max-width: 300px;
        height: 200px !important;
    }
    #quote_two:after {
        display: none;
    }
    #quote_two::before {
        display: none;
    }
    #quote_one:after {
        display: none;
    }
    #quote_one::before {
        display: none;
    }
    
}
</style>
@endpush
@section('content')
<div class="container-fluid px-0 overflow-hidden">
    <section>
        <header class="view-100 back_ground_image">
        <div class="overlay d-flex justify-content-center align-items-center">
            <div class="row  ">
                <div class="col-12">
                    <h1 class="animate__zoomInDown animate__animated wow animate__slow	2s">Welcome to the Very Friendly Sharks
                        Seller's Programme</h1>
                    <h3 class="animate__fadeInLeftBig animate__animated wow animate__slow	2s"> An exclusive circle where distinguished sellers like you thrive</h3>
                
                    <br>
                    <div class="row justify-content-center animate__fadeInRightBig animate__animated wow animate__slow	2s">
                        <div class="col-md-4">
                            @if(auth()->user())
                            <a href="{{route('seller.survey')}}" class="btn btn-site-primary py-3  w-100">GET STARTED</a>
                            @else
                            <a class="btn btn-site-primary py-3 w-100 open_register_modal" data-bs-toggle="modal" data-bs-target="#registerModal" onclick="loadRecaptcha()" href="#">GET STARTED</a>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </header>
        {{-- <div class="back_ground_image view-100">
            <div class="container-md h-100">
                <div class="row  py-md-1 py-5 justify-content-center h-100">
                    <div class="col-md-6 text-center d-flex align-items-center pt-5">
                        <div class="mt-4">
                            <h1 class='text-white Welcome-Friendly text-start'>Welcome to the Very Friendly Sharks
                                Seller's Programme</h1>
                            <p class="text-white text-start">
                                An exclusive circle where distinguished sellers like you thrive</p>
                            @if(auth()->user())
                            <a href="{{route('seller.survey')}}" class="btn btn-site-primary py-3 w-100">GET STARTED</a>
                            @else
                            <a class="btn btn-site-primary py-3 w-100 open_register_modal" data-bs-toggle="modal" data-bs-target="#registerModal" onclick="loadRecaptcha()" href="#">GET STARTED</a>
                            @endif
                        </div>
                    </div>
                    
                    
                    
                </div>
            </div>
        </div> --}}
        <div class="container-md mt-2">
            <div class="row my-5">
                
                <div class="col-12 text-center mb-5 animate__fadeIn animate__animated wow animate__slow	2s ">
                    <div class="row justify-content-center">
                        <div class="col-md-7 col-12  text-white d-flex-align-items-end">
                            <div class="row justify-content-end align-items-center bg_dark_shark rounded-site">
                                <div class="col-lg-6  animate__animated wow animate__slow	2s  animate__rollIn">
                                    <img src="{{asset('images/home/saller1.png')}}" alt="" width="100%">
                                </div>
                                <div class="col-lg-6 text-start">
                                    <p class="py-3">
                                        At Very Friendly Sharks, we're building a trusted card marketplace and cultivating a community where the crème de la crème of Magic: the Gathering sellers thrive. Imagine being part of an elite club where opening booster boxes isn't just a hobby, it's a rewarding venture. 
                                    </p>
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
                <div class="col-12">
                    <h2 class="text-site-primary Welcome-Friendly text-center mb-5">
                        Why Join the VFS Seller's Programme? 
                    </h2>
                </div>
                <div class="col-12  rounded-site">
                    {{-- <div class="row">
                        <div class="col-12">
                            <div class="row mb-5">
                                <div class="col-md-6 my-auto">
                                    <div class=" p-3">
                                        <div class="survey-title text-site-primary">
                                            Exclusive Rewards
                                        </div>
                                        <p class="font-weight-light fs-4 text-justify">
                                            As a member of this elite programme, you'll earn financial incentives for
                                            every card you sell. The more you trade, the more you gain.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex justify-content-center align-items-center mt-5">
                                    <div class="">
                                        <img src="{{asset('images/home/success-plan-opt1-1.webp')}}" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5 flex-sm-row-reverse">
                                <div class="col-md-6 my-auto">
                                    <div class=" p-3">
                                        <div class="survey-title text-site-primary">
                                            Top-Tier Community
                                        </div>
                                        <p class="font-weight-light fs-4 text-justify">
                                            Stand shoulder to shoulder with the best sellers in the MTG universe. Share
                                            strategies and insights, and forge lasting connections.
                                        </p>
                                    </div>
                                    
                                </div>
                                <div class="col-md-6 d-flex justify-content-center align-items-center  mt-5">
                                    <div class="">
                                        <img src="{{asset('images/home/learn-skills-opt1-1.webp')}}" alt=""  width="100%">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6 my-auto">
                                    <div class=" p-3">
                                        <div class="survey-title text-site-primary">
                                            Top Seller Status
                                        </div>
                                        <p class="font-weight-light fs-4 text-justify">
                                            Stand out in the marketplace as a seller programme badge, a badge of honour
                                            that attracts serious buyers and collectors.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex justify-content-center align-items-center  mt-5">
                                    <div class="">
                                        <img src="{{asset('images/home/implement-pro-opt1.webp')}}" alt=""  width="100%">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5 flex-sm-row-reverse">
                                
                                <div class="col-md-6 my-auto">
                                    <div class=" p-3">
                                        <div class="survey-title text-site-primary">
                                            Limited Membership
                                        </div>
                                        <p class="font-weight-light fs-4 text-justify">
                                            Only a select few will be chosen. Are you ready to be one of them?
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex justify-content-center align-items-center  mt-5">
                                    <div class="">
                                        <img src="{{asset('images/home/plugin-opt1.webp')}}" alt=""  width="100%">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6 my-auto">
                                    <div class=" p-3">
                                        <div class="survey-title text-site-primary">
                                            Priority Support
                                        </div>
                                        <p class="font-weight-light fs-4 text-justify">
                                            Get direct access to our dedicated support team, ensuring your selling
                                            experience is seamless and your queries are prioritised.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex justify-content-center align-items-center  mt-5">
                                    <div class="">
                                        <img src="{{asset('images/home/stay-game-opt1-1.webp')}}" alt="" width="100%">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5 flex-sm-row-reverse">
                               
                                <div class="col-md-6 my-auto">
                                    <div class=" p-3">
                                        <div class="survey-title text-site-primary">
                                            Enhanced Visibility
                                        </div>
                                        <p class="font-weight-light fs-4 text-justify">
                                            Enjoy prime placement on our platform, spotlighting your listings to a vast
                                            network of MTG enthusiasts.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex justify-content-center align-items-center  mt-5">
                                    <div class="">
                                        <img src="{{asset('images/home/admin_VA-1.webp')}}" alt="" width="100%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="row">
                        <div class="col-lg-6 d-flex align-items-center justify-content-center wow animate__animated animate__fadeInLeft animate__slow	2s">
                            <div class="w-75 d-flex align-items-center justify-content-center  ">
                                <img  src="{{asset('images/home/flat-design-reseller-illustration_23-2149484586.avif')}}" alt="" width="100%">
                            </div>
                        </div>
                        <div class="col-lg-6 wow animate__animated animate__fadeInRight animate__slow	2s">
                            <div class=" p-3">
                                <div class="survey-title ">
                                    Exclusive Rewards
                                </div>
                                <p class="font-weight-light fs-4 text-justify">
                                    As a member of this elite programme, you'll earn financial incentives for
                                    every card you sell. The more you trade, the more you gain.
                                </p>
                            </div>
                            <div class=" p-3">
                                <div class="survey-title ">
                                    Top-Tier Community
                                </div>
                                <p class="font-weight-light fs-4 text-justify">
                                    Stand shoulder to shoulder with the best sellers in the MTG universe. Share
                                    strategies and insights, and forge lasting connections.
                                </p>
                            </div>
                            <div class=" p-3">
                                <div class="survey-title ">
                                    Top Seller Status
                                </div>
                                <p class="font-weight-light fs-4 text-justify">
                                    Stand out in the marketplace as a seller programme badge, a badge of honour
                                    that attracts serious buyers and collectors.
                                </p>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row mt-5 ">
                        
                        <div class="col-lg-6 wow animate__animated animate__fadeInLeft animate__slow	2s">
                            <div class=" p-3">
                                <div class="survey-title ">
                                    Limited Membership
                                </div>
                                <p class="font-weight-light fs-4 text-justify">
                                    Only a select few will be chosen. Are you ready to be one of them?
                                </p>
                            </div>
                            <div class=" p-3">
                                <div class="survey-title ">
                                    Priority Support
                                </div>
                                <p class="font-weight-light fs-4 text-justify">
                                    Get direct access to our dedicated support team, ensuring your selling
                                            experience is seamless and your queries are prioritised.
                                </p>
                            </div>
                            <div class=" p-3">
                                <div class="survey-title ">
                                    Enhanced Visibility
                                </div>
                                <p class="font-weight-light fs-4 text-justify">
                                    Enjoy prime placement on our platform, spotlighting your listings to a vast
                                    network of MTG enthusiasts.
                                </p>
                            </div>
                            
                        </div>
                        <div class="col-lg-6 d-flex align-items-center justify-content-center wow animate__animated animate__fadeInRight animate__slow	2s">
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                <img class="wow animate__backInLeft" src="{{asset('images/home/business-team-discussing-ideas-startup_74855-4380.avif')}}" alt="" width="100%">
                            </div>
                        </div>
                    </div> --}}

                    <div class="row ">
                        <div class="col-lg-4 bg-site-primary text-white animate__animated wow animate__slow	2s animate__fadeInLeft">
                            <div class=" p-3">
                                <div class="survey-title  text-center text-white">
                                    Exclusive Rewards
                                </div>
                                <p class="font-weight-light fs-5 text-justify text-center">
                                    As a member of this elite programme, you'll earn financial incentives for
                                    every card you sell. The more you trade, the more you gain.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4 text-white">
                            <div class=" p-3">
                                <div class="survey-title  text-center text-site-primary">
                                    Top-Tier Community
                                </div>
                                <p class="font-weight-light fs-5 text-justify text-site-primary text-center">
                                    Stand shoulder to shoulder with the best sellers in the MTG universe. Share
                                    strategies and insights, and forge lasting connections.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4 bg-site-primary text-white animate__animated wow animate__slow	2s animate__fadeInRight">
                            <div class=" p-3">
                                <div class="survey-title  text-center">
                                    Top Seller Status
                                </div>
                                <p class="font-weight-light fs-5 text-justify text-center">
                                    Stand out in the marketplace as a seller programme badge, a badge of honour
                                    that attracts serious buyers and collectors.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4 text-white">
                            <div class=" p-3">
                                <div class="survey-title  text-center text-site-primary">
                                    Limited Membership
                                </div>
                                <p class="font-weight-light fs-5 text-justify text-site-primary text-center">
                                    Only a select few will be chosen. Are you ready to be one of them?
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4 bg-site-primary text-white animate__animated wow animate__slow	2s animate__fadeInUp">
                            <div class=" p-3">
                                <div class="survey-title  text-center">
                                    Priority Support
                                </div>
                                <p class="font-weight-light fs-5 text-justify text-center">
                                    Get direct access to our dedicated support team, ensuring your selling experience is seamless and your queries are prioritised.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4 text-white">
                            <div class=" p-3">
                                <div class="survey-title  text-center text-site-primary">
                                    Enhanced Visibility
                                </div>
                                <p class="font-weight-light fs-5 text-justify text-site-primary text-center">
                                    Enjoy prime placement on our platform, spotlighting your listings to a vast network of MTG enthusiasts.
                                </p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-site-primary Welcome-Friendly text-center mb-5">
                        Your Exclusive Invitation
                    </h2>
                </div>
                {{-- <div id="quote">
                    <p>Quote text in here...</p>
                  </div> --}}
                <div class="col-12">
                    
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-4 d-flex justify-content-center align-items-center animate__fadeInLeftBig animate__animated wow animate__slow	2s">
                            <div id="quote_one" class="d-flex align-items-center">
                                <p class="text-center">This is your moment to shine in a marketplace that values your
                                    dedication. We're looking for sellers who love TCG games and are committed to
                                    enhancing the online card trading community. Do you eagerly await each MTG
                                    expansion, with boxes of sealed boosters ready to uncover rare finds?</p>
                              </div>
                        </div>
                        <div class="col-md-3 d-flex justify-content-center align-items-end py-4 align-items-center wow animate__animated animate__pulse animate__slow	2s animate__infinite	infinite">
                            <div class="text-center">
                                <img src="{{asset('images/home/2024-04-16-We-Want-You-Final (1).png')}}" alt="" width="90%"
                                    height="90%">
                            </div>
                        </div>
                        <div class="col-md-4 d-flex justify-content-center align-items-center animate__fadeInRightBig animate__animated wow animate__slow	2s">
                            <div id="quote_two" class="d-flex align-items-center">
                                <p class="text-center">Do you relish the thrill of turning those discoveries into profitable sales? If your
                                    heart races at the thought, you're the perfect candidate for our Seller's Programme.</p>
                              </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
       <div class="container-md">
            <div class="row my-5">
                <div class="col-12  rounded-site">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="text-site-primary Welcome-Friendly text-center mb-5">
                                The Path to Prestige Begins Here
                            </h2>
                            <p class="mb-5">Joining is simple, but entry is coveted. Here's how to embark on this exclusive journey:</p>
                        </div>
                        <div class="col-12">
                            <div class="container-fluid">
                                <div class="container">
                                    <!--first section-->
                                    <div class="row align-items-center how-it-works">
                                        <div class="col-2 text-center bottom">
                                            <div class="circle">1</div>
                                        </div>
                                        <div class="col-md-6 col-10">
                                            <h5 class="fw-bolder fs-3">Sign Up</h5>
                                            <p class="mb-0">Register to our platform and join our discord community.</p>
                                        </div>
                                    </div>
                                    <!--path between 1-2-->
                                    <div class="row timeline">
                                        <div class="col-2">
                                            <div class="corner top-right"></div>
                                        </div>
                                        <div class="col-8">
                                            <hr />
                                        </div>
                                        <div class="col-2">
                                            <div class="corner left-bottom"></div>
                                        </div>
                                    </div>
                                    <!--second section-->
                                    <div class="row align-items-center justify-content-end how-it-works">
                                        <div class="col-md-6 col-10 text-right">
                                            <h5 class="fw-bolder fs-3">Take the Survey</h5>
                                            <p lass="mb-0">Pass our curated survey to showcase your dedication and expertise.</p>
                                        </div>
                                        <div class="col-2 text-center full">
                                            <div class="circle">2</div>
                                        </div>
                                    </div>
                                    <!--path between 2-3-->
                                    <div class="row timeline">
                                        <div class="col-2">
                                            <div class="corner right-bottom"></div>
                                        </div>
                                        <div class="col-8">
                                            <hr />
                                        </div>
                                        <div class="col-2">
                                            <div class="corner top-left"></div>
                                        </div>
                                    </div>
                                    <!--third section-->
                                    <div class="row align-items-center how-it-works">
                                        <div class="col-2 text-center top">
                                            <div class="circle">3</div>
                                        </div>
                                        <div class="col-md-6 col-10">
                                            <h5 class="fw-bolder fs-3">Await Our Call</h5>
                                            <p lass="mb-0">If selected, you'll hear from us via email with the next steps to elevate your seller status.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-5">Slots are as rare as a Serialised Foil found in a collector booster pack – limited and highly sought after. Don't miss your chance to transform your passion into a reward.</p>
                            <p>We're not just building a marketplace; we're curating a community of the finest sellers. Are you one of them? Let's find out together.</p>
                        </div>
                        <div class="col-12 text-center mt-5">
                            <div class="row justify-content-center">
                                <div class="col-sm-6">
                                    @if(auth()->user())
                                        <a href="{{route('seller.survey')}}" class="btn btn-site-primary btn-lg px-5 w-100">GET STARTED</a>
                                        @else
                                        <a class="btn btn-site-primary btn-lg px-5 open_register_modal w-100" data-bs-toggle="modal" data-bs-target="#registerModal" onclick="loadRecaptcha()" href="#">GET STARTED</a>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       </div>
</div>
</section>
</div>
@endsection

@push('js')
<script src="{{ asset('wow/wow.min.js') }}"></script>
<script>
    new WOW().init();
    </script>
<script>
    var ques = 0;
    var questionAnswered = 0;
    var count = 0;
    $(document).ready(function () {
        $('#surveyForm').submit(function (e) {
            e.preventDefault();
            
            var ques = 0;
            var count = 0;
            $('.test-start .question_c').each(function () {
                ques = ques+1;
                questionAnswered =  $(this).find('.radio_btn:checked').length > 0;
                if (questionAnswered == '1') {
                    count = count + 1;
                }
            });


            if (ques == count) {
                this.submit();
            } else {
                toastr.error("Please Complete your survey first");
            }
        });
    });
    
</script>

@endpush