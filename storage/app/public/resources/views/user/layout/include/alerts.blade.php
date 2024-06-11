<div class="px-1 mb-2 mt-md-5">
    @if($auth->role == "buyer" && $auth->store->active_acc_alert)
    <div class="alert alert-warning rounded-0" role="alert">
        <div class="alert-body d-md-flex d-block justify-content-between align-items-center ps-sm-5  px-25">
            <p class="font-sm-12"><span class=" fw-bolder"><i class="fa-solid fa-circle-info fs-6 me-25"></i></span>Activate yourself as a seller or change to another account type?</p>
            <div class="d-flex align-items-center">
                <form class="mb-0" action="{{route('user.mangopay.details')}}" method="POST">
                @csrf
                    <input type="hidden" name="role" value="seller" >
                    <input type="hidden" name="type" value="personal" >
                    <button type="submit" class="btn btn-success waves-effect font-sm-12 me-1">Active</button>
                </form>
                <a href="{{route('user.mangopay.interest')}}" class="btn btn-primary waves-effect font-sm-12 btn_h-fix">Change</a>
                <a href="{{route('user.change.status','alert_inactive')}}" type="button" class="btn btn-outline-warning ms-sm-1 ms-3 px-1 py-50 fs-2 waves-effect waves-float waves-light">x</a>
            </div>
        </div>
    </div>
    @endif
    @if($auth->role != "buyer" && !$auth->kyc_verify && count($auth->kycs) == 0)
    <div class="alert alert-warning rounded-0" role="alert">
        <div class="alert-body d-md-flex justify-content-between align-items-center px-sm-5  px-25 d-block">
            <p class="font-sm-12"><span class=" fw-bolder"><i class="fa-solid fa-circle-info fs-6 me-25"></i></span>You need to KYC verify before you can activate your listings for sale. Read more about it on our <a href="{{getPagesRoute('seller-verification-guide')}}">Seller Verification Guide</a>.</p>
            <div class="d-flex align-items-center">
                <a href="{{route('user.mangopay.kyc.detail')}}" class="btn btn-primary waves-effect font-sm-12 btn_h-fix">Verify Now</a>
            </div>
        </div>
    </div>
    @endif
    @if($auth->role != "buyer" && !$auth->kyc_verify && count($auth->kycs) >= 1 && !checkKycFailed())
    <div class="alert alert-warning rounded-0" role="alert">
        <div class="alert-body d-md-flex justify-content-between align-items-center px-sm-5  px-25 d-block">
            <p class="font-sm-12"><span class=" fw-bolder"><i class="fa-solid fa-circle-info fs-6 me-25"></i></span>Your KYC/KYB verification is in process. This Process Can Take Up To 48 Hours, Sometimes More.</p>
        </div>
    </div>
    @endif
    @if($auth->role != "buyer" && !$auth->kyc_verify && count($auth->kycs) >= 1 && checkKycFailed())
    <div class="alert alert-warning rounded-0" role="alert">
        <div class="alert-body d-md-flex justify-content-between align-items-center px-sm-5  px-25 d-block">
            <p class="font-sm-12"><span class=" fw-bolder"><i class="fa-solid fa-circle-info fs-6 me-25"></i></span>Your recent KYC/KYB verification attempt was unsuccessful. Please re-submit a better copy of the document again and if unsuccessful again please <a href="{{route('help')}}">contact us</a> direclty. Read more about it on our <a href="{{getPagesRoute('seller-verification-guide')}}">Seller Verification Guide</a>.</p>
        </div>
    </div>
    @endif
    @if($auth->kyc_verify && !$auth->store->kyc_payment)
    <div class="alert alert-warning rounded-0" role="alert">
        <div class="alert-body d-flex justify-content-between align-items-center px-sm-5  px-25">
            <p class="font-sm-12"><span class=" fw-bolder"><i class="fa-solid fa-circle-info fs-6 me-25"></i></span>You need to pay the KYC verification fee before you can publish your items for sale. Read more about it on our <a href="{{getPagesRoute('seller-verification-guide')}}">Seller Verification Guide</a>.</p>
        </div>
    </div>
    @endif
    @if($auth->verified && $auth->store->kyc_payment && Route::is('user.collection.index') && authUserCollectionCount(0 , request()->type) >= 1)
    <div class="alert alert-danger rounded-0 inactive_coll_alert" role="alert">
        <div class="alert-body d-flex justify-content-between align-items-center px-sm-5  px-25">
            <p class="font-sm-12"><span class=" fw-bolder"><i class="fa-solid fa-circle-info fs-6 me-25"></i></span>You have inactive items. These items will not be listed on the website until you publish them.</p>
        </div>
    </div>
    @else
    <div class="alert alert-danger rounded-0 inactive_coll_alert_hidden d-none" role="alert">
        <div class="alert-body d-flex justify-content-between align-items-center px-sm-5  px-25">
            <p class="font-sm-12"><span class=" fw-bolder"><i class="fa-solid fa-circle-info fs-6 me-25"></i></span>You have inactive items. These items will not be listed on the website until you publish them.</p>
        </div>
    </div>
    @endif
    @if(!$auth->verified && Route::is('user.collection.index') && authUserCollectionCount(0) >= 1)
    <div class="alert alert-warning rounded-0 " role="alert">
        <div class="alert-body d-flex justify-content-between align-items-center px-sm-5  px-25">
            <p class="font-sm-12"><span class=" fw-bolder"><i class="fa-solid fa-circle-info fs-6 me-25"></i></span>You cannot publish your collection untill your KYC is verified from MangoPay.</p>
        </div>
    </div>
    @endif
    @if(Route::is('user.transaction.list') && $auth->role != "buyer" && getOrderCount('completed' , 'sell') == 0)
    <div class="alert alert-warning rounded-0" role="alert">
        <div class="alert-body d-flex justify-content-between align-items-center px-sm-5  px-25">
            <p class="font-sm-12"><span class=" fw-bolder"><i class="fa-solid fa-circle-info fs-6 me-25"></i></span>You must make at least one sale to withdraw any amount.</p>
        </div>
    </div>
    @endif
    @if(Route::is('user.transaction.list') && $auth->role != "buyer")
        @if(count($withdraw_request) >= 1)
        <div class="alert alert-warning rounded-0" role="alert">
            <div class="alert-body d-flex justify-content-between align-items-center px-sm-5  px-25">
                <p class="font-sm-12"><span class=" fw-bolder"><i class="fa-solid fa-circle-info fs-6 me-25"></i></span>After Approval from Admin Mangopay usually takes upto 48 hours to process.</p>
            </div>
        </div>
        @endif
    @endif
</div>
