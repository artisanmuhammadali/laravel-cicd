<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\UserAddress;
use App\Services\Front\CartService;
use App\Services\Front\CheckoutService;
use Illuminate\Http\Request;
use \MangoPay\MangoPayApi as MangoPay;
use Illuminate\Support\Facades\Config;
class CheckoutController extends Controller
{
    private $mangoPayApi;

    public function __construct()
    {   
        $data = Config::get('helpers.mango_pay');
        $this->mangoPayApi = new MangoPay();
        $this->mangoPayApi->Config->ClientId = $data['client_id'];
        $this->mangoPayApi->Config->ClientPassword = $data['client_password'];
        $this->mangoPayApi->Config->TemporaryFolder = '../../';
        $this->mangoPayApi->Config->BaseUrl = $data['base_url'];
        // $this->mangoPayApi->Config->BasGBPl = 'https://api.sandbox.mangopay.com';
    }
    public function confirm(Request $request, CartService $cart)
    {
        if(!vfsWebConfig())
        {
            return redirect()->back()->with('error','Sorry this option is not available at the moment.');
        }
        if(!$request->address_id)
        {
            return redirect()->back()->with('error','Please select your delivery address.');
        }
        $address = UserAddress::find($request->address_id);
        list($data,$platformFee,$refCredit,$refCredPlatformFee,$final_total,$complete_total,$total,$total_items,$total_collections,$postage_price,$vat,$postages) = $cart->getCartVariations();
        $pspConfig = vsfPspConfig();
        $walletBalance = getUserWallet();
        $remainingAmt = $complete_total <= getUserWallet() ? 0 : $complete_total - getUserWallet();
        // dd(getUserWallet() , $remainingAmt , $complete_total);
        $total = number_format($total, 2, '.', '');
        $platformFee = number_format($platformFee, 2, '.', '');
        $percentage = paymentCharges()['percentage'];
        $additional = paymentCharges()['additional'];
        $remainingAmtCharge = ((float)$remainingAmt/100)*($percentage)+($additional)+$remainingAmt;
        $remainingAmtCharge = number_format($remainingAmtCharge, 2, '.', '');
        $actual_wallet = $complete_total <= getUserWallet() ? getUserWallet() - auth()->user()->vfs_wallet: getUserWallet() ;
        $referal_wallet = auth()->user()->vfs_wallet;
        return view('front.user.checkout.confirm',get_defined_vars());    
    }
    public function proceed(Request $request , CheckoutService $checkout)
    {
        $count =  Cart::where('user_id',auth()->user()->id)->count();
        if($count < 0)
        {
            return redirect()->back()->with('error','User Delete his collection.');
        }
        return $request->has('address_id') ? $checkout->proceed($request)  : redirect()->back()->with('error','Please select address.');

    }
    public function success()
    {
        return view('front.user.checkout.success');    
    }
    public function payment($id , CartService $cart , CheckoutService $checkout)
    {
        $request = request();

        if($request->transactionId)
        {
            list($data,$platformFee,$refCredit,$refCredPlatformFee,$final_total,$complete_total,$total,$total_items,$total_collections,$postage_price,$vat,$postages) = $cart->getCartVariations();

            $request->merge(['complete_total'=>$complete_total,'address_id'=>$id]);
            $payment= $this->mangoPayApi->PayIns->Get($request->transactionId);
            $return = $payment->Status == "FAILED" ? ['msg'=>'Your Transaction was Unsuccessfull.','alert'=>'error'] : $payment->Status;
            $return = $return == "PENDING" ? ['msg'=>'Please wait untill your transaction succeeded.','alert'=>'info'] : $return;
            return $payment->Status == "SUCCEEDED" && getUserWallet() >= $complete_total ? $checkout->proceed($request) : redirect(route('checkout.confirm').'?address_id='.$id)->with($return['alert'],$return['msg']);

        }
        return redirect(route('checkout.confirm').'?address_id='.$id)->with('success','Your Transaction is processing.');
    }
}