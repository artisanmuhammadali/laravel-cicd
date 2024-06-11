<div style="background-color:{{$announcement->background}};min-height: 61px; width:100%">
    <div class="container ps-md-3 pe-md-0 px-4 px-sm-carosel">
        <div class="row py-1 m-0 w-100">
            <div class="col-lg-3 col-md-4 my-auto p-0 mb-1">
                <div class="row justify-content-start text-center me-xl-3">
                    <div class="col-md-2 col-3 px-1">
                        <div class="count-box rounded-3 bg-white border-site-primary border pt-md-1 announcementTimerBox" >
                            <h3 class="mb-0 fw-bold announcementTimer text-danger announcement_days{{$announcement->id}}">1</h3>
                            <p class="mb-0 mb-md-2 sm-text">Days</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-3 px-1">
                        <div class="count-box rounded-3 bg-white border-site-primary border pt-md-1 announcementTimerBox" >
                            <h3 class="mb-0 fw-bold announcementTimer text-danger announcement_hours{{$announcement->id}}">1</h3>
                            <p class="mb-0 mb-md-2 sm-text">Hours</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-3 px-1">
                        <div class="count-box rounded-3 bg-white border-site-primary border pt-md-1 announcementTimerBox" >
                            <h3 class="mb-0 fw-bold announcementTimer text-danger announcement_minutes{{$announcement->id}}">1</h3>
                            <p class="mb-0 mb-md-2 sm-text">Minutes</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-3 px-1">
                        <div class="count-box rounded-3 bg-white border-site-primary border pt-md-1 announcementTimerBox" >
                            <h3 class="mb-0 fw-bold announcementTimer text-danger announcement_seconds{{$announcement->id}}">1</h3>
                            <p class="mb-0 mb-md-2 sm-text">Seconds</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-8 text-white announcementText my-auto col-12  p-0 d-flex justify-content-md-end   justify-content-between">
                {!! $announcement->text !!}
                @if($announcement->btn_text != null)
                    @if(auth()->user())
                    <a href="{{$announcement->btn_link}}" class="btn btn-site-primary btn-sm px-3 ms-md-3 my-auto" style="height: fit-content">{{$announcement->btn_text}}</a>
                    @else
                    <a href="#"  data-bs-toggle="modal" data-bs-target="#loginModal" class="btn btn-site-primary btn-sm px-3 ms-md-3 my-auto" style="height: fit-content">{{$announcement->btn_text}}</a>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>