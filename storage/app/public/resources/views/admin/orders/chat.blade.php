
@foreach($messages as $item)
@if($item->user_id == $order->seller->id)
<div class="chat">
    <div class="chat-body">
        <div class="chat-content shadow-none d-flex" style="background: transparent;">
            <div class="chat-content">
                <p>{{$item->message}}</p>
            </div>
            <div class="d-flex">
                <img src="{{$order->seller->main_image}}" class="me-75" height="20"
                    width="20" alt="Angular">
                <span class="fw-bold text-black">{{$order->seller->user_name}}</span>
            </div>
        </div>
        
    </div>
</div>
@else
<div class="chat chat-left">
    <div class="chat-body">
        <div class="chat-content shadow-none d-flex" style="background: transparent;">
            <div class="d-flex">
                <img src="{{$order->buyer->main_image}}" class="me-75" height="20"
                    width="20" alt="Angular">
                <span class="fw-bold">{{$order->buyer->user_name}}</span>
            </div>
            <div class="chat-content">
                <p>{{$item->message}}</p>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach
