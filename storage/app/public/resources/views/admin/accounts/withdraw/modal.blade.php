<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Payout Request</h5>
        <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form action="{{route('admin.account.withdraw.update')}}" method="post" enctype="multipart/form-data" class="submit_form">
        @csrf
        <input type="hidden" name="id" value="{{$item->id ?? ""}}">
        <div class="modal-body">
            <label>Amount</label>
            <input class="form-control title_box" name="name" value="{{$item->amount ?? ""}}" readonly type="text">
            <label>Status</label>
            <select name="status" class="form-select payoutOption" required>
                <option class="form-control" value="approved">Approve</option>
                <option class="form-control" value="rejected">Reject</option>
            </select>
            <div class="payoutBody"></div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>