<div class="row shadow_site py-3 my-2 ">
    <div class="table-responsive">
        <table class="table ms-2 datatablesNew">
            <thead>
                <tr class="bg-gry">
                    <th>User</th>
                    <th>
                        Card
                    </th>
                    <th class="d-md-table-cell d-none">Set</th>
                    <th class="d-md-table-cell d-none">Lang</th>
                    <th>
                        <span class="d-md-block d-none">Condition</span>
                        <span class="d-block d-md-none">Con</span>
                    </th>
                    <th class="d-md-table-cell d-none">
                        Quantity
                    </th>
                    <th>
                        Price
                    </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($collections as $collection)
                    @include('front.components.collection.collection-rows', ['collections'=>$collection])
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@if(request()->ajax())
<script>

$(document).ready(function(){
    $(".datatablesNew").DataTable({
        sort: false,
        ordering: false,
        pagingType: "full_numbers",
        responsive: true,
        lengthMenu: [[10, 25, 50], [10, 25, 50]],
        pageLength: 50,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        },
    });
})
</script>

@endif