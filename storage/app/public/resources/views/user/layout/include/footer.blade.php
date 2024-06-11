<div class="col-12   bg-site-primary px-2 py-1">
    <div class="row w-100">
        <div class="col d-flex d-grid justify-content-sm-end justify-content-center pe-xxl-0">
            <div class="bottom-nav-support-div"></div>
            <nav class="bottom-nav d-block d-md-none bg_dark_shark">
                <div class="bottom-nav-box">
                    <ul class="bottom-nav-container p-0 m-0">
                        <li class="bottom-nav-item" title="Basic Information">
                            <a href="{{ route('user.account') }}" class="bottom-nav-item-link">
                                <div class="bottom-nav-item-icon">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    
                                </div>
                                {{-- <span class="bottom-nav-item-text">Account</span> --}}
                            </a>
                        </li>
                        @if($auth->role != 'buyer')
                        <li class="bottom-nav-item " title="Collections">
                            <a href="#" class="bottom-nav-item-link" id="dropdownMenuButton3" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <div class="bottom-nav-item-icon">
                                    <i data-feather='briefcase'></i>
                                </div>
                            </a>
                            <ul class="dropdown-menu bg_dark_shark bar" style="width:max-content" aria-labelledby="dropdownMenuButton3"
                                data-popper-placement="top-end">
                                @foreach(getCardRanges() as $key => $range)
                                @php($routee = $range == 'mtg' ? route('user.collection.index') : route('user.collection.'.$range.'.index'))
                                <li><a class="d-flex align-items-center "
                                    href="{{ $routee }}"> {{$key}}</a>
                                </li>
                                <hr>
                                @endforeach
                            </ul>
                        </li>
                        @endif
                    
                        <li class="bottom-nav-item " title="Orders">
                            <a href="#" class="bottom-nav-item-link" id="dropdownMenuButton3" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <div class="bottom-nav-item-icon">
                                    <i data-feather='package'></i>
                                </div>
                            </a>
                            <ul class="dropdown-menu bg_dark_shark bar" aria-labelledby="dropdownMenuButton3"
                                data-popper-placement="top-end">
                                <li><a class="d-flex align-items-center "
                                    href="{{ route('user.order.index',['buy','pending']) }}"> Purchases</a>
                                </li>
                                @if($auth->role != "buyer")
                                <hr>
                                <li><a class="d-flex align-items-center"
                                    href="{{ route('user.order.index',['sell','pending']) }}"> Sales</a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        <li class="bottom-nav-item" title="Account">
                            <a href="{{ route('user.transaction.list') }}" class="bottom-nav-item-link">
                                <div class="bottom-nav-item-icon">
                                    <i class="fa fa-wallet"></i>
                                </div>
                                {{-- <span class="bottom-nav-item-text">Account</span> --}}
                            </a>
                        </li>
                        
                        <li class="bottom-nav-item" title="Logout">
                            {{-- <a href="{{route('index')}}" class="bottom-nav-item-link">
                                <div class="bottom-nav-item-icon">
                                        <i  class="fa fa-home" aria-hidden="true"></i>
                                </div>
                            </a> --}}
                            <a class="bottom-nav-item-link pt-75" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <i data-feather='bell' style="width: 30px ; height: 30px"></i>
                                <span
                                    class=" bell_noti badge rounded-pill cart-span  bg-site-primary-light">{{getUserNotifications("count")}}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end noti_min_wid">
                                @include('user.components.notification-list')
                            </ul>
                        </li>
                     
                    
                        <li class="bottom-nav-item" title="Menu">
                            <a href="{{route('user.account')}}" class="bottom-nav-item-link nav-link menu-toggle">
                                <div class="bottom-nav-item-icon">
                                    <i class="fa fa-bars bottom-toggle-menu-hor menu_btnn" aria-hidden="true"></i>
                                </div>
                                {{-- <span class="bottom-nav-item-text">Logout</span> --}}
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

</div>

<footer class="footer_section d-sm-none d-none d-md-block">
    <div class="container-fluid">
        @include('front.include.footer')
    </div>
</footer>
