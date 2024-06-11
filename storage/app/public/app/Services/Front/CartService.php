<?php

namespace App\Services\Front;

use App\Models\Cart;
use App\Models\MTG\MtgUserCollection;
use Illuminate\Support\Facades\App;

class CartService {

    public function getCartVariations()
    {
      $user = auth()->user();
      $list = Cart::where('user_id',$user->id)->get();
      $data = $list->groupBy('seller_id');
      $postage_price = 0;
      $postages = [];
      foreach ($data->keys() as $key => $value) {
          $cal = (object)getSellerCartCalculations($value);
          $postage_price =$postage_price+$cal->postage_price;
          $postages[] = [$value=>$cal->postage];
      }
      $total = $list->sum(function ($item) {
                    return $item->price * $item->quantity;
                });
      $total_items = $list->sum(function ($item) {
                          return $item->quantity;
                      });

      $pspConfig = vsfPspConfig();
      $platformFee = $total* ($pspConfig->platform_fee /100);
      $platformFee = number_format((float)$platformFee, 2, '.', '');
      $platformFee = $platformFee < 0.01 ? 0.01 : $platformFee;

      $total = $platformFee < 0.01 ? $total - 0.01 : $total;

      $refCredit = $total* ($pspConfig->referal_percentage / 100);
      $refCredPlatformFee = $platformFee - $refCredit;
      $final_total = $postage_price + $total;
      $total_collections = getUserCart($user->id,'count');
      $vat = ($pspConfig->vat_percentage/100) * $total;
      $complete_total = ($final_total + $vat) - $user->vfs_wallet;
      $end_price = $complete_total <= 0 ? ($final_total + $vat) : $complete_total;

        return [$data,$platformFee,$refCredit,$refCredPlatformFee,$final_total,$end_price,$total,$total_items,$total_collections,$postage_price,$vat,$postages];
        
    }

    public function addToCart($request)
    {
      
      $productModel = App::make($request->type);
      $collection = $productModel::findOrFail($request->collection_id);
      $u_id = auth()->user() ? auth()->user()->id : 0;
      $cart = Cart::where('user_id',$u_id)
                  ->where('collection_type',$request->type)
                  ->where('collection_id',$request->collection_id)
                  ->first();
      if($request->mobile == 'true')
      {
        
        $qty = $cart ? $cart->quantity+1 : 1;
        if($qty > (int)$collection->quantity){
          return ['error'=>'Quantity Not Available.'];        
        }
        $request->merge(['quantity'=>$qty]);
      }
      $check = (object)$this->addToCartChecks($request);
      if($check->status)
      {
        $weight = $request->quantity * $collection->card->weight;
        $data =[
              'user_id'=>auth()->user()->id,
              'seller_id'=>$request->seller_id,
              'weight'=>$weight,
              'price'=>$collection->price,
              'quantity'=>$request->quantity,
              'range' => getCardBaseRoute($request->type),
              'created_at'=>now(),
              'updated_at'=>now(),
            ];
          $crt = Cart::where('user_id' ,auth()->user()->id)
              ->where('collection_type',$request->type)
              ->where('collection_id',$request->collection_id)
              ->first();
          $crt ? $crt->update($data) : $collection->cart()->create($data);
                   
        $total = getUserCart(auth()->user()->id,'count');
        return  ['count'=>$request->quantity , 'total'=>$total];
      }
      return ['error'=>$check->error];
    }
    public function addToCartChecks($request)
    {
      if(!auth()->user())
      {
        return ['status'=>false,'error' => 'Please Login.'];
      }
       if(auth()->user()->role == "admin")
      {
        return ['status'=>false,'error' => 'You are admin you cannot buy.'];
      }
      if(!$request->quantity)
      {
        return ['status'=>false,'error' => 'Please Select Quantity.'];
      }
      if(check_auth_block($request->seller_id))
      {
        return ['status'=>false,'error' => 'You are blocked by the Seller.'];
      }
      if(auth()->user()->id == $request->seller_id)
      {
        return ['status'=>false,'error' => 'You can not add your own collection to cart.'];
      }
      if(getUserCart($request->collection_id , 'available-quantity' , $request->type) < (int)$request->quantity)
      {
        return ['status'=>false,'error' => 'Quantity Not Available.'];
      }
      if(getUserCart($request->collection_id , 'quantity' , $request->type) == (int)$request->quantity && $request->mobile == 'false')
      {
        return ['status'=>false,'error' => 'Already Added to Cart.'];
      }
      if(!auth()->user()->store->mango_id)
      {
        return ['status'=>false,'error' => 'Please activate your account first.'];
      }
      if(!vfsWebConfig())
      {
        return ['status'=>false,'error' => 'Sorry this option is not available at the moment.'];
      }
      return ['status'=>true,'success'=>'Items added to cart successfully!'];
    }
    
}