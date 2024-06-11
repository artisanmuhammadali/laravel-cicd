<div class="modal fade site-modal" id="expPagefilter" role="dialog"  aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content " >
            <div class="modal-header">
                <h5 class="m-auto">Filter Expansion By Format Legality</h5>   
                <div class="circle_xsm register-btn-margin ">
                    <i class="fa fa-close close_icon" data-bs-dismiss="modal" aria-label="Close"></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="row border mb-5 bg-light-blue pt-2">
                    <div class="col-md-4 mb-2">
                        <label>Format-Legal<span class="text-danger">*</span>:</label>
                    </div>
                    <div class="col-md-8">
                        <select name="format1" class="form-select format1 p-1">
                            <option class="form-control" selected disabled>Choose Format</option>
                            <option class="form-control" value="standard">standard</option>
                            <option class="form-control" value="pioneer">pioneer</option>
                            <option class="form-control" value="modern">modern</option>
                            <option class="form-control" value="legacy">legacy</option>
                            <option class="form-control" value="pauper">pauper</option>
                            <option class="form-control" value="vintage">vintage</option>
                            <option class="form-control" value="commander">commander</option>
                            <option class="form-control" value="oldschool">oldschool</option>
                            <option class="form-control" value="premodern">premodern</option>
                        </select>
                    </div>
                    <p class="fs-6 text-center my-2">Select a format to see the sets palyed in it</p>

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-site-primary px-5 m-auto apply_legality_filter" data-bs-dismiss="modal" aria-label="Close">Apply</button>
                <button class="btn btn-site-danger px-5 m-auto reset_legality_filter" data-bs-dismiss="modal" aria-label="Close">Reset Filter</button>
            </div>
        </div>
    </div>
</div>