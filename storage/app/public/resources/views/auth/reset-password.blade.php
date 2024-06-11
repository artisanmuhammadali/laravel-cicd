


@extends('layouts.auth')
@section('title','Forgot Password')
@section('content')
<div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-cover">
                    <div class="auth-inner row m-0">
                        <!-- Brand logo--><a class="brand-logo" href="javascript:;">
                            <img src="{{$setting['logo'] ?? ""}}" style="width:200px">
                            <!-- <h2 class="brand-text text-primary ms-1">XPLOR</h2> -->
                        </a>
                        <!-- /Brand logo-->
                        <!-- Left Text-->
                        <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                            <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img class="img-fluid" src="{{asset('admin/images/forgot-password-v2.svg')}}" alt="Reset Password" /></div>
                        </div>
                        <!-- /Left Text-->
                        <!-- Login-->
                        <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                                <h2 class="card-title fw-bold mb-1">Reset Password</h2>
                                <p class="card-text mb-2">Your new password must be different from previously used passwords</p>
                                <form class="auth-login-form mt-2" action="{{ route('password.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                    <div class="mb-1">
                                        <label class="form-label" for="login-email">Email</label>
                                        <input class="form-control-lg form-control-site-lg w-100 br-none" id="login-email" type="text" name="email" value="{{$request->email}}" placeholder="john@example.com" aria-describedby="login-email" autofocus="" tabindex="1" />
                                        @error('email')
                                        <p class="error">{{ $message }}</p>
                                       @enderror
                                    </div>
                                    <div class="mb-1">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label" for="login-password">Password</label>
                                        </div>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input class="form-control form-control-merge" id="login-password" type="password" name="password" placeholder="" aria-describedby="login-password" tabindex="2" /><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                         
                                        </div>
                                        @error('password')
                                        <p class="error">{{ $message }}</p>
                                       @enderror
                                    </div>
                                    <div class="mb-1">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label" for="login-password">Confirm Password</label>
                                        </div>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input class="form-control form-control-merge" id="login-password" type="password" name="password_confirmation" placeholder="" aria-describedby="login-password" tabindex="2" /><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                         
                                        </div>
                                    </div>
                                    <!-- <div class="mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" id="remember-me" type="checkbox" tabindex="3" />
                                            <label class="form-check-label" for="remember-me"> Remember Me</label>
                                        </div>
                                    </div> -->
                                    <button class="btn btn-primary w-100" tabindex="4">Reset Password</button>
                                </form>
                                <!-- <p class="text-center mt-2"><span>New on our platform?</span><a href="auth-register-cover.html"><span>&nbsp;Create an account</span></a></p>
                                <div class="divider my-2">
                                    <div class="divider-text">or</div>
                                </div>
                                <div class="auth-footer-btn d-flex justify-content-center"><a class="btn btn-facebook" href="#"><i data-feather="facebook"></i></a><a class="btn btn-twitter white" href="#"><i data-feather="twitter"></i></a><a class="btn btn-google" href="#"><i data-feather="mail"></i></a><a class="btn btn-github" href="#"><i data-feather="github"></i></a></div> -->
                            </div>
                        </div>
                        <!-- /Login-->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')

@endpush


