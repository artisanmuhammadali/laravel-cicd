<div class="breadcrumb-section py-2 bg-light-grey">
    <div class="container ps-md-0">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item fw-medium ">
                    <a href="{{route('index')}}">
                        <span class="d-md-block d-none">Homepage</span><span class="d-md-none d-block p-md-0 px-1">...</span>
                    </a>
                </li>
                @php( $link = "" )
                @php( $segments = count(Request::segments()) )
                @for($i = 1; $i <= $segments; $i++)
                    @if($i < $segments & $i > 0)
                        <?php $link .= "/" . Request::segment($i); ?>
                        <li class="breadcrumb-item fw-medium text-capitalize  {{$i < $segments - 1 ? 'd-md-block d-none' : ''}}" >
                            @if(Request::segment($i) == 'newly-added' || Request::segment($i) == 'featured-items' || Request::segment($i) == 'marketplace' )
                            <p class="active-bread mb-0 text-truncate fs-bread p-md-0 px-1">{{ucwords(str_replace('-',' ',Request::segment($i)))}}</p>
                            @else
                            <a href="{{$link }}" class="p-md-0 px-1">{{ ucwords(str_replace('-',' ',Request::segment($i)))}}</a>
                            @endif
                        </li>
                    @else
                        @if(fnmatch('mtg.expansion.detail', Route::currentRouteName()))
                        <li class="breadcrumb-item fw-medium text-capitalize bread-w-fix" >
                            <p class="active-bread mb-0 text-truncate fs-bread p-md-0 px-1">{{$item->seo->heading ?? $item->name}}</p>
                        </li>
                        @elseif(fnmatch('sw.expansion.detail', Route::currentRouteName()))
                        <li class="breadcrumb-item fw-medium text-capitalize bread-w-fix" >
                            <p class="active-bread mb-0 text-truncate fs-bread">{{$item->seo->heading ?? $item->name}}</p>
                        </li>
                        @else
                        <li class="breadcrumb-item fw-medium text-capitalize bread-w-fix" >
                            <p class="active-bread mb-0 text-truncate fs-bread p-md-0 px-1">{{ucwords(str_replace('-',' ',Request::segment($i)))}}</p>
                        </li>
                        @endif
                    @endif
                @endfor
            </ol>
        </nav>
    </div>
</div>