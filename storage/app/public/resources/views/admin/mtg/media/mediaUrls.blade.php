<div class="row" id="user-profile">


    @foreach($media as $m)
                                            <div class="col-md-4 col-6 profile-latest-img">
                                                <a href="#">
                                                <img src="{{$m->complete_url}}" class="w-100 choose_url mb-2 image-fluid rounded" style="cursor:pointer" data-url="{{$m->complete_url}}">
                                                </a>
                                            </div>
    @endforeach
</div>
