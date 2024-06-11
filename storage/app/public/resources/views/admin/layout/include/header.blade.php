@php($auth = auth()->user())
<nav
    class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
           @php($layout = session('layout') ?? 'sun')
            @php($icon = $layout == 'sun' ? 'moon' : 'sun')
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="#"><i class="ficon"
                            data-feather="menu"></i></a></li>
            </ul>
            <ul class="nav navbar-nav bookmark-icons">

            </ul>

        </div>
        <ul class="nav navbar-nav align-items-center ms-auto">
            <!-- <li class="nav-item dropdown dropdown-notification me-25"><a class="nav-link" href="#"
                    data-bs-toggle="dropdown"><i class="ficon" data-feather="bell"></i><span
                        class="badge rounded-pill bg-danger badge-up notification_count"></span></a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
                    <li class="dropdown-menu-header">
                        <div class="dropdown-header d-flex">
                            <h4 class="notification-title mb-0 me-auto">Notifications</h4>
                        </div>
                    </li>
                    <li class="scrollable-container media-list notify_list">

                    </li>
                    <li class="dropdown-menu-footer"><a class="btn btn-primary w-100 mark_as_read" href="">Mark as Read</a></li>
                </ul>
            </li> -->
            <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link"
                    id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none"><span class="user-name fw-bolder text-capitalize">{{$auth->first_name}}</span><span
                            class="user-status text-success">{{ Auth::User()->roles[0]->name ?? 'Admin' }}</span></div><span class="avatar"><img class="round"
                            src="{{$auth->main_image}}" alt="avatar" height="40" width="40"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user"><a class="dropdown-item"
                        href="{{route('admin.profile')}}"><i class="me-50" data-feather="user"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{route('logout')}}"
                        onclick="event.preventDefault();logout();"><i
                            class="me-50" data-feather="power"></i> Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
