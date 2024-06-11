
<div class="modal fade" id="announcementModal" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Select Announcement Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.announcement.view')}}" method="GET" class="text-center">
                    @csrf
                    <select name="type" class="form-select">
                        <option value="simple">Simple</option>
                        <option value="timer">Countdown Timer</option>
                    </select>
                    <button type="submit" style="float: right;" class="btn btn-primary waves-effect waves-float mt-2 waves-light">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>