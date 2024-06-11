@foreach($messages as $item)
@if($item->user_id == $conn->sender_id)
@if($item->file)
<div class="chat mb-2">
    <!-- <div class="chat-avatar">
        <span class="avatar box-shadow-1 cursor-pointer">
            <a href="{{route('user.account')}}">
                <img src="{{$item->user->main_image}}" alt="avatar" height="36" width="36">
            </a>
        </span>
    </div> -->
    <div class="chat-body">
        <div class="chat-content position-relative">
            <div class="download_media"><a href="{{$item->media}}" target="_blank"><i class="fa fa-download"></i></a>
            </div>
            <img src="{{$item->media}}" class="transit_hover" alt="avatar" height="100">
            <div>
                <p class="time_for">{{customDate($item->created_at,'Y/m/d H:i')}}</p>
            </div>
        </div>
    </div>
</div>
@endif
@if($item->message)
<div class="chat mb-2">
    <!-- <div class="chat-avatar">
        <span class="avatar box-shadow-1 cursor-pointer">
            <a href="{{route('user.account')}}">
                <img src="{{$item->user->main_image}}" alt="avatar" height="36" width="36">
            </a>
        </span>
    </div> -->
    <div class="chat-body">
        <div class="chat-content">
            <p>{{$item->message}}</p>
            <div>
                <p class="time_for">{{customDate($item->created_at,'Y/m/d H:i')}}</p>
            </div>
        </div>

    </div>
</div>
@endif
@else
@php($class = $item->user->role == 'admin' ? 'chat-centerr' : 'chat-left')
@if($item->file)
<div class="chat {{$class}} ">
    @if($class != 'chat-centerr')
    <!-- <div class="chat-avatar">
        <span class="avatar box-shadow-1 cursor-pointer">
            <a target="_blank" href="{{route('profile.index',$item->user->user_name)}}">
                <img src="{{$item->user->main_image}}"  alt="avatar" height="36" width="36">
            </a>
        </span>
    </div> -->
    @endif
    <div class="chat-body ">
        <div class="chat-content position-relative ">
            <div class="download_media"><a href="{{$item->media}}" target="_blank"><i class="fa fa-download"></i></a>
            </div>
            <img src="{{$item->media}}" class="transit_hover" alt="avatar" height="100">
             @if($class != 'chat-centerr')
                <p class="time_for">{{customDate($item->created_at,'Y/m/d H:i')}}</p>
            @else
            <p class="time_for">( {{$item->user->full_name}} {{customDate($item->created_at,'Y/m/d H:i')}} )</p>
            @endif
        </div>
    </div>
</div>
@endif
@if($item->message)
<div class="chat {{$class}} ">
    @if($class != 'chat-centerr')
    <!-- <div class="chat-avatar">
        <span class="avatar box-shadow-1 cursor-pointer">
            <a target="_blank" href="{{route('profile.index',$item->user->user_name)}}">
                <img src="{{$item->user->main_image}}"  alt="avatar" height="36" width="36">
            </a>
        </span>
    </div> -->
    @endif
    <div class="chat-body ">
        <div class="chat-content ">
            <p>{{$item->message}}</p>
            <div>
            @if($class != 'chat-centerr')
                <p class="time_for">{{customDate($item->created_at,'Y/m/d H:i')}}</p>
            @else
            <p class="time_for">( ADMIN MESSAGE: {{$item->user->full_name}} {{customDate($item->created_at,'Y/m/d H:i')}} )</p>
            @endif
            </div>
        </div>
    </div>
</div>
@endif
@endif
@endforeach
