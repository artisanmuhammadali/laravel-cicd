@if($type == 'debit')
    <span class="badge bg-info text-capitalize">{{$type}}</span>
@elseif($type == 'fee')
    <span class="badge bg-primary text-capitalize">{{$type}}</span>
@elseif($type == 'refund')
    <span class="badge bg-secondary text-capitalize">{{$type}}</span>
@elseif($type == 'payin')
    <span class="badge bg-warning text-capitalize">{{$type}}</span>
@elseif($type == 'cancelled')
    <span class="badge bg-danger text-capitalize">{{$type}}</span>
@elseif($type == 'payout')
    <span class="badge bg-dark text-capitalize">{{$type}}</span>
@else
    <span class="badge bg-success text-capitalize">{{$type}}</span>
@endif


