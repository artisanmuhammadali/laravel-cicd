<tr class="publish_check {{$item->publish ? 'published_item' : 'unpublished_item'}}">
    <td>
        <input type="checkbox" class="checkboxes " data-id="{{$item->id}}" data-class="{{$item->publish ? '1' : '0'}}">
    </td>
    
    <td class="d-md-table-cell d-none">
        @if($item->publish)
            <span class="badge bg-success">active</span>
        @else
            <span class="badge bg-danger">inactive</span>
        @endif
    </td>
    @if($type == "single")
    <td class="d-md-table-cell d-none">
        {{$item->card ? $item->card->collector_number : 'nooo'}}
    </td>
   
    @endif
    <td class="d-md-table-cell d-none">
    <i class="fa fa-image myDIV h4Btn me-1"></i>
            {{--<!-- <img class="myDIV h4Btn me-1" src="{{$item->card->png_image}}" width="50px" alt="{{$item->card->name}}" loading="lazy"> -->--}}
            <div class="hide hand h4 " style="left: 32rem; top: 0px !important;">
                <img  class="rounded-3" alt="very friendly shark" width="250" src="{{$item->card->png_image}}" alt="{{$item->card->name}}" loading="lazy"/>
            </div>
    </td>
    <td class=" align-items-center px-0">
        <i class="fa fa-image myDIV h4Btn me-1 d-md-none d-block"></i>
        <div class="hide hand h4 " style="left: 32rem; top: 0px !important;">
            <img  class="rounded-3" alt="very friendly shark" width="250" src="{{$item->card->png_image}}" alt="{{$item->card->name}}" loading="lazy"/>
        </div>
        @if($item->card)
            <a href="{{route('mtg.expansion.detail',[$item->card->url_slug, $item->card->url_type ,$item->card->slug])}}" target="_blank" class="fw-bold fs-12p-sm">{{$item->card->name}}</a>
            @php($attributess = $item->card->attributes ?? null)
            @if($attributess)
                <br>
                @foreach($item->card->attributes as $att)
                    <span class="badge bg-primary position-relative fs-12p-sm">{{$att->name}}</span>
                @endforeach
            @endif
        @endif
    </td>
    <td class="d-md-table-cell d-none">
        @if($item->card)
        <img loading="lazy" src="{{$item->card->set->icon  ?? ""}}" style="filter: url({{"#".$item->card->rarity."_rarity"}});" class="me-75" height="40" width="40" alt="Angular" title="{{$item->card->set->name}}">
        @endif
    </td>
    <td class="d-md-table-cell d-none">
        @if($item->mtg_card_type == "completed")
            @if($item->language)
                @foreach(json_decode($item->language) as $key =>$lang)
                    <span class="badge bg-primary text-uppercase">{{$key}}</span>
                @endforeach
            @endif
        @else
            <span class="badge bg-primary text-uppercase">{{$item->language}}</span>
        @endif
    </td>
    <td class="d-md-table-cell d-none">
        <span class="badge bg-primary">{{$item->condition}}</span>
        @if($item->foil)
        <span class="badge bg-info">Foil</span>
        @endif
        @if($item->signed)
        <span class="badge bg-warning">Signed</span>
        @endif
        @if($item->graded)
        <span class="badge bg-success">Graded</span>
        @endif
        @if($item->altered)
        <span class="badge bg-secondary">Altered</span>
        @endif
    </td>
    <td class="d-md-table-cell d-none">
        {{$item->quantity}}
    </td>
    <td class="text-truncate px-md-2 px-0">
        £ {{$item->price}}
        <br>
       <span class="text-center d-md-none d-block"> ({{$item->quantity}} )</span>
    </td>
    <td class="px-0">
        <div class="d-md-flex d-none">
            <button type="button" class="btn btn-icon btn-outline-primary waves-effect me-1 open_modal" data-url="{{route('user.collection.edit',$item->id)}}" title="Edit">
                <i class="fa fa-pencil" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn btn-icon btn-outline-danger waves-effect " onclick="deleteAlert('{{route('user.collection.delete',$item->id)}}')" title="Delete">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </button>
        </div>

        <div class="btn-group d-block d-md-none">
            <button class="transparent_btn" type="button"  data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-ellipsis-v"></i>
            </button>
            
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" style="">
                <a class="dropdown-item open_modal" href="#" data-url="{{route('user.collection.edit',$item->id)}}" title="Edit">
                        Edit
                </a>
                <a class="dropdown-item" href="#" onclick="deleteAlert('{{route('user.collection.delete',$item->id)}}')" title="Delete">
                        Delete
                </a>
            </div>
        </div>
    </td>
</tr>
