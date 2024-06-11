
@foreach($messages as $item)
@if($item->user_id == Auth::user()->id)
<div class="chat">
    <div class="chat-body">
        <div class="chat-content">
            <p>{{$item->message}}</p>
        </div>
    </div>
</div>
@else
<div class="chat chat-left">
    <div class="chat-body">
        <div class="chat-content">
            <p>{{$item->message}}</p>
        </div>
    </div>
</div>
@endif
@endforeach
