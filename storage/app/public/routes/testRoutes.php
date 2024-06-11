<?php

use App\Http\Controllers\Test\AddWeightsToProducts;
use App\Http\Controllers\Test\ImportFromExcelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Test\MailTestController;
use App\Http\Controllers\Test\SetImportController;
use App\Http\Controllers\Test\MtgCardTestController;
use App\Http\Controllers\Test\MtgFullSetController;
use App\Http\Controllers\Test\MtgSealedController;
use App\Http\Controllers\Test\MtgSymbolController;
use App\Http\Controllers\Test\SettingController;

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


Route::prefix('import')->group(function () {
    Route::get('sets', [SetImportController::class, 'sets'])->name('sets');
    Route::get('update/sets', [SetImportController::class, 'updateSets'])->name('update.sets');
    Route::get('match', [SetImportController::class, 'match'])->name('match');
    Route::get('sets/seo/detail', [SetImportController::class, 'getSeoDetail']);

    Route::get('symbols',[MtgSymbolController::class , 'importSymbols']);

    Route::get('sealed-product',[MtgSealedController::class , 'importSealed']);
    Route::get('full-sets',[MtgFullSetController::class , 'importFullSet']);

    Route::get('cards', [MtgCardTestController::class, 'importCards'])->name('import.cards');
    Route::get('update', [MtgCardTestController::class, 'updateCards'])->name('update.cards');
    Route::get('name', [MtgCardTestController::class, 'updateCardName'])->name('name.cards');

});



Route::prefix('test')->group(function () {

    Route::get('mail', [MailTestController::class, 'mailTest']);
    Route::get('mail/config', [MailTestController::class, 'mailConfiguration']);
    Route::get('mail/config', [MailTestController::class, 'mailConfiguration']);
    Route::get('mail/purchase', [MailTestController::class, 'purchase']);
});

Route::prefix('excel')->group(function () {
    Route::get('import/{type}/{filename}', [ImportFromExcelController::class, 'import']);
});

Route::get('change/masterpeice/to/single',[SettingController::class , 'masterToSingle']);
Route::get('generate/seo/options/for/sets',[SettingController::class , 'generateSeoOtionsForSets']);
Route::get('add/oracle-text/for/mtg-cards',[SettingController::class , 'addOracleTextOfCards']);
Route::get('complete/rarity',[SettingController::class , 'completeRarity']);
Route::get('add/sets/language/to/sealed-complete',[SettingController::class , 'addSetsLangToSealedAndComplete']);
Route::get('update/users/role/type',[SettingController::class , 'updateUsers']);

Route::get('generate/color/orders',[SettingController::class , 'generateColorOrders']);

Route::get('add/weight/to/sealed/{filename}/{weight}',[AddWeightsToProducts::class , 'sealed']);
Route::get('add/weight/to/complete',[AddWeightsToProducts::class , 'completed']);


Route::get('add/card/values/to/collections',[MtgCardTestController::class , 'getCardValuesToCollections']);

