<div class="modal fade" id="deleteUser"aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">Restore User</h1>
                    <hr>
                    <p>Are you sure to restore that user.</p>
                </div>
                <hr>
                <div class="col-12 d-flex justify-content-end">
                    <a class="btn btn-success" href="{{route('admin.user.restore',$user->id)}}">Restore</a>
                </div>
            </div>
        </div>
    </div>
</div>
