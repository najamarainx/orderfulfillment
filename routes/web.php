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
        Route::get('/', [Controllers\ZipController::class, 'index'])->name('zipList')->middleware('haspermission:viewZip');
        Route::post('/list', [Controllers\ZipController::class, 'getList'])->name('getZipList')->middleware('haspermission:viewZip');
        Route::post('/submit', [Controllers\ZipController::class, 'store'])->name('zipSubmit')->middleware('haspermission:addZip');
        Route::post('/edit', [Controllers\ZipController::class, 'getZipById'])->name('getZipById')->middleware('haspermission:editZip');
        Route::post('/delete', [Controllers\ZipController::class, 'destroy'])->name('zipDelete')->middleware('haspermission:deleteZip');


    });

    Route::prefix('users')->group(function () {
            Route::get('/', [Controllers\UserController::class, 'index'])->name('userList')->middleware('haspermission:viewUser');
            Route::post('/list', [Controllers\UserController::class, 'getList'])->name('getUserList')->middleware('haspermission:viewUser');
            Route::post('/edit', [Controllers\UserController::class, 'getUserById'])->name('getUserById')->middleware('haspermission:editUser');
            Route::post('/submit', [Controllers\UserController::class, 'store'])->name('userSubmit')->middleware('haspermission:addUser');
            Route::post('/delete', [Controllers\UserController::class, 'destroy'])->name('userDelete')->middleware('haspermission:deleteUser');
        });

    Route::prefix('permission')->group(function () {
        Route::get('/', [Controllers\PermissionController::class, 'index'])->name('permissionList')->middleware('haspermission:viewPermission');
        Route::post('/list', [Controllers\PermissionController::class, 'getList'])->name('getPermissionList')->middleware('haspermission:viewPermission');
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
        Route::get('/', [Controllers\DepartmentController::class, 'index'])->name('departmentList')->middleware('haspermission:viewDepartment');
        Route::post('/list', [Controllers\DepartmentController::class, 'getList'])->name('getdepartmentList')->middleware('haspermission:viewDepartment');
        Route::post('/submit', [Controllers\DepartmentController::class, 'store'])->name('departmentSubmit')->middleware('haspermission:addDepartment');
        Route::post('/edit', [Controllers\DepartmentController::class, 'getDepartmentById'])->name('getDepartmentById')->middleware('haspermission:editDepartment');
        Route::post('/delete', [Controllers\DepartmentController::class, 'destroy'])->name('departmentDelete')->middleware('haspermission:deleteDepartment');
    });
    Route::prefix('item')->group(function () {
        Route::get('/', [Controllers\ItemController::class, 'index'])->name('itemList')->middleware('haspermission:viewItem');
        Route::post('/list', [Controllers\ItemController::class, 'getList'])->name('getItemList')->middleware('haspermission:viewItem');
        Route::post('/submit', [Controllers\ItemController::class, 'store'])->name('itemSubmit')->middleware('haspermission:addItem');
        Route::post('/edit', [Controllers\ItemController::class, 'getItemById'])->name('getItemById')->middleware('haspermission:editItem');
        Route::post('/delete', [Controllers\ItemController::class, 'destroy'])->name('itemDelete')->middleware('haspermission:deleteItem');

    });
    Route::prefix('Supplier')->group(function () {
        Route::get('/', [Controllers\SupplierController::class, 'index'])->name('supplierList')->middleware('haspermission:viewSupplier');
        Route::post('/list', [Controllers\SupplierController::class, 'getList'])->name('getSupplierList')->middleware('haspermission:viewSupplier');
        Route::post('/submit', [Controllers\SupplierController::class, 'store'])->name('supplierSubmit')->middleware('haspermission:addSupplier');
        Route::post('/edit', [Controllers\SupplierController::class, 'getSupplierById'])->name('getSupplierById')->middleware('haspermission:editSupplier');
        Route::post('/delete', [Controllers\SupplierController::class, 'destroy'])->name('supplierDelete')->middleware('haspermission:deleteSupplier');
    });
    Route::prefix('variant')->group(function () {
        Route::get('/', [Controllers\VariantController::class, 'index'])->name('variantList')->middleware('haspermission:viewVariant');
        Route::post('/list', [Controllers\VariantController::class, 'getList'])->name('getVariantList')->middleware('haspermission:viewVariant');
        Route::post('/submit', [Controllers\VariantController::class, 'store'])->name('variantSubmit')->middleware('haspermission:viewItem');
        Route::post('/edit', [Controllers\VariantController::class, 'getVariantById'])->name('getVariantById')->middleware('haspermission:editVariant');
        Route::post('/delete', [Controllers\VariantController::class, 'destroy'])->name('variantDelete')->middleware('haspermission:deleteVariant');
        Route::post('get_item_variant', [Controllers\VariantController::class, 'getItemVariants'])->name('getItemVariants');

    });

    Route::prefix('stockorder')->group(function () {
        Route::get('/', [Controllers\SupplierStockController::class, 'index'])->name('stockList')->middleware('haspermission:viewStockPurchase');
        Route::post('/list', [Controllers\SupplierStockController::class, 'getList'])->name('getStockOrderList')->middleware('haspermission:viewStockPurchase');
        Route::post('/submit', [Controllers\SupplierStockController::class, 'store'])->name('stockorderSubmit')->middleware('haspermission:addStockPurchase');
        Route::post('/delete', [Controllers\SupplierStockController::class, 'destroy'])->name('stockorderDelete')->middleware('haspermission:deleteStockPurchase');
        Route::get('/detail/{id}', [Controllers\SupplierStockController::class, 'detailProduct'])->middleware('haspermission:detailStockPurchase');
        Route::post('/items', [Controllers\ItemController::class, 'getDeptItems'])->name('getDeptItems');
        Route::get('/edit/{id}', [Controllers\SupplierStockController::class, 'editPurchaseOrder'])->middleware('haspermission:detailStockPurchase');
        Route::post('/update', [Controllers\SupplierStockController::class, 'saveAndProceedOrder'])->name('stockorderUpdate');
    });

    Route::prefix('inventory')->group(function () {
        Route::get('/', [Controllers\InventoryItemController::class, 'index'])->name('inventoryList')->middleware('haspermission:inventoryList');
        Route::post('/list', [Controllers\InventoryItemController::class, 'getList'])->name('getInventoryItemList')->middleware('haspermission:inventoryList');
        // Route::post('/submit', [Controllers\VariantController::class, 'store'])->name('variantSubmit');
        // Route::post('/edit', [Controllers\VariantController::class, 'getVariantById'])->name('getVariantById');
        // Route::post('/delete', [Controllers\VariantController::class, 'destroy'])->name('variantDelete');

    });
    Route::prefix('time-slot')->group(function () {
        Route::get('/', [Controllers\TimeSlotController::class, 'index'])->name('slotList')->middleware('haspermission:viewTimeSlot');
        Route::post('/list', [Controllers\TimeSlotController::class, 'getList'])->name('getTimeSlotList')->middleware('haspermission:viewTimeSlot');
        Route::post('/submit', [Controllers\TimeSlotController::class, 'store'])->name('timeslotSubmit')->middleware('haspermission:addTimeSlot');
        Route::post('/edit', [Controllers\TimeSlotController::class, 'getTimeSlotById'])->name('getTimeSlotById')->middleware('haspermission:editTimeSlot');
        Route::post('/delete', [Controllers\TimeSlotController::class, 'destroy'])->name('timeSlotDelete')->middleware('haspermission:deleteTimeSlot');

    });
    Route::prefix('booking')->group(function () {
        Route::get('/', [Controllers\BookingController::class, 'index'])->name('bookingList')->middleware('haspermission:viewBooking');
        Route::post('/list', [Controllers\BookingController::class, 'getList'])->name('getBookingList')->middleware('haspermission:viewBooking');
        Route::post('/submit', [Controllers\BookingController::class, 'store'])->name('bookingSubmit')->middleware('haspermission:addBooking');
        Route::post('/edit', [Controllers\BookingController::class, 'getBookingById'])->name('getBookingById')->middleware('haspermission:editBooking');
        Route::post('/get_timeslots_by_zipcode', [Controllers\BookingController::class, 'getTimeSlotByZipCode'])->name('getTimeSlotByZipCode');
        Route::post('/delete', [Controllers\BookingController::class, 'destroy'])->name('bookingDelete')->middleware('haspermission:deleteBooking');
        Route::get('/confirmed', [Controllers\BookingController::class, 'confirmedBookings'])->name('confirmedList')->middleware('haspermission:confirmedBooking');
        Route::post('/getUserAgainstZip', [Controllers\BookingController::class, 'getUsersByZipCode'])->name('getUserAgainstZip');
        Route::post('/bookingAssign', [Controllers\BookingController::class, 'bookingAssign'])->name('bookingAssign')->middleware('haspermission:bookingAssign');
        Route::post('/update_booking_status', [Controllers\BookingController::class, 'updateBookingStatus'])->name('updateBookingStatus')->middleware('haspermission:updateStatus');
    });
    Route::prefix('booking-task')->group(function () {
        Route::get('/', [Controllers\MeasurementBookingController::class, 'index'])->name('bookingTaskList')->middleware('haspermission:bookingtaskList');
        Route::post('/list', [Controllers\MeasurementBookingController::class, 'getList'])->name('getAssignBookingList')->middleware('haspermission:bookingtaskList');
        Route::post('/update-assign-booking-status', [Controllers\MeasurementBookingController::class, 'updateAssignBookingStatus'])->name('updateAssignBookingStatus')->middleware('haspermission:updateBookingAssignStatus');
        Route::get('/detail/{id}/{assignid}', [Controllers\MeasurementBookingController::class, 'bookingDetail'])->name('bookingDetail')->middleware('haspermission:bookingDetail');

    });
    Route::prefix('booking-order')->group(function () {
        Route::get('/create_order/{id}', [Controllers\MeasurementOrderController::class, 'index'])->name('measurementOrderDetail')->middleware('haspermission:bookingorderDetail');
        Route::post('get-products', [Controllers\MeasurementOrderController::class, 'getProductByCategory'])->name('getProductByCategory')->middleware('haspermission:orderCategory');
        Route::post('get-prices', [Controllers\MeasurementOrderController::class, 'getProductMinPrices'])->name('getProductMinPrices')->middleware('haspermission:productMinPrices');
        Route::post('/product_quote/{id?}', [Controllers\MeasurementOrderController::class, 'getProductQuote'])->name('store.produt.quote');
        Route::post('store', [Controllers\MeasurementOrderController::class, 'storeMeasurementOrder'])->name('storeMeasurementOrder')->middleware('haspermission:storeOrder');
        Route::post('edit', [Controllers\MeasurementOrderController::class, 'getOrderItemById'])->name('getOrderItemById')->middleware('haspermission:orderItem');


    });
    Route::prefix('user-time-slot')->group(function () {
        Route::get('/detail/{id}', [Controllers\UserTimeSlotController::class, 'index'])->name('zipListUsers')->middleware('haspermission:zipUserList');
        Route::post('/submit', [Controllers\UserTimeSlotController::class, 'store'])->name('slotSave')->middleware('haspermission:storeUserSlot');

    });

    Route::prefix('orders')->group(function () {
        Route::get('/', [Controllers\OrderController::class, 'index'])->name('orderList')->middleware('haspermission:pendingOrder');
        Route::get('confirmed-order-list', [Controllers\OrderController::class, 'confirmedOrderList'])->name('confirmedOrderList')->middleware('haspermission:confirmedOrder');
        Route::post('/list', [Controllers\OrderController::class, 'getList'])->name('getList')->middleware('haspermission:orderList');
        Route::get('/detail/{id}', [Controllers\OrderController::class, 'detail'])->name('orderListDetail')->middleware('haspermission:orderDetail');
        Route::post('/assignedInventory', [Controllers\OrderController::class, 'getAssignedProductInventory'])->name('getAssignedProductInventory')->middleware('haspermission:AssignedProductInventory');
        Route::post('/itemsvariant', [Controllers\OrderController::class, 'getItemVariant'])->name('getItemVariant')->middleware('haspermission:itemsVariant');
        Route::post('/itemsqty', [Controllers\ItemController::class, 'getItemsQantity'])->name('getDeptItemsQty')->middleware('haspermission:itemsQuantity');
        Route::post('/salelog', [Controllers\OrderController::class, 'saleLog'])->name('orderSaleLogSubmit');
        Route::post('/salelogproceed', [Controllers\OrderController::class, 'saveProceedOrderInventory'])->name('proceedSaleInventory')->middleware('haspermission:SaleInventory');
        Route::post('/productInventoryList', [Controllers\OrderController::class, 'productInventoryList'])->name('getProductInventoryList')->middleware('haspermission:ProductInventoryList');
        Route::post('/logItemDelete', [Controllers\OrderController::class, 'logItemDelete'])->name('logItemDelete')->middleware('haspermission:logItemDelete');
        Route::post('/logItemUpdate', [Controllers\OrderController::class, 'logItemUpdate'])->name('logItemUpdate')->middleware('haspermission:logItemUpdate');

    });

    Route::prefix('tasks')->group(function () {
        Route::get('/', [Controllers\TaskController::class, 'index'])->name('tasksList')->middleware('haspermission:departmentTaskList');
        Route::post('/list', [Controllers\TaskController::class, 'getList'])->name('getTasksList')->middleware('haspermission:departmentTaskList');
        Route::post('/taskInfo', [Controllers\TaskController::class, 'getTaskInfo'])->name('getTaskInfo')->middleware('haspermission:departmentTaskInfo');
        Route::post('/taskAssign', [Controllers\TaskController::class, 'assignuserTask'])->name('assignuserTask')->middleware('haspermission:departmentAssignTask');
        Route::get('completed-task', [Controllers\TaskController::class, 'completedTasksList'])->name('completedTasksList')->middleware('haspermission:departmentCompletedTask');
        Route::post('completed-task-list', [Controllers\TaskController::class, 'getCompletedTasksList'])->name('getCompletedTasksList')->middleware('haspermission:departmentCompletedTask');
    });
    Route::prefix('assembled-order')->group(function () {
        Route::get('/', [Controllers\AssembledOrderController::class, 'index'])->name('assembledOrderList');
        Route::post('/list', [Controllers\AssembledOrderController::class, 'getList'])->name('getAssembledOrderList');
        Route::get('/detail/{id}', [Controllers\AssembledOrderController::class, 'detail'])->name('getAssembledOrderDetail');
        Route::get('/assignlist', [Controllers\AssignAssembleUserController::class, 'index'])->name('assembledOrderAssigned');
        Route::get('/getassignlist', [Controllers\AssignAssembleUserController::class, 'getList'])->name('getAssignAssembledList');


    });
    Route::get('worker-task-screen', [Controllers\WorkerTaskController::class, 'getWorkerTasksByDepartment'])->name('getWorkerTasksByDepartment')->middleware('haspermission:workerTask');
    Route::post('worker-tasks-list', [Controllers\WorkerTaskController::class, 'getWorkerTasksList'])->name('getWorkerTasksList')->middleware('haspermission:workerTask');
    Route::post('update-worker-tasks-status', [Controllers\WorkerTaskController::class, 'updateWorkertaskStatus'])->name('updateWorkertaskStatus')->middleware('haspermission:updateWorkerTask');

});
Auth::routes();
