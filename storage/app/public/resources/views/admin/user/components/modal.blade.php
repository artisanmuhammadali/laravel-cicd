<div class="modal fade" id="editUser"aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">Edit User Information</h1>
                    <p>Updating user details will receive a privacy audit.</p>
                </div>
                <form id="editUserForm" class="row gy-1 pt-75" action="{{route('admin.user.edit')}}" method="post">
                    @csrf
                    <div class="col-12 col-md-6">
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <label class="form-label" for="name1">First Name</label>
                        <input type="text" id="name1" name="first_name" value="{{$user->first_name}}" class="form-control" placeholder="John" value="Gertrude" data-msg="Please enter your first name" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="name2">Last Name</label>
                        <input type="text" id="name2" value="{{$user->last_name}}" name="last_name" class="form-control" value="Barton" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="username">Username</label>
                        <input type="text" id="username" name="user_name" value="{{$user->user_name}}" class="form-control" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="dob">Date of birth</label>
                        <input type="date"  value="{{$user->dob_view}}" id="dob" name="dob" class="form-control" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="referal_percentage">Referral Percentage</label>
                        <input type="number" min="0" step="any" max="{{vsfPspConfig()->platform_fee -1}}"  value="{{$user->store->referal_percentage ?? ''}}" id="referal_percentage" name="referal_percentage" class="form-control">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="referal_limit">Referral Limit</label>
                        <input type="number"  min="0"  value="{{$user->store->referal_limit  ?? ''}}" id="referal_limit" name="referal_limit" step="any" class="form-control">
                    </div>
                    @if($user->role == 'seller' || $user->role == 'business')
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="commission_percentage">Commission Percentage</label>
                        <input type="number"  min="1" step="any"  value="{{$user->store->commission_percentage  ?? ''}}" id="commission_percentage" name="commission_percentage" class="form-control">
                    </div>
                    @endif

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="modalEditUserStatus">Status</label>
                        <select id="modalEditUserStatus" name="status" class="form-select">
                            @foreach(userStatuses() as $status)
                            <option class="text-capitalize" value="{{$status}}" {{$user->status == $status ? "selected" : ""}}>{{$status}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                            <label>User Type</label>
                            <select name="referal_type" class="form-select text-capitalize">
                                <option selected disabled>Select Referral Type</option>
                                @foreach(userReferalTypes() as $type)
                                <option class="text-capitalize" value="{{$type}}" {{$user->store->referal_type == $type ? "selected" : ""}}>{{$type}}</option>
                                @endforeach
                            </select>
                        </div>
                    <div class="col-6">
                        <input type="checkbox" name="receive_referal" id="referal" {{($user->store->receive_referal ?? '') ? "checked" : ""}}>
                        <label class="form-label" for="referal">Can recieve referral credit?</label>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="reason">Reason</label>
                        <textarea id="reason" name="reason" class="form-control" cols="30" rows="5"></textarea>
                    </div>

                    <div class="col-12 text-center mt-2 pt-50">
                        <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">
                            Discard
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
