<div class="modal fade" id="deletedAccount" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="exampleModalCenterTitle">Delete Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @if(canDeleteAccount() == 0)
            <div class="modal-body">
                <p>
                    Are you sure you want to delete your account?
                </p>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary suspend-user waves-effect" href="{{route('user.destroy',$auth->id)}}" title="Delete Account">Delete</a>
            </div>
            @else
            <div class="modal-body">
                <p>
                    You cannot delete your account type until you have completed any open orders.
                </p>
            </div>
            @endif
        </div>
    </div>
</div>