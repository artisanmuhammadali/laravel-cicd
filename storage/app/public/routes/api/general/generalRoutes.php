<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MTG\SettingController;
use App\Http\Controllers\General\HelpWebhookController;
use App\Http\Controllers\General\MangoPayWebhookController;

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

Route::prefix('webhook')->group(function () {
    Route::post('zendesk', [HelpWebhookController::class,'zendesk']);
    Route::get('/kyc-success', [MangoPayWebhookController::class , 'KycSuccess']);
    Route::get('/kyc-failed', [MangoPayWebhookController::class , 'KycFailed']);
    Route::get('/ubo-success', [MangoPayWebhookController::class , 'UboSuccess']);
    Route::get('/ubo-failed', [MangoPayWebhookController::class , 'UboFailed']);
});

Route::get('magic-the-gathering/card/price/{id}', [SettingController::class, 'averagePrice']);
