<div class="modal fade" id="inactiveCollection" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Inactive Collection</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>
                    All the selected items will be removed from sale.
                </p>
            </div>
            <div class="modal-footer">
                <form action="{{route('user.collection.save')}}" method="POST">
                    @csrf
                    <button data-form="publish" data-publish="0" data-link="{{route('user.collection.save')}}" type="button" class=" update_cols btn btn-primary waves-effect waves-float waves-light ">Sure</button>
                </form>
            </div>
        </div>
    </div>
</div>