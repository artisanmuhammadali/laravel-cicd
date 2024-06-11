 @if($order->status == "completed" )
 <h4 class="card-title mt-5">Order Reviews</h4>
 @foreach($order->reviews as $review)
 <div>
     <div class="d-flex justify-content-between">
         <h3>{{$review->by->user_name}}</h3>
         <div class="rating">{{$review->rating}}</div>
     </div>
     <p>
         {{$review->remarks}}
     </p>
 </div>
 @endforeach
 @if(!$order->reviewed_by_auth)
 <h4 class="card-title mt-5">Review {{$type == "buy" ? "Seller" : "Buyer"}}</h4>
 <form action="{{route('user.order.review.save')}}" method="POST" class="text-start">
     @csrf
     <input type="hidden" name="order_id" value="{{$order->id}}">
     <input type="hidden" class="reviewRating" name="rating">
     <div style="display: inline-flex">
         <div class="rate">
             <input type="radio" class="rating" id="star5" name="rate" value="5" />
             <label for="star5" title="text">5 stars</label>
             <input type="radio" class="rating" id="star4" name="rate" value="4" />
             <label for="star4" title="text">4 stars</label>
             <input type="radio" class="rating" id="star3" name="rate" value="3" />
             <label for="star3" title="text">3 stars</label>
             <input type="radio" class="rating" id="star2" name="rate" value="2" />
             <label for="star2" title="text">2 stars</label>
             <input type="radio" class="rating" id="star1" name="rate" value="1" />
             <label for="star1" title="text">1 star</label>
         </div>
         <div class="row text-center align-items-center">
             <p class="mb-0"><span class="reviewRatingShow">0</span>/5</p>
         </div>
     </div>
     @error('rating')
     <p class="text-danger text-start">{{ $message }}</p>
     @enderror
     <div class="success-msg">
         <label>Remarks</label>
         <textarea name="remarks" id="" class="form-control" cols="40" rows="5" required></textarea>
     </div>
     @error('remarks')
     <p class="text-danger text-start">{{ $message }}</p>
     @enderror
     <button class="btn btn-primary mt-1">Submit</button>
 </form>
 @endif
 @endif
