<div class="modal fade" id="dob" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered " data-select2-id="37">
        <div class="modal-content" data-select2-id="36">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('user.profile.update.info')}}" class="submit_form" method="POST">
                @csrf
                <input type="hidden" name="table_name" value="users">
                <div class="modal-body pb-5 px-sm-4 mx-50">
                    <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Update Date of Birth</h1>
                    <div class="col-12 text-center position-relative">
                        <input type="date" class="form-control" placeholder="18/11/2020"  value="{{$auth->dob}}" name="dob">
                    </div>
                    <button type="submit" class="btn btn-primary me-1 mt-2 waves-effect waves-float waves-light">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>