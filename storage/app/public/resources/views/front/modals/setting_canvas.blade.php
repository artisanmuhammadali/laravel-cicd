<div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header bg_dark_shark">
        <h5 class="offcanvas-title text-white" id="offcanvasExampleLabel ">Page Setting</h5>
        <button type="button" class="btn-close text-reset bg-white " data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
        <!-- <hr> -->
    <div class="offcanvas-body">
        <form action="{{route('admin.mtg.cms.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- <div class="card"> -->
                    <div class="col-md-12 append_setting_form_data">

                    </div>
                <!-- </div> -->
            </div>
        </form>
    </div>
</div>
