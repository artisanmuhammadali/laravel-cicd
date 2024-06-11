@php($qty=getUserCart($item->id ,'quantity' , get_class($item)))
@php($mobile_condition = fnmatch('cart.index', Route::currentRouteName()) || fnmatch('checkout.confirm', Route::currentRouteName()) ? 1 : 0)
<div class="input-group d-flex flex-nowrap w-100">
    <button class="btn btn-warning add_to_cart {{$mobile_condition ? '' : 'add_to_cart_btn' }}  position-relative {{$class ?? ''}} " {{vfsWebConfig() ? "" : "disabled"}} data-url="{{route('cart.add',[$item->user->id , $item->id])}}"   title="Add to Cart">
        @if(!$mobile_condition)
        <span class="count_spec_item position-absolute top-1 translate-middle badge rounded-pill bg-light-blue text-black {{$qty > 0 ? '' : 'hide'}}">{{$qty}}</span>
        @endif
        <i class="fas fa-shopping-cart "></i>
    </button>  
    <div class="quantity-select d-md-block d-none">
        <input type="hidden" value="{{get_class($item)}}" class="coll_type">
        @php($availQty=getUserCart($item->id ,'available-quantity' , get_class($item)))
        <select name="quantity" class="form-control {{$availQty > 1 ? 'select-qty' : ''}} cart_quantity text-start ps-1 pe-0 rounded-0 fs-qty ">
            @if($availQty > 0)
                @php($availQty=$availQty >= 99 ? 99 :$availQty )
                @for($i=1;$i<=$availQty;$i++)
                <option value="{{$i}}" class="form-control" {{$i == $qty ?"selected" :""}}>{{'Quantity: '.$i}}</option>
                @endfor
            @else
                <option disabled>Not Available</option>
            @endif
        </select>
    </div>
    <button data-url="{{route('cart.remove',[$item->user->id , $item->id])}}" class="btn btn-danger {{$mobile_condition ? '' : 'd-md-block d-none' }}  remove_cart_item {{$class ?? ''}} position-relative " {{$qty > 0 ? '' : 'disabled'}}  title="Remove from Cart">
        <div class="product_cart_row " >
            <i class="fa fa-trash text-black" aria-hidden="true"></i>
        </div>
    </button>
</div>
