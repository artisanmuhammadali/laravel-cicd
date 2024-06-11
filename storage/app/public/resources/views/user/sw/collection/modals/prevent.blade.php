<div class="modal fade preventCollection" id="preventCollection" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Collection Alert</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('user.collection.update.price')}}" method="POST">
                    @csrf
                    <input type="hidden"  name="type" value="popup">
                    <div class="justify-content-between">
                        <p>You have inactive items. These items will not be listed on the website until you publish them.</p>
                        <div class="form-group">
                            <label for="show_inactive_modal">Do not show this pop-up again</label>
                            <input type="checkbox" id="show_inactive_modal" name="show_inactive_modal">
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary waves-effect waves-float waves-light mt-1 show_form_btn d-none">Ok</button>
                    </div>
                </form>
                <div class="col-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary waves-effect waves-float waves-light mt-1 close_form_btn"  data-bs-dismiss="modal" aria-label="Close">Ok</button>
                </div>
            </div>
        </div>
    </div>
</div>
