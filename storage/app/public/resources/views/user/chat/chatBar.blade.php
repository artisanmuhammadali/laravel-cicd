<div class="chat-navbar">
    <header class="chat-header">
        <div class="d-flex align-items-center">
            <div class="sidebar-toggle d-block d-lg-none me-1">
                <i data-feather="menu" class="font-medium-5"></i>
            </div>
            <div class="avatar avatar-border user-profile-toggle m-0 me-1">
                <a target="_blank" href="{{route('profile.index',$current_user->user_name)}}">
                    <img class="reveiver_image" src="{{$current_user->main_image}}" alt="avatar" height="36"
                        width="36" />
                </a>
            </div>
            <a target="_blank" href="{{route('profile.index',$current_user->user_name)}}">
                <h6 class="mb-0 reveiver_name">{{$current_user->user_name}}</h6>
            </a>
        </div>
        
    </header>
</div>
<div class="user-chats">
    <div class="chats chat__ul">
       @include('user.chat.messages')
    </div>
</div>
<form class="chat-app-form" action="javascript:void(0);" onsubmit="enterChat();">
    <div class="input-group input-group-merge me-1 form-send-message">
        <input type="text" class="form-control message" id="message" placeholder="Type your message or use speech to text" />
        <span class="input-group-text">
            <label for="attach-doc" class="attachment-icon form-label mb-0" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="" data-bs-original-title="Upload Image">
                <i data-feather="image"   class="waves-effect cursor-pointer text-secondary"></i>
                <input type="file" id="attach-doc" class="doc" accept="image/*" hidden />
                <input type="text"  class="media_input" value="" hidden />
             </label></span>
    </div>
    <button type="button" class="btn btn-primary send btnSend" id="btnSend">
        <i data-feather="send" class="d-lg-none"></i>
        <span class="d-none d-lg-block">Send</span>
    </button>
</form>
