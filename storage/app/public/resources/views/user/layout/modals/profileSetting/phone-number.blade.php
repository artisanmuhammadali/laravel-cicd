<div class="modal fade" id="phoneNumber" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" data-select2-id="37">
        <div class="modal-content" data-select2-id="36">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('user.profile.update.info')}}" class="submit_form"  method="POST">
                @csrf
                <input type="hidden" name="table_name" value="user_stores">
                <div class="modal-body pb-5 px-sm-4 mx-50">
                    <h2 class="address-title text-center mb-1" id="addNewAddressTitle">Add/Update Phone Number</h2>
                    <div class="col-12 text-center">
                        <div class="input-group mb-2">
                            <span class="input-group-text">+44</span>
                            <input type="text" pattern="\d*" maxlength="10" class="form-control link" required name="telephone" value="{{$auth->store->telephone ?? ""}}">
                        </div>
                        <button type="submit" class="btn btn-primary me-1 mt-2 waves-effect waves-float waves-light ">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>