@extends('layouts.app')
@section('title','Email Verification')
@section('content')
<style>
    .mtg-nav{
        display: none;
    }
</style>
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="auth-wrapper auth-cover">
                <div class="auth-inner row justify-content-center m-0 my-5">
                    <div class="d-flex col-md-5 align-items-center auth-bg p-3" style="box-shadow: 0 5px 20px #22233a26;">
                        <div class="col-12 col-sm-8 col-md-6 col-lg-12  mx-auto">
                            <div class="mb-4 text-sm text-gray-600 alert alert-warning text-justify">
                                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                            </div>

                            @if (session('status') == 'verification-link-sent')
                            <div class="mb-4 font-medium text-sm text-green-600 alert alert-success">
                                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                            </div>
                            @endif
                            <form class="auth-login-form mt-2" action="{{ route('verification.send') }}" method="POST">
                                @csrf
                                <button class="btn btn-site-primary w-100" tabindex="4">{{ __('Resend Verification Email') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection