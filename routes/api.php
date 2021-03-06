<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LicenseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('upload-file', [LicenseController::class, 'uploadFile']);
    Route::get('get-license-pdf', [LicenseController::class, 'getLicensePdf']);
    Route::get('send-email', [LicenseController::class, 'sendEmail'])->middleware('role:admin');
    Route::post('register-admin', [UserController::class, 'registerAdmin'])->middleware('role:admin');
});
