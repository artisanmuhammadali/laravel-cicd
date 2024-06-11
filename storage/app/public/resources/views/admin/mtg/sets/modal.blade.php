
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header bg-transparent">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body px-sm-5 mx-50 pb-5">
            @if(request()->type != "date")
            <h1 class="text-center mb-1" id="addNewCardTitle">Active Set</h1>
            <!-- form -->
            <form action="{{ route('admin.mtg.sets.active',$id) }}" method="GET">
                <div class="col-12">
                    <label class="form-label" for="modalEditUserFirstName">Type</label>
                    <select id="modalEditUserStatus" class="form-select" name="type" aria-label="Default select example" aria-invalid="false">
                        <option selected=""> SelectType</option>
                        <option value="expansion">Expansion</option>
                        <option value="special">Special</option>
                        <option value="child">Child</option>
                    </select>
                </div>
                <div class="col-12 text-center mt-2 pt-50">
                    <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light">Submit</button>
                    <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                    </button>
                </div>
            </form>
            @else
            <form action="{{ route('admin.mtg.sets.update',$id) }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="released_at">
                <h1 class="text-center mb-1" id="addNewCardTitle">Update Release Date</h1>
                <input type="date" name="released_at" class="form-control" value="{{$set->released_at}}">
                <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light mt-1">Submit</button>
            </form>
            @endif
        </div>
    </div>
</div>
