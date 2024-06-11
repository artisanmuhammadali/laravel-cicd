<div class="modal fade" id="updateBulk" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Update Bulk Collection</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('user.collection.save')}}" class="submit_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="blog-edit-category">Characteristics</label>
                                <div class="demo-inline-spacing">
                                    <div class="form-check me-0 form-check-info">
                                        <input type="checkbox" class="form-check-input bulkFoil" value="1" name="foil" id="colorCheck1" >
                                        <label class="form-check-label" for="colorCheck1">Foil</label>
                                    </div>
                                    <div class="form-check me-0 form-check-secondary">
                                        <input type="checkbox" class="form-check-input bulkAltered" value="1" name="altered" id="colorCheck2"  >
                                        <label class="form-check-label" for="colorCheck2">Altered</label>
                                    </div>
                                    <div class="form-check me-0 form-check-success">
                                        <input type="checkbox" class="form-check-input bulkGraded" value="1" name="graded" id="colorCheck3"  >
                                        <label class="form-check-label" for="colorCheck3">Graded</label>
                                    </div>
                                    <div class="form-check me-0 form-check-warning">
                                        <input type="checkbox" class="form-check-input bulkSigned" value="1" name="signed" id="colorCheck6"  >
                                        <label class="form-check-label" for="colorCheck6">Signed</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="mb-2">
                                <label class="form-label">Language</label>
                                <select class="form-select BulkSelect bulkLangauge" name="language">
                                    <option selected disabled id="language">Select Language</option>
                                    @foreach(getLanguages() as $key => $lang)
                                    <option class="form-control" value="{{$key}}">{{$lang}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="blog-edit-title">Price</label>
                                <input type="number" name="price" value="" step="0.01" min="0.01" id="blog-edit-title" class="bulkPrice form-control"
                                    placeholder="1">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="blog-edit-title">Quantity</label>
                                <input type="number" name="quantity" value=" min="1" id="blog-edit-title" class="form-control bulkQuantity"
                                    placeholder="1">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="mb-2">
                                <label class="form-label"  for="blog-edit-status">Condition</label>
                                <select class="form-select BulkCondition" name="condition">
                                    <option class="form-control" value="NM">NM</option>
                                    <option class="form-control" value="LP">LP</option>
                                    <option class="form-control" value="MP">MP</option>
                                    <option class="form-control" value="HP">HP</option>
                                    <option class="form-control" value="DMG">Dmg</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 mt-50 d-flex justify-content-end">
                                <button data-form="bulk" data-link="{{route('user.collection.save')}}" type="button" class="update_cols btn btn-outline-secondary waves-effect" >Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
