<div class="">
    <table class="table table-hover ">
        <thead>
            <tr>
                <th ><input type="checkbox" class="checkall"></th>
                <th class="d-md-table-cell d-none">Sale</th>
                
                <th class="d-md-table-cell d-none">Image</th>
                <th class="px-0">Card</th>
                <th class="d-md-table-cell d-none">Set</th>
                <th class="d-md-table-cell d-none">Lang</th>
                <th class="d-md-table-cell d-none">Characteristics</th>
                <th class="d-md-table-cell d-none">Qty</th>
                <th class="px-0">Price</th>
                <th class="px-0"><span class="d-md-table-cell d-none">Action</span><span class="d-md-none d-block"><i class="fa fa-tasks"></i></span></th>
            </tr>
        </thead>
        <tbody>
            @foreach($list as $item)
            @include('user.sw.collection.components.table-row')
            @endforeach
        </tbody>
    </table>
    <input type="hidden" value="{{$list->total()}}" class="total_value">
    <div class="d-flex justify-content-center py-2">
        <div class="d-md-block d-none">{{$list->links()}}</div>
            @include('front.components.pagination',['items'=>$list])
        {{-- {{$list->links()}} --}}
    </div>
</div>
