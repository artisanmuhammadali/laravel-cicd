@php($tabb = $tabb ?? 'item')
<div class="card search_tab_area">
    <div class="card-body">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-fill" id="searchNavTabs" role="tablist">
            <li class="nav-item">
            @php($active = $tabb == 'item' ? 'active' : '')
                <a class="nav-link {{$active}} search_tab" data-type="item" id="item-tab-fill" data-bs-toggle="tab" href="#item-fill" role="tab"
                    aria-controls="item-fill" aria-selected="false">Item</a>
            </li>
            <li class="nav-item">
            @php($active = $tabb == 'expansion' ? 'active' : '')
                <a class="nav-link {{$active}} search_tab" data-type="expansion" id="expention-tab-fill" data-bs-toggle="tab" href="#expention-fill" role="tab"
                    aria-controls="expention-fill" aria-selected="false">Expansion</a>
            </li>
            <li class="nav-item">
            @php($active = $tabb == 'users' ? 'active' : '')
                <a class="nav-link {{$active}} search_tab" data-type="users" id="users-tab-fill" data-bs-toggle="tab" href="#users-fill" role="tab"
                    aria-controls="users-fill" aria-selected="false">Users</a>
            </li>
            
        </ul>

        <!-- Tab panes -->
        <div class="tab-content pt-1">
        @php($active = $tabb == 'item' ? 'active' : '')
            <div class="tab-pane {{$active}}" id="item-fill" role="tabpanel" aria-labelledby="item-tab-fill">
                <div class="inner_search_box">
                    <table class="table table-striped">
                        <tbody>
                            @foreach($items as $item)
                            <tr class="expansion_detailed_route" data-url="{{route('mtg.expansion.detail',[$item->url_slug, $item->url_type ,$item->slug])}}">
                                <th scope="row"><div class="">
                                    <img class="myDIV h4Btn me-1" src="{{$item->png_image}}" width="20px">
                                    <div class="hide hand hfix " style="left: 32rem; top: 0px !important;">
                                        <img class="rounded-3" alt="very friendly shark" width="250" src="{{$item->png_image}}"/>
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
                                {{-- <td>{{$item->card_type}}</td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    <a href="{{route('mtg.specific.search','items')}}?keyword={{$request->keyword}}" class="btn btn-site-primary mt-1">View All {{$item_count}} Items</a>
                </div>
            </div>
            @php($active = $tabb == 'expansion' ? 'active' : '')
            <div class="tab-pane {{$active}}" id="expention-fill" role="tabpanel" aria-labelledby="expention-tab-fill">
                <div class="inner_search_box">
                    <table class="table table-striped">
                        <tbody>
                            @foreach($sets as $item)
                            @if($item->parent)
                            <tr class="expansion_detailed_route" data-url="{{ route('mtg.expansion.type', [$item->parent->slug , $item->url_type]) }}" >
                            @else
                            <tr class="expansion_detailed_route" data-url="{{ route('mtg.expansion.set', $item->slug) }}" >
                            @endif
                                <th scope="row"><img src="{{$item->icon}}" width="50px"></th>
                                <td>{{$item->name}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @php($active = $tabb == 'users' ? 'active' : '')
            <div class="tab-pane {{$active}}" id="users-fill" role="tabpanel" aria-labelledby="users-tab-fill">
                <div class="inner_search_box">
                    <table class="table table-striped">
                        <tbody>
                            @foreach($users as $item)
                            <tr class="expansion_detailed_route"  data-url="{{route('profile.index',$item->user_name)}}">
                                <th scope="row" class="text-start">
                                    <img src="{{$item->main_image}}" width="50px" loading="lazy">
                                    {{$item->user_name}}
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
