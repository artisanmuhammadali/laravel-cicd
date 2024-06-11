<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MTG\SettingController;
use App\Http\Controllers\Admin\Authorization\RoleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('mtg/card/price/{id}',[SettingController::class , 'averagePrice']);
require __DIR__.'/api/general/generalRoutes.php';



Route::get('permission/{permission}',[RoleController::class , 'addPermission']);
