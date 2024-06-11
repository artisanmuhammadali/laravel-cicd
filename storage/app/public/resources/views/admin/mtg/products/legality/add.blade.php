<div class="modal fade" id="legalityModal" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close btn-clear" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-4">
            @if(count(mtgCardAvaiLegality($item->id)) > 0)
                <form action="{{route('admin.mtg.products.legality')}}" method="post">
                    @csrf
                    <input type="hidden" value="add" name="type">
                    <input type="hidden" value="{{$item->id}}" name="id" >
                    <h5 class="text-center mb-1 text-capitalize" id="shareProjectTitle">These are all available Legalities for this Card</h5>
                    <div class="row">
                        @foreach (mtgCardAvaiLegality($item->id) as $legality )
                        <div class="form-group col-md-3">
                            <label for="{{$legality}}"  class="small">{{$legality}}</label>
                            <input type="checkbox"  name="legalities[{{$legality}}]"  id="{{$legality}}">
                        </div>
                        @endforeach
                    </div>
                    <button class="btn btn-primary mt-1 ms-auto" type="submit">Apply</button>
                </form>
            @else
                <h5 class="text-center mb-1 text-capitalize" id="shareProjectTitle">Legalities Not Found</h5>
            @endif
            </div>
        </div>
    </div>
</div>
