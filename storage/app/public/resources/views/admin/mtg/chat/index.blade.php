@extends('admin.layout.app')
@section('title','Chat')
<link rel="stylesheet" type="text/css" href="{{asset('admin/css/pages/app-chat.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('admin/css/pages/app-chat-list.css')}}">
<style>
    .download_media{
        position: absolute;
  right: 0;
  top: 0px;
  background: black;
  padding: 10px;
    }
    .download_media a{
        color:white;
    }
    .avatar:hover{
        transform: scale(1.35);
    }
    .chat-center{
  text-align: center;
 
}
.chat-app-window .chats .chat-centerr .chat-body .chat-content{
    background: #D84A49;
  border-bottom: 2px solid black;
  /* float: none;
  margin: auto;
  width: fit-content;
  max-width: 75%;
  background-image: none !important;
  background-color: #FEF2C1 !important; */
  /* background-color: #04a46e !important; */
  /* color: #000 !important; */
}
/* .chat-app-window .chats .chat-center .chat-body{
  width: 100%;
  
} */
.time_for{
  font-size:10px;
}
.fs-9{
font-size:9px;
}
</style>
@section('content')
@php($auth = auth()->user())
<div class="app-content  content chat-application">
    <div class="content-overlay"></div>
    <div class="content-area-wrapper container-xxl p-0">
        {{-- <div class="sidebar-left">
            <div class="sidebar">
                <div class="chat-profile-sidebar">
                </div>
                <div class="sidebar-content">
                    <span class="sidebar-close-icon">
                        <i data-feather="x"></i>
                    </span>
                    <div class="chat-fixed-search">
                        <div class="d-flex align-items-center w-100">
                            <div class="input-group input-group-merge ms-1 w-100">
                                <span class="input-group-text round"><i data-feather="search"
                                        class="text-muted"></i></span>
                                <input type="text" class="form-control round" id="chat-search"
                                    placeholder="Search or start a new chat" aria-label="Search..."
                                    aria-describedby="chat-search" />
                            </div>
                        </div>
                    </div>
                    <div id="users-list" class="chat-user-list-wrapper list-group">
                        <h4 class="chat-list-title">Conversations</h4>
                        <ul class="chat-users-list chat-list media-list">
                            @foreach($conversations as $con)
                            @if($con->sender && $con->receiver)
                            @php($active = $conversation_id == $con->id ? 'active' : '')
                            <li class="spec_list {{$active}}" data-route="{{route('admin.mtg.chat')}}?id={{$con->id}}">
                                <div class="chat-info flex-grow-1">
                                    <h5 class="mb-0">{{$con->sender->full_name}} || {{$con->receiver->full_name}}</h5>
                                </div>
                            </li>
                            @endif
                            @endforeach
                            <li class="no-results">
                                <h6 class="mb-0">No Chats Found</h6>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="content-right w-100">
            <div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <div class="body-content-overlay"></div>
                    <section class="chat-app-window">
                        @if(!$id)
                        <div class="start-chat-area">
                            <div class="mb-1 start-chat-icon">
                                <i data-feather="message-square"></i>
                            </div>
                            <h4 class="sidebar-toggle start-chat-text">Start Conversation</h4>
                        </div>
                        @else
                        <div class="active-chat chatBarSide">
                            @include('admin.mtg.chat.chatBar')
                        </div>
                        @endif
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Media</h5>
        <button type="button" class="close btn btn-danger close_mod" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="" class="media-img w-100">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btnSend w-100">Send</button>
      </div>
    </div>
  </div>
</div>
@endsection
@push('js')
<script src="{{asset('admin/js/scripts/pages/app-chat.js')}}"></script>
<script src="https://www.gstatic.com/firebasejs/4.9.1/firebase.js"></script>
<script>
    function scrollChat() {
        $(".user-chats").animate({scrollTop: $(".user-chats")[0].scrollHeight}, 1);
    }
</script>
<script>
    $('.media_input').val('');
    $(document).ready(function () {
        scrollChat();   
        var readURL = function (input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#imageModal').modal('show');
                    $('.media-img').attr('src', e.target.result);
                    $('.media_input').val(e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(".doc").on('change', function () {
            readURL(this);
        });

    });

    $(document).on('click','.close_mod',function(){
        $('#imageModal').modal('hide');
        $('.media_input').val('');
    })

</script>
<script>

    

    $(document).on('click', '.spec_list', function () {
        let route = $(this).data('route');
        window.location.href = route;
    })
    var config = {
        apiKey: "{{config('services.firebase.api_key')}}",
        authDomain: "{{config('services.firebase.auth_domain')}}",
        databaseURL: "{{config('services.firebase.database_url')}}",
        projectId: "{{config('services.firebase.project_id')}}",
        storageBucket: "{{config('services.firebase.storage_bucket')}}",
        messagingSenderId: "{{config('services.firebase.messaging_sender_id')}}"
    };
    firebase.initializeApp(config);
    var convo_id = '{{ $conversation_id  }}';
    if (convo_id) {
        var initFirebase = function () {
            firebase.database().ref("/messages").on("value", function (snapshot) {
                reloadConversation();
            });
        }
    }

    var reloadConversation = function () {
        $.get("{{ route('admin.mtg.chat.get.conversation') }}?id=" + convo_id, function (messages) {
            $('.chat__ul').html(messages);
            scrollChat();
        });
    }
    $(".btnSend").click(function (e) {
        var self = $(this);
        var message = $('#message').val();
        var media = $('.media_input').val();

        if (message == '' && media == '' ) {
            toastr.error('Enter message please');
            return false;
        }
        self.attr('disabled', true);
        $.ajax({
            url: '{{ route("admin.mtg.chat.save.message") }}',
            data: {
                message: message,
                media: media,
                con_id: '{{ $conversation_id }}',
                receiver_id: '{{ $id }}',
            },
            method: 'post',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (response) {

                self.attr('disabled', false);
                $('#message').val('');
                $('#imageModal').modal('hide');
                $('.media_input').val('');
                initFirebase();
                reloadConversation();
                scrollChat();
            }
        });
    });
    initFirebase();
    reloadConversation();

</script>
<script>
    var input = document.getElementById("message");

    input.addEventListener("keyup", function (event) {

        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("btnSend").click();
        }
    });

</script>
@endpush
