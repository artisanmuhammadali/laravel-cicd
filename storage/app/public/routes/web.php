<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\SurveyController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\User\ProfileController;
use App\Http\Controllers\Front\CheckoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SitemapController;
use App\Models\Message;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/testNot/data/ale', function(){
dd(1);
    $data = [
        'subject' => 'gshdgsh',
        'name' => 'gshdgsh',
        'email' => 'gshdgsh@gmail.com',
    ];

    return view('email.approved_kyc',get_defined_vars());
    dd(1);
    $user = auth()->user();
    dd($user);
    sendMail([
        'view' => 'email.approved_kyc',
        'to' => $user->email,
        'subject' => 'Your Kyc Has Been Approved',
        'data' => [
            'subject'=>'Your Kyc Has Been Approved',
            'name'=>$user->user_name,
            'email'=>$user->email,
        ]
    ]);
    // $m = new Message();
    // sendNotification($user,1 , 'message','Your Kyc Has Been Approved' ,$m);
});


Route::get('/render-reviews', [ProfileController::class, 'renderReviews'])->name('render.reviews');

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/help', [HomeController::class, 'help'])->name('help');
Route::post('/supporthelp', [HomeController::class, 'supportForm'])->name('supporthelp');
Route::get('/modalregister', [HomeController::class, 'register'])->name('modalregister');
Route::get('/faqs/{id?}', [HomeController::class, 'faqs'])->name('faqs');
Route::get('/site-cookies', [HomeController::class, 'cookies'])->name('site.cookies');
Route::get('registration-success', [HomeController::class, 'success'])->name('register.success');


Route::prefix('seller-program')->name('seller.')->group(function () {
    Route::get('/', [SurveyController::class, 'sellerProgram'])->name('program');
    Route::get('/survey/success', [SurveyController::class, 'sellerSuccess'])->name('success');
    Route::get('/survey', [SurveyController::class, 'sellerSurvey'])->name('survey');
    Route::post('/survey', [SurveyController::class, 'storeSurvey'])->name('survey.store');

});
Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/index/{name}/{type?}', [ProfileController::class, 'index'])->name('index');
    Route::get('/add-favourite/{name}', [ProfileController::class, 'addFav'])->name('add.favourite');
    Route::get('/add-block/{name}', [ProfileController::class, 'addBlock'])->name('add.block');
    Route::get('/unsubscribe/{email}', [ProfileController::class , 'unsubscribe'])->name('unsubscribe');

});

Route::get('referral-link/{slug}',[HomeController::class , 'referralLink'])->name('referral.link');

Route::get('collector/number',[HomeController::class , 'testCollectorNumber']);

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('index',[CartController::class , 'index'])->name('index');
    Route::get('add/{seller_id}/{collection_id}',[CartController::class , 'add'])->name('add');
    Route::get('remove/{seller_id}/{collection_id}',[CartController::class , 'remove'])->name('remove');
    Route::get('emptyCartAfterDay',[CartController::class , 'emptyCartAfterDay'])->name('empty.cart.after.day');
});

Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('confirm',[CheckoutController::class , 'confirm'])->name('confirm');
    Route::post('proceed',[CheckoutController::class , 'proceed'])->name('proceed');
    Route::get('thank-you',[CheckoutController::class , 'success'])->name('success');
    Route::get('payment/{id}',[CheckoutController::class , 'payment'])->name('payment');
});

use GuzzleHttp\Client;
use App\Models\MTG\MtgSet;
use App\Services\Admin\MTG\importCards;
Route::get('get/sets/to/import',function(importCards $importCards){
            $importCards->cards();
});




require __DIR__.'/mtg/mtg_web.php';
require __DIR__.'/sw/sw_web.php';
require __DIR__.'/admin.php';
require __DIR__.'/auth.php';
require __DIR__.'/user.php';


require __DIR__.'/testRoutes.php';
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.xml');
Route::get('/{type}', [HomeController::class, 'page'])->name('page');
Route::get('/terms-conditions', [HomeController::class, 'page'])->name('terms');
Route::get('/about', [HomeController::class, 'page'])->name('about');
Route::get('/marketplace-community-rules', [HomeController::class, 'page'])->name('market-rules');
Route::get('/how-to-sell-collectible-cards-products-online', [HomeController::class, 'page'])->name('guide');


Route::get('/get/visitor/info', [HomeController::class, 'getVisitorInfo'])->name('get.visitor.info');


Route::get('/testNot/data/ale', function(){
    $user = auth()->user();
    $m = new Message();
    sendNotification($user->id,1 , 'message','Your Kyc Has Been Approved.' ,$m);
});
// Route::get('/sitemap/sitemapCards.xml', [SitemapController::class, 'cardsSitemap'])->name('cards.sitemap.xml');
