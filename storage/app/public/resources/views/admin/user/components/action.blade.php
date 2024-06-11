<div class="d-flex">
    <a href="{{route('admin.user.detail',[$item->id , 'info'])}}" target="_blank" class="btn btn-outline-warning me-1 waves-effect " data-bs-toggle="tooltip" data-bs-placement="top" title="Detail" data-bs-original-title="User Detail"><i class="fa fa-bars"></i></a>
    <a href="{{route('admin.user.email',[$item->id])}}" target="_blank" class="btn btn-outline-info me-1 waves-effect " data-bs-toggle="tooltip" data-bs-placement="top" title="Email" data-bs-original-title="Email"><i class="fa fa-envelope" aria-hidden="true"></i></a>
    @php($isChat = $isChat ?? false)
    @if($isChat)
    <a href="{{route('admin.mtg.conversation',$item->id)}}" target="_blank" class="btn btn-outline-success me-1 waves-effect " data-bs-toggle="tooltip" data-bs-placement="top" title="CHat" data-bs-original-title="CHat"><i class="fa fa-comments"></i></a>
    @endif
</div>