<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('/unauthenticate', [App\Http\Controllers\ApiAuthenticateController::class, 'invalidTocken'])->name('apiUnAuthenticatedUser');
// Route::group(['middleware' => 'APIToken'], function ()  {
    Route::prefix('zip-code')->group(function () {
        Route::get('/list',  [App\Http\Controllers\ZipController::class, 'getZipcodesDropdownList']);
        Route::post('time-slots',
            [App\Http\Controllers\ZipController::class, 'getZipCodeTimeSlots']
        )->middleware('APIToken');
    });
    Route::post('create-booking',  [App\Http\Controllers\BookingController::class, 'store'])->middleware('APIToken');
// });
