<div style="background-color:{{$announcement->background}}; min-height: 61px; width:100%">
    <div class="container ps-md-3 pe-md-0 px-5">
        <div class="row py-2 m-0 justify-content-start w-100" >
            <div class="col-md-12 text-white announcementText d-flex my-auto col-12 justify-content-between px-0">
                {!! $announcement->text !!}
                @if($announcement->btn_text != null)
                    @if(auth()->user())
                    <a href="{{$announcement->btn_link}}" class="btn btn-site-primary btn-sm mt-1 px-3 my-auto" style="height: fit-content">{{$announcement->btn_text}}</a>
                    @else
                    <a href="#"  data-bs-toggle="modal" data-bs-target="#loginModal" class="btn btn-site-primary btn-sm mt-1 px-3 my-auto" style="height: fit-content">{{$announcement->btn_text}}</a>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>