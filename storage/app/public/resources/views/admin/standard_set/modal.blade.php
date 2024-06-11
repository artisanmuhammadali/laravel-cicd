<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Standard Set</h5>
        <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form action="{{route('admin.mtg.standard.set.store')}}" method="post" enctype="multipart/form-data" class="submit_form">
        @csrf
        <input type="hidden" name="id" value="{{$item->id ?? ""}}">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <label>Set Name</label>
                    <select name="mtg_set_id"  class="form-control select2 required">
                        <option class="from-conrtol" value="">Select one..</option>
                        @foreach($sets as $set)
                        <option class="form-control" value="{{$set->id}}" >{{$set->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
<script src="{{asset('admin/js/scripts/forms/form-select2.js')}}"></script>