@extends('layouts.app')
@section('title','Complete Registration')
@push('css')
@endpush
@section('content')

<div class="container-fluid px-0">
    <section>
        <div class="welcome-section mt-5 pb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 text-center mt-4">
                        <h3 class="text-site-primary Welcome-Friendly">Welcome</h3>
                    </div>
                    <div class="col-8 welcome_text">
                        <p>Thank you for joining our platform we need more details to complete your joining process</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container mb-5">
            <div class="row justify-content-center">
                <div class="col-md-6  justify-content-center ps-md-0">
                    <div class="login-form shadow_site">
                        <form class="auth-login-form mt-2 submit_form" action="{{ route('social.save.registration') }}"
                            method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{$user->id ?? ''}}">
                            <input type="hidden" name="email" value="{{$user->email ?? ''}}">
                            <input type="hidden" name="first_name" value="{{$user->first_name ?? ''}}">
                            <input type="hidden" name="last_name" value="{{$user->last_name ?? ''}}">
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <label class="fw-bold">Username<span class="text-danger">*</span></label>
                                    <input type="text" minlength="4" name="user_name" placeholder="test123"
                                        id="user_name" placeholder=""
                                        class=" form-control-lg form-control-site-lg w-100 br-none required fs-sm-14">
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="fw-bold">Date Of Birth<span class="text-danger">*</span></label>
                                    <input type="date" name="dob"
                                        class="form-control-lg form-control-site-lg w-100 br-none required fs-sm-14">
                                </div>
                                <div class="col-12 ">
                                    <label class="fw-bold ">Where did you hear about us?<span
                                            class="text-danger">*</span></label>
                                    <textarea
                                        class="form-control-lg form-control-site-lg w-100 br-none required fs-sm-14"
                                        name="hear_about_us"></textarea>
                                </div>
                                <div class="col-12 d-flex align-items-start">
                                    <input class="mt-1 me-2" type="checkbox"  id="newsletter-1" name="newsletter">
                                    <label for="newsletter-1" class="">Sign up to receive sales, promotions &amp; news from
                                        Very Friendly Sharks (optional).</label>
                                </div>
                                <button type="submit" class="btn btn-site-primary w-auto m-auto">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>




@endsection
