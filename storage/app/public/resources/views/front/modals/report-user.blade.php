<div class="modal fade site-modal" id="reportUser" role="dialog"  aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content " >
            <div class="modal-header">
                <h5 class="m-auto text-site-primary">Report User</h5>
                <div class="circle_xsm register-btn-margin ">
                    <i class="fa fa-close close_icon" data-bs-dismiss="modal" aria-label="Close"></i>
                </div>
            </div>
            <div class="modal-body border-top">
                <form action="{{route('help')}}" class="" method="GET" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="report">
                    <input type="hidden" name="user_name" value="{{$user->user_name}}">
                    <p>
                        Are you Sure You want to report this user
                    </p>
                    <button class="btn btn-site-primary" type="submit">Sure</button>
                    <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
