<?php
use App\Http\Controllers\Admin\SW\ExpansionController;
use App\Http\Controllers\Admin\SW\ProductController;
use App\Http\Controllers\Admin\SW\AttributeController;
use App\Http\Controllers\Admin\SW\ImportCardsController;
use Illuminate\Support\Facades\Route;

Route::as('sw.')->prefix('sw')->group(function () {

    Route::as('expansion.')->prefix('expansion')->group(function () {
        Route::get('/', [ExpansionController::class,'index'])->name('index');
        Route::get('/create', [ExpansionController::class,'create'])->name('create');
        Route::post('/store', [ExpansionController::class,'store'])->name('store');
        Route::get('/edit/{id}', [ExpansionController::class,'edit'])->name('edit');
        Route::get('/inactive/{id}', [ExpansionController::class,'inactive'])->name('inactive');
        Route::get('/active/{id}', [ExpansionController::class,'active'])->name('active');
        Route::get('/seo/{id}', [ExpansionController::class,'seo'])->name('seo');
        Route::post('/seo/{id}', [ExpansionController::class,'seoStore'])->name('seo.store');
    });
   
    Route::as('attributes.')->prefix('attributes')->group(function () {
        Route::get('/', [AttributeController::class,'index'])->name('index');
        Route::post('/store', [AttributeController::class,'store'])->name('store');
        Route::post('/update/{id}', [AttributeController::class,'update'])->name('update');
        Route::delete('/destroy/{id}', [AttributeController::class,'destroy'])->name('destroy');
    });
   

    Route::as('products.')->prefix('products')->group(function () {
        Route::get('/import', [ImportCardsController::class, 'importCards'])->name('import');
        Route::get('/create/{type}', [ProductController::class,'create'])->name('create');
        Route::get('/list/{type}/{expansion?}', [ProductController::class,'index'])->name('index');
        Route::delete('/destroy/{id}', [ProductController::class,'destroy'])->name('destroy');
        Route::get('/seo/{id}', [ProductController::class,'seo'])->name('seo');
        Route::post('/seo/store', [ProductController::class,'seoStore'])->name('seo.store');
        Route::post('/store', [ProductController::class,'store'])->name('store');

    });
    
});