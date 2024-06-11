<table class="table table-hover">
    <tbody>
        @foreach($list as $item)
        <tr class="open_modal cursor-pointer" data-url="{{route('user.collection.sw.renderViews')}}" data-id="{{$item->id}}" data-type="forsale">
            <th scope="row">
                <img class="myDIV h4Btn me-1" src="{{$item->png_image}}" width="50px" loading="lazy" alt="{{$item->name}}">
                <div class="hide hand h4 " style="left: 32rem; top: 0px !important;">
                    <img class="rounded-3" width="250" src="{{$item->png_image}}" loading="lazy" alt="{{$item->name}}"/>
                </div>
            </th>
            <td>{{$item->name}}</td>
            <td>
                @if($item->attributes)
                    @foreach($item->attributes as $attr)
                        {{$attr->name}}
                    @endforeach
                @endif
            </td>
            <td>{{$item->set->name ?? ''}}</td>
            <td>{{$item->card_type}}</td>
        </tr>
        @endforeach
    </tbody>
</table>