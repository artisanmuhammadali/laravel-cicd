<div class="modal fade" id="sendInvite" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" data-select2-id="37">
        <div class="modal-content" data-select2-id="36">
            <div class="modal-header bg-transparent">
                <h3 class="address-title text-center mb-1" id="addNewAddressTitle">Manage User Referral for {{$type}}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-4 mx-50">
                <form action="{{route('admin.user.manage')}}" method="POST">
                    @csrf
                    <input type="hidden" value="{{$type}}" name="referal_type">
                    <div class="row justify-content-between">
                        <div class="col-5">
                            <label class="small">Referral Percentage</label>
                            <input type="number" step="any" max="{{vsfPspConfig()->platform_fee -1}}" value=""  name="referal_percentage" required class="form-control">
                        </div>
                        <div class="col-7 d-flex align-items-center">
                            <input class="form-check-input me-50" type="checkbox" name="receive_referal" id="referal">
                            <label class="form-label" for="referal">Can recieve referral credit?</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary me-1 mt-2 waves-effect waves-float waves-light">Apply</button>
                </form>
            </div>
        </div>
    </div>
</div>