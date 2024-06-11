<div class="modal fade" id="updatePrice" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Update Collection Price</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('user.collection.update.price')}}" method="POST">
                    @csrf
                    <div class="d-flex justify-content-between">
                        <div class="col-5 col-md-5 my-2">
                            <label class="form-label">Select Operation</label>
                            <select name="operation" class="form-control operation">
                                <option value="increment">Increase</option>
                                <option value="decrement">Decrease</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-6 my-2">
                            <label class="form-label">Update Price</label>
                            <div class="input-group">
                                <input type="number" class="form-control percent" placeholder="1%" name="percent" required>
                                <span class="input-group-text" id="basic-addon2">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button data-link="{{route('user.collection.update.price')}}" type="button" class="update_cols btn btn-primary waves-effect waves-float waves-light mt-1">Apply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
