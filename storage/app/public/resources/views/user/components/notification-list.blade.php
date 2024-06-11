<li class="dropdown-menu-header">
    <div class="dropdown-header d-flex">
        <h4 class="notification-title mb-0 me-auto">Notifications</h4>
    </div>
</li>
<li class="scrollable-container media-list  mt-2">
    @if(getUserNotifications("count") > 0)
    @foreach(getUserNotifications("total") as $notification)
    <a class="d-flex text-decoration-none px-1 text-primary py-1 notify-hover border" href="{{route('user.notification.index',$notification->id)}}">
        <div class="list-itemalign-items-start w-100">
            <div class="d-flex">
            @if($notification->type == "message")
                <i class="fa fa-comments  me-1 mt-25" aria-hidden="true"></i>
            @else
            <i class="fa fa-archive  me-1 mt-25 " aria-hidden="true"></i>
            @endif
                <p class="media-heading fs-6 m-0 text-black fw-bolder">{{$notification->sender_name ?? "Admin"}}</p>
                <p class="sm-text mt-25 text-muted mb-0 ms-auto">{{$notification->created_at->diffForHumans()}}</p>
            </div>
            <p class="media-heading md-text  m-0 ps-2">
                {{$notification->message}}
                @if($notification->model && $notification->type == "message")
                <span class="text-black">{!! Str::limit($notification->model->message, 4,'..') !!}</span>
                @endif
            </p>
        </div>
    </a>
    @endforeach
    @else
    <p class="mb-0 small text-muted text-center py-2">No Notification Available</p>
    @endif
</li>
<li class="dropdown-menu-footer">
    <div class="dropdown-footer d-flex mt-1">
        <a href="{{getUserNotifications("count") == 0 ? '#' : route('user.notification.read.all')}}"  class="btn btn-primary m-auto">Mark all as Read</a>
    </div>
</li>
