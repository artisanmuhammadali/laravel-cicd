
    @if(count($reviews) >= 1)
    @foreach($reviews as $review)
    <div class="d-flex border-bottom mb-2">
        <div>
            <img src="{{$review->by->main_image}}" height="40" width="40"
                class="rounded" alt="">
        </div>
        <div class="ms-3 mb-2">
            <a href="{{route('profile.index',$review->by->user_name)}}"
                class="fs-5 text-decoration-none">
                {{$review->by->user_name}}
            </a>
            <div class="d-flex">
                @include('front.components.user.rating',['rating'=>$review->rating,'class'=>'','num_visible'=>'d-none'])

            </div>
            <span class="fs-6">
                {{$review->remarks}}
            </span>
            <p class="m-0 fst-italic small text-secondary">
                {{$review->created_at->diffForHumans()}}
            </p>
        </div>
    </div>
    @endforeach
    <div class="col-md-12  px-md-5 overflow-auto mt-3">
        {{$reviews->links()}}
    </div>
    @else
    <div class="row text-center">
        <p class="text-danger">No Reviews Yet</p>
    </div>
    @endif