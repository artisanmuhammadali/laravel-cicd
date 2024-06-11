<div class="modal fade site-modal" id="detailPgFilter" role="dialog"  aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content mt-5" >
            <div class="modal-header">
                <h5 class="m-auto">Filter</h5>   
                <div class="circle_xsm register-btn-margin ">
                    <i class="fa fa-close close_icon" data-bs-dismiss="modal" aria-label="Close"></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="row border mb-5pt-2 justify-content-center">
                    @include('front.components.collection.filter',['id1'=>'myCheckbox170','id2'=>'myCheckbox150','id3'=>'myCheckbox160','id4'=>'myCheckbox190'])
                </div>
            </div>
        </div>
    </div>
</div>