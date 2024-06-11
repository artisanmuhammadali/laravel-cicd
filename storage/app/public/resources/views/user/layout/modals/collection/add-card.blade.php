<div class="modal fade" id="addCard" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close btn-clear" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-4">
                <h1 class="text-center mb-1 text-capitalize" id="shareProjectTitle">Search {{$type}}</h1>
                <p class="text-center">Click on card to add in your collection</p>
                <div class="mb-1 input-group input-group-merge">
                    <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></span>
                    <input type="text" class="form-control general_search_input" data-type="{{$type}}" data-url="{{route('user.search.generalSearch')}}">
                </div>
                <div class="mb-2 search_tab_block table-responsive">
                    
                </div>
            </div>
        </div>
    </div>
</div>