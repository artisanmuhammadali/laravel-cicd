<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SellerSurveyController;
use App\Http\Controllers\Admin\AjaxController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\DisputeUserController;
use App\Http\Controllers\Admin\Authorization\RoleController;
use App\Http\Controllers\Admin\Authorization\TeamController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\MTG\SetController;
use App\Http\Controllers\Admin\PostageController;
use App\Http\Controllers\Admin\RedirectController;
use App\Http\Controllers\Admin\ReferralTypeController;
use App\Http\Controllers\Admin\MarketingController;



use App\Http\Controllers\Admin\PspOrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\Accounts\WithdrawController;

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

Route::prefix('admin')->name('admin.')->middleware(['auth','is_admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/transaction/list', [DashboardController::class, 'transaction'])->name('transaction.list');
    Route::get('/profile/form', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [DashboardController::class, 'profileSave'])->name('profile.save');
    Route::get('/account/settings', [DashboardController::class, 'accountSetting'])->name('account.settings');
    Route::get('/run-user-inactive-command', [DashboardController::class, 'runUserInactiveCommand'])->name('user.inactive.command');
    Route::post('/security', [DashboardController::class, 'securityUpdate'])->name('security.update');
    Route::as('dispute.')->prefix('dispute')->group(function () {
        Route::get('/users', [DisputeUserController::class,'list'])->name('users');
        Route::get('/modal/{id}', [DisputeUserController::class,'modal'])->name('modal');
        Route::post('/update/user', [DisputeUserController::class,'updateUserStatus'])->name('update.user');
    });

    Route::resource('/surveys', SellerSurveyController::class);

    Route::as('marketing.')->prefix('marketing')->group(function () {
        Route::get('/emails', [MarketingController::class,'emails'])->name('email');
        Route::get('/emails/list', [MarketingController::class,'list'])->name('list');
        Route::get('/emails/detail/{id}', [MarketingController::class,'detail'])->name('detail');
        Route::post('/send', [MarketingController::class,'send'])->name('send');
        Route::post('ckeditor/upload', [MarketingController::class, 'upload'])->name('ckeditor.upload');

    });

    Route::get('ajax/get/page/setting',[AjaxController::class , 'getPage'])->name('ajax.get.page.setting');

    Route::as('postage.')->prefix('postage')->group(function () {
        Route::get('/', [PostageController::class,'index'])->name('index');
        Route::post('/store', [PostageController::class,'store'])->name('store');
        Route::get('/modal/{id?}', [PostageController::class,'modal'])->name('modal');
        Route::delete('/destroy/{id}', [PostageController::class,'destroy'])->name('destroy');
    });
    Route::as('redirect.')->prefix('redirect')->group(function () {
        Route::get('/', [RedirectController::class,'index'])->name('index');
        Route::post('/store', [RedirectController::class,'store'])->name('store');
        Route::get('/modal/{id?}', [RedirectController::class,'modal'])->name('modal');
        Route::delete('/delete/{id}', [RedirectController::class,'delete'])->name('delete');
    });
    Route::as('orders.')->prefix('orders')->group(function () {
        Route::get('/list/{type?}', [OrderController::class,'index'])->name('index');
        Route::get('/detail/{id}', [OrderController::class , 'detail'])->name('detail');
        Route::get('/update/{id}/{type}', [OrderController::class , 'update'])->name('update');
        Route::get('chat/get', [OrderController::class, 'getChat'])->name('chat.get');
    });
    Route::as('psp.')->prefix('psp')->group(function () {
        Route::get('/', [PspOrderController::class,'index'])->name('index');
    });
    Route::as('announcement.')->prefix('announcement')->group(function () {
        Route::get('/list', [AnnouncementController::class,'index'])->name('index');
        Route::get('/view/{type?}/{id?}', [AnnouncementController::class,'view'])->name('view');
        Route::post('/save', [AnnouncementController::class,'save'])->name('save');
        Route::get('/delete/{id}', [AnnouncementController::class,'delete'])->name('delete');
    });

    Route::as('transaction.')->prefix('transaction')->group(function () {
        Route::get('/detail/{id}', [TransactionController::class,'detail'])->name('detail');
    });
    Route::as('account.')->prefix('account')->group(function () {
        Route::as('withdraw.')->prefix('withdraw')->group(function () {
            Route::get('/', [WithdrawController::class,'index'])->name('index');
            Route::post('/update', [WithdrawController::class,'update'])->name('update');
            Route::get('/detail/{id?}', [WithdrawController::class,'detail'])->name('detail');
            Route::get('/modal/{id?}', [WithdrawController::class,'modal'])->name('modal');
        });
    });
     Route::as('user.')->prefix('user')->group(function () {
        Route::get('/list/{type?}', [UserController::class, 'list'])->name('list');
        Route::get('/protection/{type?}', [UserController::class, 'protection'])->name('protection');
        Route::get('/cancel/orders', [UserController::class, 'cancelOrderUsers'])->name('cancel.orders');
        Route::get('/detail/{id}/{view?}', [UserController::class,'detail'])->name('detail');
        Route::get('/email/{id}', [UserController::class,'email'])->name('email');
        Route::get('/email/{id}', [UserController::class,'email'])->name('email');
        Route::post('/email/send', [UserController::class,'sendEmail'])->name('email.send');
        Route::get('/collections/{id}/{view?}', [UserController::class,'collections'])->name('collections');
        Route::get('/orders/{id}/{view?}', [UserController::class,'orders'])->name('orders');
        Route::get('/transactions/{id}/{view?}', [UserController::class,'transactions'])->name('transactions');
        Route::get('/referal/{id}/{view?}', [UserController::class,'referal'])->name('referal');
        Route::get('/reviews/{id}/{view?}', [UserController::class,'reviews'])->name('reviews');
        Route::get('/survey/{id}/{view?}', [UserController::class,'survey'])->name('survey');
        Route::post('/edit', [UserController::class,'edit'])->name('edit');
        Route::get('/restore/{id}', [UserController::class,'restore'])->name('restore');
        Route::post('/manage', [UserController::class,'manage'])->name('manage');
        Route::get('/delete/{id}', [UserController::class,'delete'])->name('delete');
        Route::as('referral.')->prefix('referraltype')->group(function () {
            Route::get('/', [ReferralTypeController::class,'index'])->name('index');
            Route::post('/store', [ReferralTypeController::class,'store'])->name('store');
            Route::get('/modal/{id?}', [ReferralTypeController::class,'modal'])->name('modal');
            Route::delete('/delete/{id}', [ReferralTypeController::class,'delete'])->name('delete');
        });
        Route::get('/status/{status}',[UserController::class , 'status'])->name('status');
    });

    require __DIR__.'/admin/mtgRoutes.php';
    require __DIR__.'/admin/swRoutes.php';

    Route::resources([
        'roles'     => RoleController::class,
        'teams'     => TeamController::class,
    ]);

    Route::get('roles/delete/{id?}', [RoleController::class, 'delete'])->name('roles.delete');
    Route::get('teams/remove/{id?}', [TeamController::class, 'remove'])->name('teams.remove');


});

