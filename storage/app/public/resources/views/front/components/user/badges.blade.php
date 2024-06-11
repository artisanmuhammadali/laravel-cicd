@if($collection->user->verified)
<img class="user-badges-size" src="{{asset('images/badges/verifiedSeller.svg')}}" alt="" title="Verified Seller">
@endif
@if($collection->user->tire_badge)
<img class="user-badges-size" src="{{asset('images/badges/sellerTier.svg')}}" alt="" title="Tier 1 Seller">
@endif
@if($collection->user->dispatch_badge->day)
<div class="position-relative d-flex align-items-center" style="width: fit-content" title="{{$collection->user->dispatch_badge->lable}}">
    <img class="user-badges-size" src="{{asset('images/badges/dispatches.svg')}}" alt="" >
    <div class="centered-text">
        <p class="mb-0 fs-bread dispatch-badge-text ">{{$collection->user->dispatch_badge->day}}</p>
    </div>
</div>
@endif