<div class="container text-center my-3">
    <div class="row mx-auto my-auto justify-content-center">
        <div id="recipeCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner" role="listbox">
                @foreach($versions as $version)
                <div class="carousel-item {{$loop->iteration == 1 ? 'active' : ''}}">
                    <div  class=" col-md-3 expansion_detailed_route text-start" data-url="{{route('mtg.expansion.detail',[$version->url_slug , $version->url_type ,  $version->slug])}}">
                        <div class="card bg-white p-2 h-100">
                            <div class="card-img h-100 my-auto">
                                <img src="{{$version->png_image}}" class="img-fluid" loading="lazy">
                                <div class="align-items-center">
                                    <p class="fs-5 bolder my-auto">
                                        {{$version->set->name}}
                                    </p>
                                    <h6 class="fs-7">
                                        {{$version->name}}
                                        @if($version->name_attr != "")
                                            | <span class="fst-italic fs-6 my-auto">{{$version->name_attr }}</span>
                                        @endif
                                    </h6>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>		
</div>

