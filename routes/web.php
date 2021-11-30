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
    Route::get('/', [Controllers\RoleController::class, 'index'])->name('roleList');
    Route::post('/list', [Controllers\RoleController::class, 'getList'])->name('getRoleList');
    Route::post('/submit', [Controllers\RoleController::class, 'store'])->name('roleSubmit');
    Route::post('/edit', [Controllers\RoleController::class, 'getRoleById'])->name('getRoleById');
    // Route::post('/delete', [Controllers\RoleController::class, 'destroy'])->name('roleDelete')->middleware('haspermission:deleteRole');
    // Route::post('/permission', [Controllers\RoleController::class, 'rolePermissions'])->name('rolePermissions')->middleware('haspermission:assignPermissionRole');
    // Route::post('/assign/permission', [Controllers\RoleController::class, 'assignPermissions'])->name('assignPermissions')->middleware('haspermission:assignPermissionRole');
});
}
);


Auth::routes();

