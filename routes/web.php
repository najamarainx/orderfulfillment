<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => 'auth'], function () {

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('role')->group(function () {
    Route::get('/', [Controllers\RoleController::class, 'index'])->name('roleList')->middleware('haspermission:viewRole');

});

Route::prefix('users')->group(function () {
    Route::get('/', [Controllers\UserController::class, 'index'])->name('userList');

    });
Route::prefix('zip')->group(function () {
    Route::get('/', [Controllers\ZipController::class, 'index'])->name('zipList');

    });

});


Auth::routes();

