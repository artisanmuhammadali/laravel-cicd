

@php($empty = 5-(int)$rating)
<div class="{{Route::is('mtg.newly.collection.type') || Route::is('mtg.featured.items.type') ? 'd-grid' : 'd-flex'}}   align-items-center justify-content-center {{$class}}" style="width: max-content;">
    <div class="d-flex">
        @for($i=1;$i<=$rating;$i++)
        <i class="fa fa-star" style="color:gold" aria-hidden="true"></i>
        @endfor
        @for($i=1;$i<=$empty;$i++)
        <i class="fa fa-star" aria-hidden="true"></i>
        @endfor
    </div>
    <div class="rating {{Route::is('mtg.newly.collection.type') || Route::is('mtg.featured.items.type') || Route::is('mtg.featured.items') || Route::is('mtg.newly.collection') ? '' : 'ms-2'}} d-flex text-align-center {{$num_visible ?? ""}}">
        @if(Route::is('profile.index'))
        <button class="fw-bolder btn btn-link text-black ms-b ps-0 btn_rating py-0 ms-1">
            <p class="mb-0 fw-bolder mb-0 fw-bolder small text-secondary text-decoration-none">({{$user->reviews ? $user->reviews->count() : 0}} Reviews)</p>
        </button>
        @else
         <div class="rating {{Route::is('mtg.newly.collection.type') || Route::is('mtg.featured.items.type') || Route::is('mtg.featured.items') || Route::is('mtg.newly.collection') ? '' : 'ms-2'}}">({{$user->reviews ? $user->reviews->count() : 0}} Reviews)</div>
        @endif
    </div>
</div>