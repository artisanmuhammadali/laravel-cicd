<div class="modal fade" id="updateEmail" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" data-select2-id="37">
        <div class="modal-content" data-select2-id="36">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('user.profile.update.info')}}" class="submit_form" method="POST">
                @csrf
                <input type="hidden" name="table_name" value="users">
                <div class="modal-body pb-5 px-sm-4 mx-50 text-center">
                    <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Update Email</h1>
                    <div class="col-12 text-center">
                        <input type="text" class="form-control link" name="email" value="{{$auth->email}}">
                    </div>
                    <button type="submit" class="btn btn-primary me-1 mt-2 waves-effect waves-float waves-light">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>