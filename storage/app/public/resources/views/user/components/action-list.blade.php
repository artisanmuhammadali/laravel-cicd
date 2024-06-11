<ul class="nav nav-pills mb-2 setting_navs">
    <li class="nav-item">
        <a title="Account" class="nav-link primary-hover  @if(url()->current() == route('user.account')) active @endif" href="{{route('user.account')}}">
            <i data-feather='user'></i>
            <span class="fw-bold d-sm-none d-xs-none d-none d-md-block">Account</span>
        </a>
    </li>
    <li class="nav-item">
        <a title="Security" class="nav-link primary-hover @if(url()->current() == route('user.change.password')) active @endif" href="{{route('user.change.password')}}">
            <i data-feather='lock'></i>
            <span class="fw-bold d-sm-none d-xs-none d-none d-md-block">Security</span>
        </a>
    </li>
    <li class="nav-item">
        <a title="Account Type" class="nav-link primary-hover @if(url()->current() == route('user.mangopay.interest')) active @endif" href="{{route('user.mangopay.interest')}}">
            <i data-feather='info'></i>
            <span class="fw-bold d-sm-none d-xs-none d-none d-md-block">Account Type</span>
        </a>
    </li>
    @if($auth->store->mango_id && $auth->role != "buyer")
    <li class="nav-item">
        <a title="Verification" class="nav-link primary-hover @if(url()->current() == route('user.mangopay.kyc.detail')) active @endif" href="{{route('user.mangopay.kyc.detail')}}">
            <i data-feather='book'></i>
            <span class="fw-bold d-sm-none d-xs-none d-none d-md-block">Verification</span>
            @if($auth->store->role_change || !$auth->store->kyc_payment)
            <span class="badge rounded-pill bg-danger p-50 ms-50">
                <p class="d-none">1</p>
            </span>
            @endif
        </a>
    </li>
    @endif
</ul>