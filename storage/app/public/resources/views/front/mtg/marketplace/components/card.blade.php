<div class="mb-3 pt-3 col-md-3 ">
    <div class="card shadow_site newly_card_sets item p-3 pb-1 border-0 ">
        <a class="text-decoration-none set_card_img position-relative"
            href="{{route('mtg.expansion.detail',[$collection->card->url_slug, $collection->card->url_type ,$collection->card->slug])}}"
            title="{{$collection->card->name}}">
            <img class=" rounded-site img-fluid"
                src="{{$collection->card->png_image}}" alt="{{$collection->card->name}}"
                loading="lazy">
            <p class="bg-site-primary mb-0   text-white py-1 px-2" style="position: absolute;bottom: 0;right: 0;">£{{$collection->price}}</p>
        </a>
        <a class="text-end hover-blue text-decoration-none"
            href="{{route('profile.index',$collection->user->user_name)}}">
            <div class="d-flex align-items-center">
                <img class="profile_img me-1" src="{{$collection->user->main_image}}"
                    alt="">
                    <div class="w-100 text-start">
                        <span>{{ $collection->user->user_name }}</span>
                        <div class="d-flex">
                            @include('front.components.user.badges')
                            <span class="ms-auto me-3 text-black fw-bold d-flex">
                                @include('front.components.user.rating',['rating'=>$collection->user->average_rating,'class'=>'','num_visible'=>'d-none' ,'user'=>$collection->user])
                                ( {{$collection->user->reviews ? $collection->user->reviews->count() : 0}} )
                            </span>
                        </div>   
                    </div>
            </div>
        </a>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                @include('front.components.cart.options',['item'=>$collection ,'class'=>''])
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
    
</div>