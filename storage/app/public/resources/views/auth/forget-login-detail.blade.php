@extends('layouts.app')
@section('title','Forgot Your Login? - Very Friendly Sharks: Regain Access to Your Account')
@section('description','Regain Access to Your Account - Follow the Steps to Retrieve Your Login Details. Get Back to Trading with Very Friendly Sharks!')
@push('css')
@endpush
@section('content')


    <div class="container-fluid px-0">
        <section>
            <div class="welcome-section mt-5 pb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 text-center mt-4">
                        <h1 class="text-site-primary Welcome-Friendly">Lost at sea?</h1>
                    </div>
                    <div class="col-12 welcome_text">
                        <p>Thankfully we are Very Friendly Sharks and can help you get recover your account as quickly as possible. The following options allow you to either reset a password, if you remember the registered email, or to find the registered email if you know your username.  Should you still have issues, please contact support highlighting your problem.</p>
                    </div>
                </div>
            </div>
        </div>
        </section>
        <section>
            <div class="container mb-5">
                <div class="row justify-content-between">
                    <div class="col-md-6  justify-content-center ps-md-0">
                        <div class="login-form shadow_site px-3">
                            <form class="auth-login-form mt-2 submit_form" action="{{ route('forgot.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="password">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="fw-bold ">Email<span class="text-danger">*</span>:</label>
                                        <input type="email" name="email" required placeholder="Email" class="form-control-lg form-control-site-lg w-100 br-none" >
                                        @error('email')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-center mt-4 forget-recapcha">
                                        <div class="g-recaptcha" data-sitekey="6LegtnQoAAAAAHtABNI-tj1nHNNxmMAAY3ap17HF" data-callback='onSubmit' data-action='submit'></div>
                                    </div>
                                    @error('g-recaptcha-response')
                                            <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="d-flex justify-content-center  mt-3">
                                        <button class="btn btn-site-primary submit_btn">Recover</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="col-md-6  justify-content-center pe-md-0 mt-md-0 mt-3">
                        <div class="login-form shadow_site px-3 ">
                            <form class="auth-login-form mt-2 submit_form" action="{{ route('forgot.store') }}" method="POST">
                            <form class="auth-login-form mt-2 " action="{{ route('forgot.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="type" value="email">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="fw-bold ">Username<span class="text-danger">*</span>:</label>
                                        <input type="text" name="username" required placeholder="Username" class="form-control-lg form-control-site-lg w-100 br-none" >
                                        @error('username')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-center mt-4 forget-recapcha">
                                        <div class="g-recaptcha" data-sitekey="6LegtnQoAAAAAHtABNI-tj1nHNNxmMAAY3ap17HF" data-callback='onSubmit' data-action='submit'></div>
                                    </div>
                                    @error('g-recaptcha-response')
                                            <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="d-flex justify-content-center  mt-3">
                                        <button class="btn btn-site-primary submit_btn">Recover</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>




@endsection

@push('js')
<script>
    $(document).ready(function(){
        loadRecaptcha();
    })
</script>
@endpush

