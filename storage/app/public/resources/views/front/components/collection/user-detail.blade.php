    <div class="d-flex" title="{{$collection->user->user_name}}">
        <a href="{{route('profile.index',$collection->user->user_name)}}" class="me-md-auto me-sm-1" >
            <span class="d-md-block d-none">{{$collection->user->user_name}}</span>
            <span class="d-md-none d-block">{!! Str::limit($collection->user->user_name, 4,'..') !!}</span>
        </a>
        <div class="d-md-block d-none" style="width: fit-content;">
            @include('front.components.user.rating',['rating'=>$collection->user->average_rating ,'class'=>'ms-auto','num_visible'=>'','user' => $collection->user])
        </div>
        <div class="d-md-none d-flex">
            @include('front.components.user.badges')
        </div>
    </div>
    <div class="mt-1 d-md-flex d-none">
        @include('front.components.user.badges')
    </div>
    <div class="d-md-none d-block">
        @php($empty = 5-(int)$collection->user->average_rating)
        <div class="d-grid   align-items-center justify-content-center" style="width: max-content;">
            <div class="d-flex">
                @for($i=1;$i<=$collection->user->average_rating;$i++)
                <i class="fa fa-star" style="color:gold" aria-hidden="true"></i>
                @endfor
                @for($i=1;$i<=$empty;$i++)
                <i class="fa fa-star" aria-hidden="true"></i>
                @endfor
            </div>
            <div class="rating  d-flex text-align-center {{$num_visible ?? ""}}">
                <div class="rating">({{$collection->user->reviews ? $collection->user->reviews->count() : 0}} Reviews)</div>
            </div>
        </div>
    </div>
