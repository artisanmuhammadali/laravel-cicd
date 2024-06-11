
@if(count($announcements) > 0)
<div class="text-center">
    <div class="my-auto justify-content-center">
        <div class="owl-carousel-annoucement  owl-carousel owl-theme">
            @foreach($announcements as $announcement )
            <div class="col-12">
                @php($component = 'front.components.announcement.'.$announcement->type)
                @include($component)
            </div>
            @endforeach
        </div>
    </div>		
</div>
@endif
