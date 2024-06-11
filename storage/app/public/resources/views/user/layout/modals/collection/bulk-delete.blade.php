<div class="modal fade" id="deleteCollection" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Delete Collection</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>
                    All the selected items will be deleted.
                </p>
            </div>
            <div class="modal-footer">
                <form action="{{route('user.collection.delete')}}" method="POST">
                    @csrf
                    <button data-form="bulk"  data-link="{{route('user.collection.delete')}}" type="button" class="update_cols btn btn-danger waves-effect waves-float waves-light">Sure</button>
                </form>
            </div>
        </div>
    </div>
</div>