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
    Route::prefix('categories')->group(function () {
        Route::get('/', [Controllers\CategoryController::class, 'index'])->name('categoryList');
        Route::post('/list', [Controllers\CategoryController::class, 'getList'])->name('getCategoryList');
        Route::post('/submit', [Controllers\CategoryController::class, 'store'])->name('categorySubmit');
        Route::post('/edit', [Controllers\CategoryController::class, 'getCategoryById'])->name('getCategoryById');
        Route::post('/delete', [Controllers\CategoryController::class, 'destroy'])->name('categoryDelete');
        // Route::post('get-category-products', [Controllers\CategoryController::class, 'getProductByCategory'])->name('getProductsByCategory');

    });

    Route::prefix('zip')->group(function () {
        Route::get('/', [Controllers\ZipController::class, 'index'])->name('zipList');
        Route::post('/list', [Controllers\ZipController::class, 'getList'])->name('getZipList');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [Controllers\UserController::class, 'index'])->name('userList');
    });
    Route::prefix('zip')->group(function () {
        Route::get('/', [Controllers\ZipController::class, 'index'])->name('zipList');
    });
    Route::prefix('permission')->group(function () {
        Route::get('/', [Controllers\PermissionController::class, 'index'])->name('permissionList');
        Route::post('/list', [Controllers\PermissionController::class, 'getList'])->name('getPermissionList');
        Route::post('/submit', [Controllers\PermissionController::class, 'store'])->name('permissionSubmit');
        // Route::post('/edit', [Controllers\PermissionController::class, 'getPermissionById'])->name('getPermissionById')->middleware('haspermission:editPermission');
        // Route::post('/delete', [Controllers\PermissionController::class, 'destroy'])->name('permissionDelete')->middleware('haspermission:deletePermission');
        // Route::post('/get', [Controllers\PermissionController::class, 'getPermissionByRoleId'])->name('getPermissionByRoleId')->middleware('haspermission:viewPermission');
    });


    Route::prefix('role')->group(function () {
        Route::get('/', [Controllers\RoleController::class, 'index'])->name('roleList');
        Route::post('/list', [Controllers\RoleController::class, 'getList'])->name('getRoleList');
        Route::post('/submit', [Controllers\RoleController::class, 'store'])->name('roleSubmit');
        Route::post('/edit', [Controllers\RoleController::class, 'getRoleById'])->name('getRoleById');
        Route::post('/delete', [Controllers\RoleController::class, 'destroy'])->name('roleDelete');
    });
});
Auth::routes();
