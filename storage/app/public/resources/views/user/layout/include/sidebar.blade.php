<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow  bg-site-primary {{$auth->role == 'buyer' && $auth->store->mango_id == null  ? 'mar_fix' : 'mt-5'}}"
    data-scroll-to-active="true">
    <li class="nav-item nav-toggle text-end d-flex justify-content-end">
        <a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-x d-block d-xl-none text-primary toggle-icon font-medium-4">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-disc d-none d-xl-block collapse-toggle-icon primary font-medium-4">
                <circle cx="12" cy="12" r="10"></circle>
                <circle cx="12" cy="12" r="3"></circle>
            </svg>
        </a>
    </li>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main bg-site-primary mb-5" id="main-menu-navigation"
            data-menu="menu-navigation">
            <li
                class="d-sm-none d-none d-md-block @if(url()->current() == route('user.account') || url()->current() == route('user.change.password') ) active @endif nav-item">
                <a class="d-flex align-items-center text-white" href="{{ route('user.account') }}">
                    <i data-feather='grid'></i>Basic Information</a>
            </li>
            <li class="@routeis('user.address.index') active @endrouteis nav-item"><a
                    class="d-flex align-items-center text-white" href="{{ route('user.address.index') }}">
                    <i data-feather='map'></i>Address</a>
            </li>
            @if($auth->role != 'buyer')
            <li class=" d-sm-none d-none d-md-block @routeis('user.collection.*') active @endrouteis mt-25"><a
                    class="d-flex align-items-center text-white" href="#">
                    <i data-feather='briefcase'></i>My Collection</a>
                <ul class="menu-content">
                    @foreach(getCardRanges() as $key => $range)
                    @php($routee = $range == 'mtg' ? route('user.collection.index') : route('user.collection.'.$range.'.index'))
                    @php($active = url()->current() ==  $routee ? 'active' : '')
                    <li class="{{$active }}"><a
                            class="d-flex align-items-center text-white"
                            href="{{ $routee }}"><i data-feather="circle"></i>
                            {{$key}}</a>
                    </li>
                    @endforeach
                </ul>
            </li>
            @endif
            @if($auth->store->mango_id)
            <li class=" d-sm-none d-none d-md-block @routeis('user.order.*') active @endrouteis mt-25"><a
                    class="d-flex align-items-center text-white" href="#">
                    <i data-feather='package'></i>My Orders</a>
                <ul class="menu-content">
                    <li class="@if(url()->current() == route('user.order.index',['buy','pending'])) active @endif"><a
                            class="d-flex align-items-center text-white"
                            href="{{ route('user.order.index',['buy','pending']) }}"><i data-feather="circle"></i>
                            Purchases</a>
                    </li>
                    @if($auth->role != "buyer")
                    <li class="@if(url()->current() == route('user.order.index',['sell','pending'])) active @endif"><a
                            class="d-flex align-items-center text-white"
                            href="{{ route('user.order.index',['sell','pending']) }}"><i data-feather="circle"></i>
                            Sales</a>
                    </li>
                    @endif
                </ul>
            </li>
            {{--<li class="@routeis('user.transaction.*') active @endrouteis mt-25"><a class="d-flex align-items-center text-white" href="#">
                <i data-feather='dollar-sign'></i>Banking</a>
                <ul class="menu-content">
                    <li class="@if(url()->current() == route('user.transaction.list')) active @endif"><a class="d-flex align-items-center text-white"
                            href="{{ route('user.transaction.list') }}"><i data-feather="circle"></i>Wallet &
            Transactions</a>
            </li>
            @if($auth->role != "buyer")
            <li class="@if(url()->current() == route('user.transaction.account.card')) active @endif"><a
                    class="d-flex align-items-center text-white" href="{{ route('user.transaction.account.card') }}"><i
                        data-feather="circle"></i>Account & Cards</a>
            </li>
            @endif
        </ul>
        </li>--}}
        <li class="d-sm-none d-none d-md-block @routeis('user.transaction.list') active @endrouteis nav-item"><a
                class="d-flex align-items-center text-white" href="{{ route('user.transaction.list') }}">
                <i data-feather='dollar-sign'></i>Banking</a>
        </li>
        @endif
        <li class="@routeis('user.block.index') active @endrouteis nav-item"><a
                class="d-flex align-items-center text-white" href="{{ route('user.block.index') }}">
                <i data-feather='alert-octagon'></i>Blocked Users</a>
        </li>
        <li class="@routeis('user.favourite.index') active @endrouteis nav-item"><a
                class="d-flex align-items-center text-white" href="{{ route('user.favourite.index') }}">
                <i data-feather='bookmark'></i>Favourite Users</a>
        </li>
        <li class="@routeis('user.referral') active @endrouteis nav-item"><a
                class="d-flex align-items-center text-white" href="{{ route('user.referral') }}">
                <i data-feather='git-branch'></i>Referral Users</a>
        </li>
        <li class="@routeis('user.chat') active @endrouteis nav-item"><a class="d-flex align-items-center text-white"
                href="{{ route('user.chat') }}">
                <i data-feather='message-square'></i>Chat</a>
        </li>
        @if($auth->store->mango_id)
        <li class="@routeis('user.account.stats.index') active @endrouteis nav-item"><a
                class="d-flex align-items-center text-white" href="{{ route('user.account.stats.index') }}">
                <i data-feather='bar-chart-2'></i>Account Stats</a>
        </li>
        @endif
        <li class="@routeis('user.support-tickets.list') active @endrouteis nav-item"><a
                class="d-flex align-items-center text-white" href="{{ route('user.support-tickets.list') }}">
                <i data-feather='headphones'></i>Support Tickets</a>
        </li>
        <li class="nav-item mt-2">
            <a href="{{route('profile.index',[$auth->user_name,'single']).'?view=public_profile'}}" target="_blank"
                class="btn btn-primary d-flex align-items-center text-white"><i class="fa fa-user"></i> View Public
                Profile</a>
        </li>
        <li class=" nav-item mt-2 d-md-none d-flex">
            <a class="btn btn-primary d-flex align-items-center text-white w-100"
                onclick="event.preventDefault();logout();" href="{{ route('logout') }}">
                <i class="fa fa-sign-out"></i>Logout</a>
        </li>
        </ul>
    </div>
</div>
