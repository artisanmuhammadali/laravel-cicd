<div class="modal fade" id="userStatus" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" data-select2-id="37">
        <div class="modal-content" data-select2-id="36">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-4 mx-50">
                <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Account Status</h1>
                <div class="col-12 text-center">
                    @if($auth->status == 'on-holiday')
                    <p>
                        We Hope you enjoyed your free time. Ready to come back? Coming back from holiday will make your collection visible again to everyone. Please make sure everything is up to date.
                    </p>
                    <a href="{{route('user.change.status',['active'])}}" class="btn btn-primary me-1 mt-2 waves-effect waves-float waves-light ">Submit</a>
                    @else
                    <p>
                        Going on holiday makes you unable to buy or sell products. Your listed products will be removed from public view, but you can still update and modify your collection and wallet. Are you sure?
                    </p>
                    <a href="{{route('user.change.status',['on-holiday'])}}" class="btn btn-primary me-1 mt-2 waves-effect waves-float waves-light ">Submit</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>