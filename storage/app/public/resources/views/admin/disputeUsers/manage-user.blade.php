<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change {{$user->user_name}} Account Status</h5>
        <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form action="{{route('admin.dispute.update.user')}}" method="post" enctype="multipart/form-data" class="submit_form">
        @csrf
        <input type="hidden" name="id" value="{{$user->id ?? ""}}">
        <div class="modal-body">
            <div class="col-12">
                <label class="form-label" for="modalEditUserStatus">Status</label>
                <select id="modalEditUserStatus" name="status" class="form-select">
                    <option value="inactive">Inactive</option>
                    <option value="locked">locked</option>
                    <option value="ban">Ban</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>