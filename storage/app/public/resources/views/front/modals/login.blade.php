@php($user_name = $user_name ?? null)
<div class="modal fade pt-3 site-modal"   id="loginModal" role="dialog" aria-modal="true">
    <div class="modal-dialog mt-5">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <div class="text-center LoginModalImg">
                    <a href="">
                    <img loading="lazy" class="loginClose typing d-none" width="100" src="{{asset('images/home/Closed Shark@4x.png')}}">
                    <img loading="lazy" class="loginClose no-typing" width="100" src="{{asset('images/home/Logo-No-Writing.png')}}">
                    </a>
                </div>
            </div>
        </div> 
        <div class="modal-content">
            <div class="row modal-header text-center p-0">
                <div class="row justify-content-end">
                    <div class="col-11 d-flex justify-content-center text-center">
                        <h4 class="pt-5 mt-4 LoginModal text-site-primary">Login</h4>
                        <div class="circle_xsm login-btn-margin close_btn_reset me-sm-0 me-2">
                            <i class="fa fa-close close_icon" data-bs-dismiss="modal" aria-label="Close"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body px-0">
                <div class="login-form">
                    <form action="{{route('user.login')}}" method="post" class="submit_form">
                        @csrf
                        <div class="row pb-2">
                            <div class="d-flex justify-content-between"><label class="fw-bold">Email<span class="text-danger">*</span></label></div>
                            <div class="col-12">
                                <input type="email" name="email" placeholder="Email" class="form-control-lg form-control-site-lg w-100 br-none required fs-sm-14">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12">
                                <label class="fw-bold mt-3">Password<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" placeholder="Password" name="password" class="w-100 br-none form-control-lg form-control-site-lg required password-field_id fs-sm-14">
                                    <span toggle="#password-field" class="fa fa-eye-slash field-icon toggle-password"></span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 mb-2">
                            <lable class="d-flex">No account? 
                                @if($user_name)
                                <span class="ps-2"><a class="d-block hover-blue pagescroll"><span class="text-center forget" data-bs-dismiss="modal" aria-label="Close">Register</span></a></span>
                                @else
                                <span class="ps-2"><a data-bs-toggle="modal" data-bs-target="#registerModal" href="#" class="d-block hover-blue"><span class="text-center forget">Register</span></a></span>
                                @endif
                            </lable>
                        </div>
                        <div class="g-recaptcha " data-sitekey="{{config('helpers.recaptcha.key')}}"
                            data-callback='onSubmit' data-action='submit'></div>
                        <div class="register-btn mt-md-5 mb-2 text-center d-flex justify-content-center">
                            <div class="spinner-border text-site-primary mt-2 position-absolute loader d-none" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <button type="submit" class="btn btn-site-primary btn-lg px-5 submit_btn mb-md-0 mb-2 w-75 py-1" title="Log In">Log In</button>
                        </div>
                        <div class="col-12 text-center mb-5 mb-md-0">
                            <a href="{{route('forgot.login')}}" class="d-block hover-blue"><span class="text-center forget">Forgotten login
                                    details?</span></a>
                            <div class="or"><span class="text-center">OR</span></div>
                            <a href="{{route('social.auth','google')}}" type="button" class="login-with-google-btn text-center border w-75" >
                            Continue with Google
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
