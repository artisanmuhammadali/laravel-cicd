<div class="modal fade" id="sendInvite" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" data-select2-id="37">
        <div class="modal-content" data-select2-id="36">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-4 mx-50">
                <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Invite Friends</h1>
                <div class="col-12 text-center">
                    <input type="text" class="form-control link" value="{{route('referral.link' , $auth->user_name)}}">
                    <button type="submit" class="btn btn-primary me-1 mt-2 waves-effect waves-float waves-light copy-link">Copy</button>
                </div>
            </div>
        </div>
    </div>
</div>