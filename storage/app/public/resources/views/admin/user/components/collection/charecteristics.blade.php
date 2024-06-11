<span class="badge bg-primary">{{$item->condition}}</span>
@if($item->foil)
<span class="badge bg-info">Foil</span>
@endif
@if($item->signed)
<span class="badge bg-warning">Signed</span>
@endif
@if($item->graded)
<span class="badge bg-success">Graded</span>
@endif
@if($item->altered)
<span class="badge bg-secondary">Altered</span>
@endif