<!-- <h4 class="chat-list-title">Chats</h4> -->
<ul class="chat-users-list chat-list media-list">
    @foreach($chats as $con)
    @php($active = $id == $con->id ? 'active' : '')
    <li class="spec_list {{$active}}" data-route="{{route('user.chat')}}?id={{$con->id}}">
        <span class="avatar"><img src="{{$con->main_image}}" height="42" width="42" alt="Generic placeholder image" />
        </span>
        <div class="chat-info flex-grow-1">
            <h5 class="mb-0">{{$con->user_name}}</h5>
        </div>
    </li>
    @endforeach
    <li class="no-results">
        <h6 class="mb-0">No Chats Found</h6>
    </li>
</ul>
@if($request->keyword)
<h4 class="chat-list-title">Contacts</h4>
<ul class="chat-users-list contact-list media-list">
    @foreach($contacts as $con)
    @php($active = $id == $con->id ? 'active' : '')
    <li class="spec_list {{$active}}" data-route="{{route('user.chat')}}?id={{$con->id}}">
        <span class="avatar">
            <img src="{{$con->main_image}}" height="42" width="42" alt="Generic placeholder image" />
        </span>
        <div class="chat-info">
            <h5 class="mb-0">{{$con->user_name}}</h5>
        </div>
    </li>
    @endforeach
    <li class="no-results">
        <h6 class="mb-0">No Contacts Found</h6>
    </li>
</ul>
@endif
