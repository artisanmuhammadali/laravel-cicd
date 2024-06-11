<div class="modal fade" id="editLegalityModal" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close btn-clear" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-4">
                <form action="{{route('admin.mtg.sets.legality')}}" method="post">
                    @csrf
                    <input type="hidden" value="edit" name="type">
                    <input type="hidden" value="{{$currentSet->id}}" name="id" >
                    <h5 class="text-center mb-1 text-capitalize" id="shareProjectTitle">Update Set Legalities</h5>
                    @if(count(mtgSetLegality($currentSet->id)) > 0)
                    <div class="row">
                        @foreach (mtgSetLegality($currentSet->id) as $legality )
                        <div class="form-group col-md-3">
                            <label for="{{$legality}}"  class="small">{{$legality}}</label>
                            <input type="checkbox"  name="legalities[{{$legality}}]" checked id="{{$legality}}">
                        </div>
                        @endforeach
                    </div>
                    <button class="btn btn-primary mt-1 ms-auto" type="submit">Apply</button>
                    @else
                    <h5 class="text-center mb-1 text-capitalize" id="shareProjectTitle">Legalities Not Found</h5>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
