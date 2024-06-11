<div class="col-lg-12 col-12 order-2 order-lg-1">
    <div class="card border-0">
        <div class="card-header bg-white border-0 d-flex justify-content-between">
            <div class="d-flex">
                <h4 class="card-title mt-3 fw-bolder">Reviews</h4>
                <select name="sort_review" class="  my-3 ms-3 sort_review" aria-label="Default select example">
                    <option selected disabled>Sort by</option>
                    <option value="high">High to low</option>
                    <option value="low">Low to high</option>
                    <option value="recents">Recents</option>
                </select>
                <select name="type_review" class="  my-3 ms-3 type_review" aria-label="Default select example">
                    <option value="seller" selected>As Seller</option>
                    <option value="buyer">As Buyer</option>
                </select>
            </div>
            <div class="mt-1 text-center">
                <!-- <h3 class="fs-2">{{(int)$user->average_rating.'.0'}}</h3> -->
                @include('front.components.user.rating',['rating'=>$user->average_rating,'class'=>'','num_visible'=>'d-none'])
                <span class="small text-secondary">{{count($user->reviews)}} reviews</span>
            </div>
        </div>
        <div class="card-body py-0 render_review">
        </div>
    </div>
</div>