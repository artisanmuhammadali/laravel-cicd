<nav class="header-navbar navbar navbar-expand-lg align-items-center p navbar-light navbar-shadow nav-border userNav {{!$auth->store->mango_id ? '' : 'bg-site-primary'}}">
    <div class="container-fluid {{!$auth->store->mango_id ? 'bg-site-primary' : ''}}">
        <a class=" navbar-brand pe-md-5 me-md-4" href="{{route('index')}}"><img width="130"
                src="{{asset('images/banner/logo/horizontallogo1.png')}}"></a>
        {{-- <button class="navbar-toggler border border-1 d-flex align-items-center d-lg-none d-block" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="text-white d-flex justify-content-center"><i data-feather='align-justify'></i></span>
        </button> --}}
        <a href="{{ route('user.transaction.list') }}"  class="d-lg-none d-block nav-light-text site-border-color btn btn-outline-primary rounded-0  text-decoration-none bg-transparent  btn-padding md-text fw-bold fs-3 text-white d-flex align-items-center">
            £{{getUserWallet()}}
        </a>
        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
            <ul class="navbar-nav  mb-1 mb-lg-0 d-lg-flex d-grid justify-content-center">
                <li class="nav-item px-2">
                    <form class="d-flex justify-content-center" method="POST" action="{{route('logout')}}">
                        @csrf
                        <button class="nav-link nav-url nav-light-text fw-lighter md-text btn text-white"
                            style="margin-top: 2px" type="submit">Logout</button>
                    </form>
                </li>
                <li class="nav-item px-2 ">
                    <a href="{{route('user.account')}}"
                        class="nav-link nav-url nav-light-text fw-lighter md-text text-white">Account</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link nav-url nav-light-text fw-lighter md-text text-white text-center"
                        href="{{route('help')}}">Help</a>
                </li>
            </ul>
            <ul class="navbar-nav  mb-1 mb-lg-0 justify-content-center d-lg-flex d-grid">
                <li class="nav-item dropdown dropdown-notification d-lg-flex justify-content-center">
                    <a class="nav-link text-white d-flex align-items-center justify-content-center" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <i data-feather='bell' style="width: 30px ; height: 30px"></i>
                        <span
                            class=" top-1 translate-middle badge rounded-pill cart-span  bg-site-primary-light">{{getUserNotifications("count")}}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end noti_min_wid">
                        @include('user.components.notification-list')
                    </ul>
                </li>
                <li class="nav-item me-lg-3 me-0 mb-lg-0 mb-2 d-flex justify-content-center align-items-center">
                    <a class="nav-link nav-url nav-light-text position-relative me-lg-0 me-2" href="{{route('cart.index')}}">
                        <img class="icshoppingCartOff" src="{{asset('images/banner/ic-shopping-cart-off@2x.png')}}" loading="lazy" alt="cart">
                        <span class="position-absolute top-1 translate-middle badge rounded-pill cart-span  bg-site-primary-light">
                            {{getUserCart(auth()->user()->id,'count')}}
                        </span>
                    </a>
                </li>
                <li class="nav-item me-0 mb-lg-0 mb-1 d-flex justify-content-center">
                    <a href="{{ route('user.transaction.list') }}"  class="nav-light-text site-border-color btn btn-outline-primary rounded-0  text-decoration-none bg-transparent  btn-padding md-text fw-bold fs-3 text-white d-flex align-items-center">
                        £{{getUserWallet()}}
                    </a>
                </li>
                <li class="nav-item mb-lg-0 mb-1 mx-2 d-flex justify-content-center">
                    <a href="https://discord.com/invite/N292fZM7ez" target="blank"
                        class="nav-light-text site-border-color btn btn-outline-primary rounded-0  text-decoration-none bg-transparent  btn-padding md-text fw-lighter d-flex align-items-center">
                        <img loading="lazy" class="img-invert" src="{{asset('images/nav-bar/discrod.png')}}" width="20">
                        Discord</a>
                </li>
                <li class="nav-item mb-lg-0 mb-1 d-flex justify-content-center">
                    <a class="nav-light-text site-border-color btn btn-outline-primary rounded-0  text-decoration-none bg-transparent  btn-padding md-text fw-lighter py-1 d-flex align-items-center" href="{{$auth->role == "buyer" ? route('user.mangopay.interest') : route('user.collection.index',['single'])}}">
                        <i class="fa fa-gbp pe-1" aria-hidden="true"></i>
                        Sell Now
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="fixed-button fixed_menu_button d-xl-none ">
    <a class="nav-link menu-toggle btn btn-primary">
        <i class="ficon" data-feather="menu"></i>
    </a>
</div>

