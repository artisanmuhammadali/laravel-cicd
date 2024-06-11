<div class="modal fade" id="editLegalityModal" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close btn-clear" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-4">
                <form action="{{route('admin.mtg.products.legality')}}" method="post">
                    @csrf
                    <input type="hidden" value="edit" name="type">
                    <input type="hidden" value="{{$item->id}}" name="id" >
                    <h5 class="text-center mb-1 text-capitalize" id="shareProjectTitle">Update Card Legalities</h5>
                    @if($item->legalities && $item->legalities != '[]')
                    <div class="row">
                        @foreach (json_decode($item->legalities) as $key=> $legality )
                        @if($legality == "legal")
                        <div class="form-group col-md-3">
                            <label for="{{$key}}"  class="small text-capitalize">{{$key}}</label>
                            <input type="checkbox"  name="legalities[{{$key}}]" checked id="{{$key}}">
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <button class="btn btn-primary mt-1 ms-auto" type="submit">Apply</button>
                    @else
                    <h5 class="text-center mb-1 text-capitalize" id="shareProjectTitle">Legalities Not found</h5>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
