<div class="modal fade" id="csvUpload" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Upload Csv</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('user.collection.save')}}" class="csvForm" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-between">
                        <p>CSV upload</p>
                        <p>Click
                            @if($type == "single") 
                            <a href="{{asset('csvFormat/bulk-format.xlsx')}}" download>here</a>
                            @else
                            <a href="{{asset('csvFormat/bulk-format-1.xlsx')}}" download>here</a>
                            @endif
                        to download correct format</p>
                    </div>
                    <input type="hidden" name="form_type" class="form_type" value="csv">
                    <input type="hidden" name="mtg_card_type" value="{{request()->type ?? ""}}">
                    <div class="d-flex justify-content-center">
                        <div class="sipnner d-none position-absolute" style="top: 200px;">
                            <div class="spinner-grow text-secondary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="spinner-grow text-secondary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="spinner-grow text-secondary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="spinner-grow text-secondary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <input type="file" name="data" accept="csv" id="csvFileInput" class="csvUpload form-control mb-5">
                    <div class="appendHeaderBox"></div>
                </form>
            </div>
        </div>
    </div>
</div>