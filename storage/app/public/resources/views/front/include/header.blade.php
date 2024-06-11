
@php($page = $page ?? null)
<nav class="navbar navbar-expand-lg  p-0 {{$class ?? ""}}">
    <div class="container ps-0 pe-md-0">
        <a class=" navbar-brand pe-md-5 me-md-4" href="{{route('index')}}">
            <img  class="header-logo" src="{{$setting['logo'] ?? ""}}" loading="lazy" alt="logo">
        </a>
        <!-- <a class="nav-link nav-url text-white hide-on-large" href="#"><img class="icshoppingCartOff"
                src="{{asset('images/banner/ic-shopping-cart-off@2x.png')}}" alt=""></a> -->

            @if(auth()->user())
            <li class="nav-item m-0 d-md-none d-block align-items-center justify-content-center">
                <a href="{{ route('user.transaction.list') }}" class="small nav-light-text site-border-color btn-outline-primary rounded-0  text-decoration-none bg-transparent  fw-bolder h-100 d-flex align-items-center d-flex justify-content-center w-max-content m-auto border p-2">
                    £{{getUserWallet()}}
                </a>
            </li>
            @else
            <li class="nav-item m-0 d-md-none d-block">
                <a href="https://discord.com/invite/N292fZM7ez" target="blank" class="small nav-light-text site-border-color btn-outline-primary rounded-0  text-decoration-none bg-transparent  fw-lighter h-100 d-flex align-items-center d-flex justify-content-center w-max-content m-auto border p-2">
                    <img loading="lazy" class="img-invert" src="{{asset('images/nav-bar/discrod.png')}}" width="20" alt="discord">
                    Discord
                </a>
            </li>
            @endif

        {{--<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>--}}
        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
            <ul class="navbar-nav  mb-2 mb-lg-0 justify-content-end">
                @if(auth()->user())
                <li class="nav-item px-2">
                    <form class="d-flex justify-content-center" method="POST" action="{{route('logout')}}">
                        @csrf
                        <button class="nav-link nav-url nav-light-text fw-lighter md-text"  type="submit">Logout</button>
                    </form>
                </li>
                <li class="nav-item px-2 ">
                    @if($auth->role == 'admin')
                    <a href="{{route('user.account')}}" class="nav-link nav-url nav-light-text fw-lighter md-text">Admin</a>
                    @else
                        <a href="{{route('user.account')}}" class="nav-link nav-url nav-light-text fw-lighter md-text">Account</a>
                    @endif
                </li>
                @if($auth->role == 'admin' && $page)
                <li class="nav-item px-2 ">
                    <a data-bs-toggle="offcanvas" href="#offcanvasExample" class="nav-link nav-url nav-light-text fw-lighter md-text  set_page
                    "  data-page="{{$page}}" data-url="{{route('admin.ajax.get.page.setting')}}">Setting</a>
                </li>
                @endif
                @else
                <li class="nav-item px-2">

                    <a class="nav-link nav-url nav-light-text fw-lighter md-text open_register_modal" data-bs-toggle="modal" data-bs-target="#registerModal" onclick="loadRecaptcha()" href="#">Register</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link nav-url nav-light-text fw-lighter md-text" onclick="loadRecaptcha()" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                </li>
                @endif
                <li class="nav-item px-2">
                    <a class="nav-link nav-url nav-light-text fw-lighter md-text" href="{{route('help')}}">Help</a>
                </li>
            </ul>
            <ul class="navbar-nav  mb-2 mb-lg-0 justify-content-end">
                @if(Auth::user() && Auth::user()->role != "admin")
                <li class="nav-item dropdown dropdown-notification me-4">
                    <a class="nav-link text-white" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell fs-3" aria-hidden="true"></i>
                        <span
                            class="position-absolute top-1 translate-middle badge rounded-pill notify-span  bg-site-primary-light">{{getUserNotifications("count")}}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end" style="min-width: 319px">
                        @include('front.components.user.notification-dropdown')
                    </ul>
                </li>
                <li class="nav-item me-lg-4 me-0 mb-lg-0 mb-2 d-lg-flex d-none align-items-center">
                    <a class="nav-link nav-url nav-light-text position-relative cart_btn" data-url="{{route('cart.index')}}">
                        <img class="icshoppingCartOff" src="{{asset('images/banner/ic-shopping-cart-off@2x.png')}}" loading="lazy" alt="cart">
                        <span class="position-absolute top-1 translate-middle badge rounded-pill cart-span count_cart_text">
                            {{getUserCart(auth()->user()->id,'count')}}
                        </span>
                    </a>
                </li>
                <li class="nav-item me-lg-4 me-0 mb-lg-0 mb-2 d-flex align-items-center justify-content-center">
                    <a href="{{ route('user.transaction.list') }}" class="nav-light-text site-border-color btn btn-outline-primary rounded-0  text-decoration-none bg-transparent  btn-padding md-text fw-bold fs-3 text-white h-100 d-flex align-items-center">
                        £{{getUserWallet()}}
                    </a>
                </li>
                <li class="nav-item me-lg-4 me-0 mb-lg-0 mb-2">
                    <a href="https://discord.com/invite/N292fZM7ez" target="blank" class="nav-light-text site-border-color btn btn-outline-primary rounded-0  text-decoration-none bg-transparent  btn-padding md-text fw-lighter h-100 d-flex align-items-center d-flex justify-content-center w-max-content m-auto">
                        <img loading="lazy" class="img-invert" src="{{asset('images/nav-bar/discrod.png')}}" width="20" alt="discord">
                    Discord</a>
                </li>
                <li class="nav-item mb-md-0 mb-2">
                    <a class="nav-light-text site-border-color btn btn-outline-primary rounded-0  text-decoration-none bg-transparent  btn-padding md-text fw-lighter h-100 d-flex align-items-center d-flex justify-content-center w-max-content m-auto" href="{{$auth->role == "buyer" ? route('user.mangopay.interest') : route('user.collection.index',['single'])}}">
                        <i class="fa fa-gbp px-1" aria-hidden="true"></i>
                        Sell Now
                    </a>
                </li>
                @endif
                @if(!Auth::user())
                <li class="nav-item me-lg-4 me-0 mb-lg-0 mb-2">
                    <a href="https://discord.com/invite/N292fZM7ez" target="blank" class="nav-light-text site-border-color btn btn-outline-primary rounded-0  text-decoration-none bg-transparent  btn-padding md-text fw-lighter">
                        <img loading="lazy" class="img-invert" src="{{asset('images/nav-bar/discrod.png')}}" width="20" alt="discord">
                    Discord</a>
                </li>
                <li class="nav-item mb-md-0 mb-2">
                    <a class="nav-light-text site-border-color btn btn-outline-primary rounded-0  text-decoration-none bg-transparent  btn-padding md-text fw-lighter" data-bs-toggle="modal" data-bs-target="#loginModal" href="#">
                        <i class="fa fa-gbp px-1" aria-hidden="true"></i>
                        Sell Now
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
