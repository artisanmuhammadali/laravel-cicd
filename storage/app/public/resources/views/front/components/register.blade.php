@php($user_name = $user_name ?? null)
<div class="tab-content">
    <div class="tab-pane fade show active p-3" id="two" role="tabpanel" aria-labelledby="two-tab">
        <form method="POST" action="{{route('register')}}"
            class="submit_form" enctype="multipart/form-data" id="register_form">
            @csrf
            <div class="row mb-2 mb-2">
                <div class="d-block col-md-6 col-12 mb-md-0 mb-2">
                    <label class="fw-bold">First Name<span class="text-danger">*</span></label>
                    <input type="text" minlength="3" name="first_name" placeholder="" class="form-control-lg form-control-site-lg w-100 br-none required fs-sm-14 focus_it">
                </div>
                <div class="d-block col-md-6 col-12">
                    <label class="fw-bold">Last Name<span class="text-danger">*</span></label>
                    <input type="text" minlength="3" name="last_name" placeholder="" class="form-control-lg form-control-site-lg w-100 br-none required fs-sm-14">
                </div>
                
            </div>
            @if($user_name)
            <div class="row">
                <div class="col-12 mb-2">
                    <label class="fw-bold">Referred By</label>
                    <input type="text" name="referel" readonly value="{{$user_name}}"
                        class="form-control-lg form-control-site-lg w-100 br-none fs-sm-14">
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-12 mb-2">
                    <label class="fw-bold">Email<span class="text-danger">*</span></label>
                    <input type="email" name="email" placeholder="name@email.com" class="form-control-lg form-control-site-lg w-100 br-none required fs-sm-14">
                </div>
                <div class="col-12 mb-2">
                    <label class="fw-bold">Username<span class="text-danger">*</span></label>
                    <input type="text" minlength="4" name="user_name" placeholder="test123" id="user_name" placeholder=""
                        class=" form-control-lg form-control-site-lg w-100 br-none required fs-sm-14">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6 col-12 mb-md-0 mb-2">
                    <label class="fw-bold">Password<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" name="password"
                            class="form-control-lg form-control-site-lg w-100 br-none required password-field_id fs-sm-14"
                            data-strength>
                        <span toggle="#password-field" class="fa  fa-eye-slash field-icon toggle-password"></span>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <label class="fw-bold">Confirm Password<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="password-field"
                            class="form-control-lg form-control-site-lg w-100 br-none required password-field_id fs-sm-14"
                            data-strength>
                        <span toggle="#password-field" class="fa fa-eye-slash field-icon toggle-password"></span>
                    </div>
                </div>
                <span class="d-block">Minimum  8 characters, at least 1 uppercase, 1 lowercase letter, 1 number, 1 special character.</span>
            </div>

            <div class="row mb-2">
                
            </div>
            <div class="row mb-2">
                <div class="col-12 mb-2">
                    <label class="fw-bold">Date Of Birth<span class="text-danger">*</span></label>
                    <input type="date" name="dob"  class="form-control-lg form-control-site-lg w-100 br-none required fs-sm-14">
                </div>
                <div class="col-12 ">
                    <label class="fw-bold ">Where did you hear about us?<span
                            class="text-danger">*</span></label>
                    <textarea class="form-control-lg form-control-site-lg w-100 br-none required fs-sm-14" name="hear_about_us"></textarea>
                </div>
            </div>
           
            <div class=" d-block">
                <div class="row mb-2">
                    <div class="col-12">
                        @if(!$user_name)
                        <lable class="d-flex ">Have an account? <span class="ps-2"><a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" class="d-block hover-blue"><span class="text-center forget">Log in</span></a></span></lable>
                        @endif
                        <label for="terms-1" class="">By signing up, you agree to our <a href="{{ getPagesRoute('term')}}" class="hover-blue">Terms of Service</a></label>
                    </div>
                </div>
                <div class="row mb-2">
                    
                    <div class="col-12 d-flex align-items-start">
                        <input class="mt-1 me-2" type="checkbox"  id="newsletter-1" name="newsletter">
                        <label for="policy-1" class="">Sign up to receive sales, promotions &amp; news from
                            Very Friendly Sharks (optional).</label>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group d-flex">
                            <div class="g-recaptcha" data-sitekey="{{config('helpers.recaptcha.key')}}"
                                data-callback='onSubmit' data-action='submit'></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="register-btn mt-md-5 text-center d-md-flex justify-content-around">
                    <div class="spinner-border text-site-primary mt-2 position-absolute loader d-none" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                <button type="submit" class="btn btn-site-primary btn-lg px-5 submit_btn mb-md-0 mb-2" title="Register">Register</button>
            </div>
            <div class="troubleshoot m-auto align-items-center text-center mt-3">
                <a href="{{route('help')}}" class=""><span class="forget hover-blue">Trouble registering?</span></a>
            </div>
        </form>
    </div>
</div>
