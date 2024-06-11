<?php

use App\Http\Controllers\Front\MTG\IndexController;
use App\Http\Controllers\Front\MTG\ExpansionController;
use App\Http\Controllers\Front\MTG\SearchController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| MTG Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('magic-the-gathering')->name('mtg.')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::get('/newly-added/{type}', [IndexController::class, 'newlyCollectionType'])->name('newly.collection.type');
    Route::get('/featured-items/{type}', [IndexController::class, 'featuredItemsType'])->name('featured.items.type');
    Route::get('/marketplace/{type}', [IndexController::class, 'marketplace'])->name('marketplace');
    Route::prefix('expansion')->name('expansion.')->group(function () {
        Route::get('/', [ExpansionController::class, 'index'])->name('index');
        Route::get('/{slug}', [ExpansionController::class, 'set'])->name('set');
        Route::get('/{slug}/{type}', [ExpansionController::class, 'type'])->name('type');
        Route::get('/{set_slug}/{type}/{slug}', [ExpansionController::class, 'detail'])->name('detail');
    });
    

    Route::get('/detailed-search', [IndexController::class, 'detailedSearch'])->name('detailedSearch');
    Route::get('/detailed-search/results', [SearchController::class, 'detailedSearch'])->name('detailed.search');

    Route::get('/v1', [IndexController::class, 'levelOne'])->name('v1');

    Route::get('search-list',[SearchController::class , 'generalSearch'])->name('general.search');
    Route::get('search-list/{type}/all',[SearchController::class , 'sepecificSearch'])->name('specific.search');
    Route::get('sort-collection',[SearchController::class , 'sortCollection'])->name('sort.collection');


});




Route::get('/single', function () {
    return view('front.mtg.single');
})->name('single');

Route::get('/flip', function () {
    return view('front.mtg.flip_single');
})->name('flip');
Route::get('/sealed', function () {
    return view('front.mtg.sealed');
})->name('sealed');
