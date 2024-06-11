<div class="modal fade site-modal" id="detailPgFilter" role="dialog"  aria-modal="true">
    <div class="modal-dialog  {{ $type == "single-cards" ? 'modal-xl' : '' }}">
        <div class="modal-content mt-5" >
            <div class="modal-header">
                <h3 class="text-site-primary text-center fw-bolder m-auto">Filter</h3>
                <div class="circle_xsm register-btn-margin ">
                    <i class="fa fa-close close_icon" data-bs-dismiss="modal" aria-label="Close"></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="row mb-5pt-2 justify-content-center">
                    @include('front.components.mtg.listings.filter')
                </div>
            </div>
        </div>
    </div>
</div>