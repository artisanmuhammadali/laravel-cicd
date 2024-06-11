<div class="modal fade site-modal" id="registerModal" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog mt-5">
        <div class="modal-content mt-4">
            <div class="modal-header justify-content-center pb-0">
                <nav class="nav d-flex">
                    <div class="row">
                        <div class="col-12 pt-5 text-center mb-3">
                            <h4 class=" registerhead text-site-primary">Create an Account</h4>
                            <p class="text-secondary fs-6">Start buying and selling cards today</p>
                        </div>
                    </div>
                </nav>
                <div class="circle_xsm register-btn-margin me-2">
                    <i class="fa fa-close close_icon close_btn_reset mt-sm-0 mt-1" data-bs-dismiss="modal" aria-label="Close"></i>
                </div>
            </div>
            <div class="modal-body registerModal pt-0">
                <div class="row px-4 mb-5">
                    <button class="btn btn-site-primary open_register_modal" data-bs-toggle="modal" data-bs-target="#registerModal2" onclick="loadRecaptcha()"  data-bs-dismiss="modal" aria-label="Close">Continue with Email</button>
                    <div class="or"><span class="text-center">OR</span></div>
                    <a href="{{route('social.auth','google')}}" type="button" class="login-with-google-btn text-center border" >
                    Continue with Google
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
