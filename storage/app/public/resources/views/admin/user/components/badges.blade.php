@if($item == 'personal')
    <span class="badge bg-secondary text-capitalize">{{$item}}</span>
@elseif($item == 'business')
    <span class="badge bg-primary text-capitalize">{{$item}}</span>
@elseif($item == 'buyer')
    <span class="badge bg-success text-capitalize">{{$item}}</span>
@elseif($item == 'seller')
    <span class="badge bg-warning text-capitalize">{{$item}}</span>
@else
    <span class="badge bg-info text-capitalize">{{$item}}</span>
@endif
