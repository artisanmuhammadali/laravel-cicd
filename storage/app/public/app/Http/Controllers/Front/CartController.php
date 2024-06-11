<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\MTG\MtgUserCollection;
use App\Models\Postage;
use App\Services\Front\CartService;

class CartController extends Controller
{
    public function index(CartService $cart)
    {

        try {

          if(auth()->user())
          {
            list($data,$platformFee,$refCredit,$refCredPlatformFee,$final_total,$complete_total,$total,$total_items,$total_collections,$postage_price,$vat,$postages) = $cart->getCartVariations();
            $pspConfig = vsfPspConfig();
            $total = number_format($total, 2, '.', '');
            $platformFee = number_format($platformFee, 2, '.', '');
            return count($data) == 0 ? redirect()->route('index')->with('error','Your Cart Is Empty.') : view('front.user.cart',get_defined_vars());
          }
        } catch (\Exception $th) {
        }
        return redirect()->route('index');
    }
    public function add(Request $request , CartService $cart)
    {
      $response = $cart->addToCart($request);

      return response()->json($response);
    }
    
    public function remove(Request $request)
    {
      Cart::where('user_id',auth()->user()->id)->where('collection_id',$request->collection_id)->delete();
      $total = getUserCart(auth()->user()->id,'count');

      return response()->json(['total' => $total]);
    }

    public function emptyCartAfterDay()
    {
      Cart::where('created_at', '<=', now()->subHours(24))->delete();
    }
}
