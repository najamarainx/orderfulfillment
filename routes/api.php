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

Route::prefix('api/zip-code')->group(function () {
    Route::post('get-zip-code-time-slots',
        [App\Http\Controllers\ZipController::class, 'getZipCodeTimeSlots']
    )->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::get('/list', [App\Http\Controllers\ZipController::class, 'getZipcodesDropdownList']);
});
