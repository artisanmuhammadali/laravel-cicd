<div class="modal fade" id="editLanguageModal" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close btn-clear" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-4">
                <form action="{{route('admin.mtg.products.languages')}}" method="post">
                @csrf
                    <input type="hidden" value="language" name="type">
                    <input type="hidden" value="{{$item->id}}" name="id" >
                    <h5 class="text-center mb-1 text-capitalize" id="shareProjectTitle">Update Set Languages</h5>
                    @if($item->card_languages)
                    <div class="row">
                    @foreach ($item->card_languages as $key=> $value )
                        <div class="form-group col-md-3">
                            <label for="{{$key}}"  class="small">{{$value}}</label>
                            <input type="checkbox"  name="languages[{{$key}}]"  id="{{$key}}" checked>
                        </div>
                    @endforeach
                    </div>
                    <button class="btn btn-primary mt-1 ms-auto" type="submit">Apply</button>
                    @else
                    <h5 class="text-center mb-1 text-capitalize" id="shareProjectTitle">Languages Not Found</h5>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
