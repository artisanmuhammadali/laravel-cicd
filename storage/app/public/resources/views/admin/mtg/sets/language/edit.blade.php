<div class="modal fade" id="editLanguageModal" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close btn-clear" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-4">
                <form action="{{route('admin.mtg.sets.languages')}}" method="post">
                @csrf
                    <input type="hidden" value="language" name="type">
                    <input type="hidden" value="{{$currentSet->id}}" name="id" >
                    <h5 class="text-center mb-1 text-capitalize" id="shareProjectTitle">Update Set Languages</h5>
                    <div class="row">
                    @if(count($currentSet->language) > 0)
                    @foreach($currentSet->language as $language)
                    <div class="form-group col-md-3">
                        <label for="{{$language->key}}"  class="small">{{$language->value}}</label>
                        <input type="checkbox"  name="languages[{{$language->key}}]" checked id="{{$language->key}}">
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
