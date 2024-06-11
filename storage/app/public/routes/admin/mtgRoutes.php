<?php

use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FaqCategoryController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\MTG\ChatController;
use App\Http\Controllers\Admin\MTG\SetController;
use App\Http\Controllers\Admin\MTG\CardController;
use App\Http\Controllers\Admin\MTG\PageController;
use App\Http\Controllers\Admin\MTG\TemplateController;
use App\Http\Controllers\Admin\MTG\StandardSetController;
use App\Http\Controllers\Admin\MTG\CRM\CrmController;
use App\Http\Controllers\Admin\MTG\Product\ProductController;
use App\Http\Controllers\Admin\MTG\Setting\AttributeController;
use App\Http\Controllers\Admin\MTG\Setting\CustomTypeController;
use Illuminate\Support\Facades\Route;

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

    Route::as('mtg.')->prefix('mtg')->group(function () {

        Route::get('chat', [ChatController::class , 'chat'])->name('chat');
        Route::get('conversation/{id}', [ChatController::class , 'conversation'])->name('conversation');
        Route::get('conversation', [ChatController::class , 'getChat'])->name('chat.get.conversation');
        Route::post('save/messages', [ChatController::class , 'saveChat'])->name('chat.save.message');

        Route::as('sets.')->prefix('sets')->group(function () {
            Route::get('/{type}', [SetController::class,'index'])->name('index');
            Route::get('/create/{type}', [SetController::class,'create'])->name('create');
            Route::post('/store', [SetController::class,'store'])->name('store');
            Route::get('/edit/{id}', [SetController::class,'edit'])->name('edit');
            Route::get('/api/update/{code}', [SetController::class,'updateApi'])->name('api.update');
            Route::post('/update/{id}', [SetController::class,'update'])->name('update');
            Route::delete('/remove/child/{id}', [SetController::class,'removeChild'])->name('removeChild');
            Route::get('/active/{id}/{type?}', [SetController::class,'active'])->name('active');
            Route::get('/inactive/{id}', [SetController::class,'inactive'])->name('inactive');
            Route::get('/modal/{id?}/{type?}', [SetController::class,'modal'])->name('modal');
            Route::get('/seo/{id}', [SetController::class,'seo'])->name('seo');
            Route::post('/seo/{id}', [SetController::class,'seoStore'])->name('seo.store');
            Route::post('/languages', [SetController::class,'languages'])->name('languages');
            Route::post('/legality', [SetController::class,'legality'])->name('legality');


            Route::post('/clone', [SetController::class,'clone'])->name('clone');
        });
        Route::as('standard.set.')->prefix('standard-set')->group(function () {
            Route::get('/', [StandardSetController::class,'index'])->name('index');
            Route::get('/modal', [StandardSetController::class,'modal'])->name('modal');
            Route::post('/store', [StandardSetController::class,'store'])->name('store');
            Route::delete('/delete/{id}', [StandardSetController::class,'delete'])->name('delete');          
        });

        Route::as('cards.')->prefix('cards')->group(function () {
            Route::get('/', [CardController::class,'index'])->name('index');
            Route::get('/append/products', [CardController::class,'appendProducts'])->name('append.products');
            Route::post('/selected/products', [CardController::class,'selectedProducts'])->name('selected.products');
            Route::post('/selected/products/store/attributes', [CardController::class,'storeProductAttributes'])->name('store.products.attributes');
            Route::get('/append/Columns', [CardController::class,'appendColumns'])->name('append.columns');
            Route::get('/remove/attribute/{card_id}/{attribute_id}', [CardController::class,'removeAttributes'])->name('remove.attribute');
        });

        Route::as('products.')->prefix('products')->group(function () {
            Route::get('/update/new/{id}', [ProductController::class,'updateNew'])->name('update.new');
            Route::get('/list/{type?}/{type2?}', [ProductController::class,'index'])->name('index');
            Route::get('/create/{type?}/{type2?}', [ProductController::class,'create'])->name('create');
            Route::get('/renderViews/{type?}', [ProductController::class,'renderViews'])->name('render.views');
            Route::post('/store', [ProductController::class,'store'])->name('store');
            Route::post('/singleCardSave', [ProductController::class,'singleCardSave'])->name('single.sard.save');
            Route::get('/upload-csv/{type}', [ProductController::class,'uploadCsv'])->name('upload.csv');
            Route::delete('/destroy/{id}', [ProductController::class,'destroy'])->name('destroy');
            Route::get('/active/{id}', [ProductController::class,'active'])->name('active');
            Route::get('/seo/{id}', [ProductController::class,'seo'])->name('seo');
            Route::post('/languages', [ProductController::class,'languages'])->name('languages');
            Route::post('/legality', [ProductController::class,'legality'])->name('legality');
        });

        Route::as('crm.')->prefix('crm')->group(function () {
            Route::get('site-visit', [CrmController::class, 'siteVisit'])->name('site.visit');
            Route::get('account-registrations', [CrmController::class, 'accountRegistrations'])->name('account.registrations');
            Route::get('deleted-accounts', [CrmController::class, 'deletedAccounts'])->name('accounts.deleted');
            Route::get('deleted-accounts-list', [CrmController::class, 'deletedAccountsList'])->name('accounts.deleted.list');
            Route::get('collection-listings', [CrmController::class, 'collectionListings'])->name('collection.listing');
            Route::get('account-registration-conversions', [CrmController::class, 'accountRegistrationConversions'])->name('account.registration.conversions');
            Route::get('success-checkout', [CrmController::class, 'successCheckout'])->name('success.checkout');
            Route::get('buyer-spending', [CrmController::class, 'buyerSpending'])->name('buyer.spending');
            Route::get('seller-earning', [CrmController::class, 'sellerEarning'])->name('seller.earning');
            Route::get('transactions', [CrmController::class, 'transactions'])->name('transactions');
            Route::get('revenue', [CrmController::class, 'revenues'])->name('revenue');
            Route::get('dispute/users/list', [CrmController::class, 'disputeUsersList'])->name('dispute.users.list');
            Route::get('orders/cancel/users/list', [CrmController::class, 'orderCancelUsersList'])->name('order.cancel.users.list');
            Route::get('users/protection/list', [CrmController::class, 'protectionUsersList'])->name('protection.users.list');
            Route::get('users/revies/list', [CrmController::class, 'reviewUsersList'])->name('reviews.users.list');
            Route::get('sellers-to-buyers', [CrmController::class, 'sellersToBuyers'])->name('seller.to.buyer');
            Route::get('orders', [CrmController::class, 'orders'])->name('orders');
            Route::get('export', [CrmController::class, 'export'])->name('export');

        });
        Route::as('cms.')->prefix('cms')->group(function () {
            Route::post('/', [SettingController::class,'store'])->name('store');
            Route::get('/setting/{type}', [SettingController::class,'cms'])->name('setting');

            Route::get('page/design/{slug}', [PageController::class, 'pageDesign'])->name('page.design');
            Route::get('toggle/status', [PageController::class, 'toggleStatus'])->name('pages.toggle.status');
            Route::post('ckeditor/upload', [PageController::class, 'upload'])->name('pages.ckeditor.upload');
            Route::resource('/pages', PageController::class);
            Route::get('/templates/list', [TemplateController::class,'templateList'])->name('templates.list');
            Route::resource('/templates', TemplateController::class);
            Route::resource('/faqs', FaqController::class);

            Route::as('faq_categories.')->prefix('faq/categories')->group(function () {
                Route::get('/', [FaqCategoryController::class,'index'])->name('index');
                Route::post('/store', [FaqCategoryController::class,'store'])->name('store');
                Route::post('/update/{id}', [FaqCategoryController::class,'update'])->name('update');
                Route::delete('/destroy/{id}', [FaqCategoryController::class,'destroy'])->name('destroy');
            });
        });

        Route::as('attributes.')->prefix('attributes')->group(function () {
            Route::get('/', [AttributeController::class,'index'])->name('index');
            Route::post('/store', [AttributeController::class,'store'])->name('store');
            Route::post('/update/{id}', [AttributeController::class,'update'])->name('update');
            Route::delete('/destroy/{id}', [AttributeController::class,'destroy'])->name('destroy');
        });
        Route::as('custom-type.')->prefix('custom-type')->group(function () {
            Route::get('/', [CustomTypeController::class,'index'])->name('index');
            Route::post('/store', [CustomTypeController::class,'store'])->name('store');
            Route::get('/modal/{id?}', [CustomTypeController::class,'modal'])->name('modal');
            Route::delete('/destroy/{id}', [CustomTypeController::class,'destroy'])->name('destroy');
        });
    });
