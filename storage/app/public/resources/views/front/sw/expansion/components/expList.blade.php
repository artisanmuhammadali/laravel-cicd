<div class="row shadow_site  py-3">
    {{-- <div class="col-12 d-md-none d-flex mb-md-0 mb-2">
        <button type="button" class="btn w-50 btn-sets exp-s active border border-dark rounded-0" data-class="expansion">Expansion Sets</button>
        <button type="button" class="btn w-50 btn-sets sp-s border border-dark rounded-0" data-class="special">Special Sets</button>
    </div> --}}
    <div class="col-md-12 col-12 exp-set">
        <ul class="list-group expSet">
            <li class="list-group-item mb-4 bg_dark_shark rounded-0 text-white py-3">
                <h2 class=" fs-4 mb-0 text-uppercase">Expansion Sets ({{ count($sets) }})</h2>
            </li>


            @foreach ($sets as $setOption)
            <li class="list-group-item mb-2 rounded-1 py-3 bg-light-grey" data-date="{{customDate($setOption->sw_published_at, 'Y/m/d')}}" data-name="{{$setOption->name}}">
                <a href="{{ route('sw.expansion.set', $setOption->slug) }}" class="text-black">
                    <img src=""

                    class="me-2 exp-icon img-fluid" alt="" loading="lazy" alt="{{$setOption->name}}">
                    {{ $setOption->name }}
                    <small>({{ $setOption->code }})</small>
                </a>
            </li>
            @endforeach

        </ul>
    </div>
    {{-- <div class="col-md-6 col-12 d-md-block d-none  sp-set">
        <ul class="list-group spSet">
            <li class="list-group-item mb-4 bg_dark_shark rounded-0 text-white py-3">
                <h2 class=" fs-4 mb-0 text-uppercase">Special Sets ({{ count($sets['special']) }})</h2>
            </li>

            @foreach ($sets['special'] as $setOption)
            <li class="list-group-item mb-2 rounded-1 py-3 bg-light-grey" data-date="{{$setOption->released_at}}" data-name="{{$setOption->name}}">
                <a href="{{ route('mtg.expansion.set', $setOption->slug) }}" class="text-black">
                    <img loading="lazy" src="{{ $setOption->icon ?? 'https://veryfriendlysharks.co.uk/images/expansion/Placeholder.svg' }}" class="me-2 exp-icon img-fluid" alt="{{$setOption->name}}">
                    {{ $setOption->name }}
                    <small>({{ $setOption->code }})</small>
                </a>
            </li>
            @endforeach

        </ul>
    </div> --}}
</div>