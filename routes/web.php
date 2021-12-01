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
        Route::get('/', [Controllers\CategoryController::class, 'index'])->name('categoryList')->middleware('haspermission:viewCategory');
        Route::post('/list', [Controllers\CategoryController::class, 'getList'])->name('getCategoryList');
        Route::post('/submit', [Controllers\CategoryController::class, 'store'])->name('categorySubmit')->middleware('haspermission:addCategory');
        Route::post('/edit', [Controllers\CategoryController::class, 'getCategoryById'])->name('getCategoryById')->middleware('haspermission:editCategory');
        Route::post('/delete', [Controllers\CategoryController::class, 'destroy'])->name('categoryDelete')->middleware('haspermission:deleteCategory');
        // Route::post('get-category-products', [Controllers\CategoryController::class, 'getProductByCategory'])->name('getProductsByCategory');

    });

    Route::prefix('zip')->group(function () {
        Route::get('/', [Controllers\ZipController::class, 'index'])->name('zipList');
        Route::post('/list', [Controllers\ZipController::class, 'getList'])->name('getZipList');
        Route::post('/submit', [Controllers\ZipController::class, 'store'])->name('zipSubmit');
        Route::post('/edit', [Controllers\ZipController::class, 'getZipById'])->name('getZipById');
        Route::post('/delete', [Controllers\ZipController::class, 'destroy'])->name('zipDelete');


    });

    Route::prefix('users')->group(function () {
            Route::get('/', [Controllers\UserController::class, 'index'])->name('userList');
            Route::post('/list', [Controllers\UserController::class, 'getList'])->name('getUserList');
            Route::post('/edit', [Controllers\UserController::class, 'getUserById'])->name('getUserById');
            Route::post('/submit', [Controllers\UserController::class, 'store'])->name('userSubmit');
            Route::post('/delete', [Controllers\UserController::class, 'destroy'])->name('userDelete');
        });

    Route::prefix('permission')->group(function () {
        Route::get('/', [Controllers\PermissionController::class, 'index'])->name('permissionList')->middleware('haspermission:viewPermission');
        Route::post('/list', [Controllers\PermissionController::class, 'getList'])->name('getPermissionList');
        Route::post('/submit', [Controllers\PermissionController::class, 'store'])->name('permissionSubmit')->middleware('haspermission:addPermission');
        Route::post('/edit', [Controllers\PermissionController::class, 'getPermissionById'])->name('getPermissionById')->middleware('haspermission:editPermission');
        Route::post('/delete', [Controllers\PermissionController::class, 'destroy'])->name('permissionDelete')->middleware('haspermission:deletePermission');
        // Route::post('/get', [Controllers\PermissionController::class, 'getPermissionByRoleId'])->name('getPermissionByRoleId')->middleware('haspermission:viewPermission');
    });


    Route::prefix('role')->group(function () {
        Route::get('/', [Controllers\RoleController::class, 'index'])->name('roleList')->middleware('haspermission:viewRole');
        Route::post('/list', [Controllers\RoleController::class, 'getList'])->name('getRoleList')->middleware('haspermission:viewRole');
        Route::post('/submit', [Controllers\RoleController::class, 'store'])->name('roleSubmit')->middleware('haspermission:addRole');
        Route::post('/edit', [Controllers\RoleController::class, 'getRoleById'])->name('getRoleById')->middleware('haspermission:editRole');
        Route::post('/delete', [Controllers\RoleController::class, 'destroy'])->name('roleDelete')->middleware('haspermission:deleteRole');
        Route::post('/permission', [Controllers\RoleController::class, 'rolePermissions'])->name('rolePermissions')->middleware('haspermission:assignPermissionRole');
        Route::post('/assign/permission', [Controllers\RoleController::class, 'assignPermissions'])->name('assignPermissions')->middleware('haspermission:assignPermissionRole');
    });
    Route::prefix('department')->group(function () {
        Route::get('/', [Controllers\DepartmentController::class, 'index'])->name('departmentList');
        Route::post('/list', [Controllers\DepartmentController::class, 'getList'])->name('getdepartmentList');
        Route::post('/submit', [Controllers\DepartmentController::class, 'store'])->name('departmentSubmit');
        Route::post('/edit', [Controllers\DepartmentController::class, 'getDepartmentById'])->name('getDepartmentById');
        Route::post('/delete', [Controllers\DepartmentController::class, 'destroy'])->name('departmentDelete');
    });
    Route::prefix('item')->group(function () {
        Route::get('/', [Controllers\ItemController::class, 'index'])->name('itemList');
        Route::post('/list', [Controllers\ItemController::class, 'getList'])->name('getItemList');
        Route::post('/submit', [Controllers\ItemController::class, 'store'])->name('itemSubmit');
        Route::post('/edit', [Controllers\ItemController::class, 'getItemById'])->name('getItemById');
        Route::post('/delete', [Controllers\ItemController::class, 'destroy'])->name('itemDelete');
        // Route::post('/permission', [Controllers\RoleController::class, 'rolePermissions'])->name('rolePermissions')->middleware('haspermission:assignPermissionRole');
        // Route::post('/assign/permission', [Controllers\RoleController::class, 'assignPermissions'])->name('assignPermissions')->middleware('haspermission:assignPermissionRole');
    });
});
Auth::routes();
