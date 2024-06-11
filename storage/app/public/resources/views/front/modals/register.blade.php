<div class="modal fade site-modal" id="registerModal2" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog mt-5">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <div class="text-center RegisterModalImg">
                    <img loading="lazy" class="loginClose" width="100" src="{{asset('images/home/Logo-No-Writing.png')}}">
                </div>
            </div>
        </div> 
        <div class="modal-content mt-4">
            <div class="modal-header justify-content-center pb-0">
                <nav class="nav d-flex">
                    <div class="row">
                        <div class="col-12 pt-5">
                            <h4 class=" registerhead text-site-primary mb-4">Registration</h4>
                        </div>
                    </div>
                </nav>
                <div class="circle_xsm register-btn-margin">
                    <i class="fa fa-close close_icon close_btn_reset mt-sm-0 mt-1" data-bs-dismiss="modal" aria-label="Close"></i>
                </div>
            </div>
            <div class="modal-body registerModal pt-0">
                @include('front.components.register')
            </div>
        </div>
    </div>
</div>