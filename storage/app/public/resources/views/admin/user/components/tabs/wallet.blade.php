<div class="col-lg-6 col-12 order-2 order-lg-1">
    <div class="card">
        <div class="card-body">
            <h3 class="mb-75">MangoPay Wallet</h3>
            <div class="mt-2 d-flex">
                <h5 class="mb-75 col-4">Amount:</h5>
                <p class="card-text col-8 text-capitalize">£{{$walletAmount}}</p>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-6 col-12 order-2 order-lg-1">
    <div class="card">
        <div class="card-body">
            <h3 class="mb-75">Referral Wallet</h3>
            <div class="mt-2 d-flex">
                <h5 class="mb-75 col-4">Amount:</h5>
                <p class="card-text col-8 text-capitalize">£{{$user->store ? $user->store->vfs_wallet : 0}}</p>
            </div>
        </div>
    </div>
</div>