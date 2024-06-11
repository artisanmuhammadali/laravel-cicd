<div class="chat-navbar">
    <header class="chat-header">
        <div class="d-flex align-items-center">
            <div class="sidebar-toggle d-block d-lg-none me-1">
                <i data-feather="menu" class="font-medium-5"></i>
            </div>
            @php($typee = $typee ?? null)
            @if($typee == 'custom')
            <div class="avatar avatar-border user-profile-toggle m-0 me-1">
                <a target="_blank" href="{{route('profile.index',$current_user->user_name)}}">
                    <img class="reveiver_image" src="{{$current_user->main_image}}" alt="avatar" height="36"
                        width="36" />
                </a>
            </div>
            <a target="_blank" href="{{route('profile.index',$current_user->user_name)}}">
                <h6 class="mb-0 reveiver_name">{{$current_user->full_name}}</h6>
            </a>
            @else
            <div class="avatar avatar-border user-profile-toggle m-0 me-1">
                <a target="_blank" href="{{route('admin.user.detail',[$conversation->sender->id , 'info'])}}">
                    <img class="reveiver_image" src="{{$conversation->sender->main_image}}" alt="avatar" height="36"
                    width="36" />
                </a>
            </div>
            <a target="_blank" href="{{route('admin.user.detail',[$conversation->sender->id , 'info'])}}">
                <h6 class="mb-0 reveiver_name">{{$conversation->sender->full_name}}</h6> 
                <!-- <span class="fs-9 text-black">Sender</span>  -->
            </a>
            <div class="ml-2" style="margin-right:10px;margin-left:10px"> || </div>
            <div class="avatar avatar-border user-profile-toggle m-0 me-1">
                <a target="_blank" href="{{route('admin.user.detail',[$conversation->receiver->id , 'info'])}}">
                    <img class="reveiver_image" src="{{$conversation->receiver->main_image}}" alt="avatar" height="36"
                        width="36" />
                </a>
            </div>
            <a target="_blank" href="{{route('admin.user.detail',[$conversation->receiver->id , 'info'])}}">
                <h6 class="mb-0 reveiver_name">{{$conversation->receiver->full_name}}</h6>
                <!-- <span class="fs-9 text-black">Receiver</span>  -->

            </a>
            @endif
        </div>
        
    </header>
</div>
<div class="user-chats">
    <div class="chats chat__ul">
       @include('admin.mtg.chat.messages')
    </div>
</div>
<form class="chat-app-form" action="javascript:void(0);" onsubmit="enterChat();">
    <div class="input-group input-group-merge me-1 form-send-message">
        <input type="text" class="form-control message" id="message" placeholder="Type your message or use speech to text" />
        <span class="input-group-text">
            <label for="attach-doc" class="attachment-icon form-label mb-0" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="" data-bs-original-title="Upload Image">
                <i data-feather="image" class="cursor-pointer text-secondary"></i>
                <input type="file" id="attach-doc" class="doc" accept="image/*" hidden />
                <input type="text"  class="media_input" value="" hidden />
             </label></span>
    </div>
    <button type="button" class="btn btn-primary send btnSend" id="btnSend">
        <i data-feather="send" class="d-lg-none"></i>
        <span class="d-none d-lg-block">Send</span>
    </button>
</form>
