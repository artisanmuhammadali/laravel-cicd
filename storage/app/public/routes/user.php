<?php

use App\Http\Controllers\User\AccountStatsController;
use App\Http\Controllers\User\AddressControler;
use App\Http\Controllers\User\CollectionController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\FavUserController;
use App\Http\Controllers\User\BlockUserController;
use App\Http\Controllers\User\MangoPayController;
use App\Http\Controllers\User\MessageController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\PaymentSettingController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\MTG\OrderChatController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\OrderReviewController;
use App\Http\Controllers\User\SearchController;
use App\Http\Controllers\User\SupportController;
use App\Http\Controllers\User\SW\SwCollectionController;
use App\Http\Controllers\User\TransactionController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->name('user.')->middleware(['auth' ,'is_user','verified'])->group(function () {

    Route::get('chat', [OrderChatController::class , 'chat'])->name('chat');
    Route::get('conversation', [OrderChatController::class , 'getChat'])->name('chat.get.conversation');
    Route::post('save/messages', [OrderChatController::class , 'saveChat'])->name('chat.save.message');

    Route::get('account', [DashboardController::class , 'index'])->name('account');
    Route::get('change-password', [DashboardController::class , 'changePassword'])->name('change.password');
    Route::get('destroy{id?}', [DashboardController::class , 'destroy'])->name('destroy');
    Route::get('change-status/{status}', [DashboardController::class , 'changeStatus'])->name('change.status');

    Route::prefix('account-stats')->name('account.stats.')->group(function () {
        Route::get('/', [AccountStatsController::class , 'index'])->name('index');
        Route::get('/export', [AccountStatsController::class , 'export'])->name('export');
    });


    Route::prefix('banking')->name('transaction.')->group(function () {
        Route::get('/list', [TransactionController::class , 'list'])->name('list');
        Route::get('/account-card', [TransactionController::class , 'accountCard'])->name('account.card');
        Route::post('/detail', [TransactionController::class , 'detail'])->name('detail');
    });
    Route::prefix('mangopay-registration')->name('mangopay.')->group(function () {
        Route::get('interest', [MangoPayController::class , 'interest'])->name('interest');
        Route::post('get-details', [MangoPayController::class , 'getDetails'])->name('details');
        Route::post('create-user', [MangoPayController::class , 'createUser'])->name('user');
        Route::get('get-kyc-payment', [MangoPayController::class , 'getKycPayment'])->name('get.kyc.payment');
        Route::get('upload-kyc', [MangoPayController::class , 'uploadKyc'])->name('upload.kyc');
        Route::get('re-upload-kyc', [MangoPayController::class , 'reUploadKyc'])->name('reupload.kyc');
        Route::post('submit-kyc', [MangoPayController::class , 'submitKyc'])->name('submit.kyc');
        Route::get('kyc-detail', [MangoPayController::class , 'kycDetail'])->name('kyc.detail');
    });

    Route::get('referral-user', [DashboardController::class , 'referralUser'])->name('referral');
    Route::get('cart', [DashboardController::class , 'cart'])->name('cart');
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::post('update-account', [ProfileController::class, 'updateAccount'])->name('update.account');
        Route::post('change-password', [ProfileController::class, 'changePassword'])->name('change.password');
        Route::post('update-user-info', [ProfileController::class, 'updateInfo'])->name('update.info');
        Route::post('update-avatar', [ProfileController::class, 'updateAvatar'])->name('update.avatar');
    });
    Route::prefix('address')->name('address.')->group(function () {
        Route::get('/', [AddressControler::class, 'index'])->name('index');
        Route::post('store{id?}', [AddressControler::class, 'store'])->name('store');
        Route::get('update/{id?}', [AddressControler::class, 'loadModal'])->name('loadModal');
        Route::get('destroy/{id}', [AddressControler::class, 'destroy'])->name('destroy');
    });
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
    });
    Route::prefix('order')->name('order.')->group(function () {
        Route::get('bulk/download', [OrderController::class, 'bulkDownload'])->name('bulk.download.pdf');
        Route::get('list/{type?}/{slug?}', [OrderController::class, 'index'])->name('index');
        Route::post('update', [OrderController::class, 'update'])->name('update');
        Route::get('detail/{id}/{type}', [OrderController::class, 'detail'])->name('detail');
        Route::post('extra-payment', [OrderController::class, 'extraPayment'])->name('extra.payment');

        Route::prefix('review')->name('review.')->group(function () {
            Route::post('save', [OrderReviewController::class, 'save'])->name('save');
        });
    });
    Route::prefix('favourite-user')->name('favourite.')->group(function () {
        Route::get('/', [FavUserController::class , 'index'])->name('index');
        Route::get('destroy/{id}', [FavUserController::class , 'destroy'])->name('destroy');
        Route::get('add/{name}', [FavUserController::class , 'add'])->name('add');
    });
    Route::prefix('block-user')->name('block.')->group(function () {
        Route::get('/', [BlockUserController::class , 'index'])->name('index');
        Route::get('destroy/{id}', [BlockUserController::class , 'destroy'])->name('destroy');
        Route::get('add/{name}', [BlockUserController::class , 'add'])->name('add');
    });
    Route::prefix('search')->name('search.')->group(function () {
        Route::get('/', [SearchController::class, 'generalSearch'])->name('generalSearch');
    });
    Route::prefix('wallets-credit')->name('payments.')->group(function () {
        Route::post('/register-card', [PaymentSettingController::class, 'registerCard'])->name('register.card');
        Route::post('/payin', [PaymentSettingController::class, 'payin'])->name('payin');
        Route::post('/payout', [PaymentSettingController::class, 'payout'])->name('payout');
        Route::post('/bank', [PaymentSettingController::class, 'bank'])->name('bank');
    });
    Route::prefix('notification')->name('notification.')->group(function () {
        Route::get('/{id}/view',[NotificationController::class , 'index'])->name('index');
        Route::get('/read-all',[NotificationController::class , 'readAll'])->name('read.all');
    });
    Route::prefix('support-tickets')->name('support-tickets.')->group(function () {
        Route::get('/list',[SupportController::class , 'list'])->name('list');
    });
});
Route::prefix('user')->name('user.')->middleware(['auth','is_user','verified','check_business'])->group(function () {
    Route::prefix('my-collection/magic-the-gathering')->name('collection.')->group(function () {
        Route::get('/list/{type?}', [CollectionController::class, 'index'])->name('index');
        Route::get('bulk-upload/{type}', [CollectionController::class , 'bulkUpload'])->name('bulk.upload');
        Route::get('csv-upload/{type}', [CollectionController::class , 'csvUpload'])->name('csv.upload');
        Route::any('save', [CollectionController::class , 'save'])->name('save');
        Route::get('/renderViews', [CollectionController::class , 'renderViews'])->name('renderViews');
        Route::get('/edit/{id}', [CollectionController::class , 'edit'])->name('edit');
        Route::any('/update-price', [CollectionController::class , 'updatePrice'])->name('update.price');
         Route::get('/update-bulk/ids', [CollectionController::class , 'updatebulkIds'])->name('bulk.update.ids');
         Route::get('/update-bulk', [CollectionController::class , 'updatebulk'])->name('bulk.update');
        Route::post('update/bulk/store', [CollectionController::class , 'updatebulkSave'])->name('bulk.edit.save');
        Route::any('/delete/{id?}', [CollectionController::class , 'delete'])->name('delete');
    });
    Route::prefix('my-collection/sw')->name('collection.sw.')->group(function () {
        Route::get('/search/cards', [SwCollectionController::class, 'searchCards'])->name('search.cards');
        Route::get('/list/{type?}', [SwCollectionController::class, 'index'])->name('index');
        Route::get('bulk-upload/{type}', [SwCollectionController::class , 'bulkUpload'])->name('bulk.upload');
        Route::get('csv-upload/{type}', [CollectionController::class , 'csvUpload'])->name('csv.upload');
        Route::any('save', [SwCollectionController::class , 'save'])->name('save');
        Route::get('/renderViews', [SwCollectionController::class , 'renderViews'])->name('renderViews');
        Route::get('/edit/{id}', [SwCollectionController::class , 'edit'])->name('edit');
        Route::any('/update-price', [SwCollectionController::class , 'updatePrice'])->name('update.price');
         Route::get('/update-bulk/ids', [CollectionController::class , 'updatebulkIds'])->name('bulk.update.ids');
         Route::get('/update-bulk', [CollectionController::class , 'updatebulk'])->name('bulk.update');
        Route::post('update/bulk/store', [CollectionController::class , 'updatebulkSave'])->name('bulk.edit.save');
        Route::any('/delete/{id?}', [SwCollectionController::class , 'delete'])->name('delete');
    });
});
