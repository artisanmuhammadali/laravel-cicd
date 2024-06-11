<form action="{{route('user.transaction.detail')}}" method="post">
@csrf
    <input type="hidden" name="id" value="{{$item->id}}">
    <button type="submit" target="_blank" class="btn btn-outline-warning me-3 waves-effect " title="Transaction Detail">
        <i class="fa fa-bars"></i>
    </button>
</form>