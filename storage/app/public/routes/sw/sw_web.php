<?php
use App\Http\Controllers\Front\SW\IndexController;
use App\Http\Controllers\Front\SW\SearchController;
use App\Http\Controllers\Front\SW\ExpansionController;
use Illuminate\Support\Facades\Route;

Route::prefix('star-wars-unlimited')->name('sw.')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');

    Route::get('/newly-added/{type}', [IndexController::class, 'newlyCollectionType'])->name('newly.collection.type');
    Route::get('/featured-items/{type}', [IndexController::class, 'featuredItemsType'])->name('featured.items.type');
    Route::prefix('expansion')->name('expansion.')->group(function () {
        Route::get('/', [ExpansionController::class, 'index'])->name('index');
        Route::get('/{slug}', [ExpansionController::class, 'set'])->name('set');
        Route::get('/{slug}/{type}', [ExpansionController::class, 'type'])->name('type');
        Route::get('/{set_slug}/{type}/{slug}', [ExpansionController::class, 'detail'])->name('detail');
    });


    Route::get('/detailed-search', [IndexController::class, 'detailedSearch'])->name('detailedSearch');
    Route::get('/detailed-search/results', [SearchController::class, 'detailedSearch'])->name('detailed.search');


    Route::get('search-list',[SearchController::class , 'generalSearch'])->name('general.search');
    Route::get('search-list/{type}/all',[SearchController::class , 'sepecificSearch'])->name('specific.search');
    Route::get('sort-collection',[SearchController::class , 'sortCollection'])->name('sort.collection');
});