<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\OrderFulfillmentPermission;
use App\Models\OrderFulfillmentTimeSlot;
use App\Models\OrderFulfillmentUserZipCode;


function hasPermission($name)
{
    $permissionObj = OrderFulfillmentPermission::where('name', $name)->first();
    if (!empty($permissionObj)) {
        $userRoleId = Auth::user()->role_id;
        $roleHasPermission = DB::table('orderfulfillment_role_has_permissions')->where('role_id', $userRoleId)->where('permission_id', $permissionObj->id)->first();
        if (empty($roleHasPermission)) {
            return false;
        }
    } else {
        return false;
    }
    return true;
}
function getDepartment($departmentId = "", $departmentObjs = false)
{
    $query = DB::table('orderfulfillment_departments');
    $query->whereNull('deleted_at');
    $result = [];
    if ($departmentObjs) {
        $result = $query->get();
    } else {
        $result = $query->pluck('id')->toArray();
    }
    if ($departmentId > 0) {
        $query->where('id', $departmentId);
        $result = $query->first();
    }
    return $result;
}

function getCategory($type = "", $categoryId = "", $categoryObjs = false)
{
    $query = DB::table('categories');
    $query->whereNull('deleted_at');
    $query->where('type', 'product');
    if ($type != "") {
        $query->where('type', $type);
    }
    $result = [];
    if ($categoryObjs) {
        $result = $query->get();
    } else {
        $result = $query->pluck('id')->toArray();
    }
    if ($categoryId > 0) {
        $query->where('id', $categoryId);
        $result = $query->first();
    }
    return $result;
}
function getStoreCategory($categoryObjs = false, $categoryId = "", $type = "product", $storeID = '')
{

    $role = array('super_admin', 'customer');
    // $storeIds = 1;
    // print_r($storeIds);exit;
    $query = DB::table('categories')->whereNull('deleted_at');
    if (!empty($storeIds) && ((auth()->check()) && (!in_array(auth()->user()->type, $role)))) {
        $contractIds = DB::table('stores')->whereIn('id', $storeIds)->pluck('contract_id')->toArray();
        $productIds = DB::table('product_contract_mappings')->whereIn('contract_id', $contractIds)->pluck('product_id')->toArray();
        $categoyIds =  DB::table('products')->whereIn('id', $productIds)->pluck('category_id')->toArray();
        $query->withCount(['products' => function ($query) use ($productIds) {
            $query->whereIn('id', $productIds);
            // $query->join('store_product_price_mappings')
        }]);
        $query->whereIn('id', $categoyIds);
    } elseif ($storeID) {
        //echo "i am here";exit;
        $contractIds = DB::table('stores')->where('id', $storeID)->pluck('contract_id')->toArray();
        //$productIds = ProductContractMapping::whereNULL('deleted_at')->whereIn('contract_id', $contractIds)->pluck('product_id')->toArray();
        $productIds = DB::table('store_product_pricing_mappings')->whereNULL('deleted_at')->where('store_id', $storeID)->pluck('product_id')->toArray();
        $categoyIds = DB::table('products')->whereNULL('deleted_at')->whereIn('id', $productIds)->pluck('category_id')->toArray();

        $query->whereIn('id', $categoyIds);
    }


    $result = [];
    if ($categoryObjs) {
        $result = $query->get();
    } else {
        $result = $query->pluck('id')->toArray();
    }
    if ($categoryId > 0) {
        $query->where('id', $categoryId);
        $result = $query->first();
    }
    if ($type != "") {
        $query->where('type', $type);
        if ($categoryObjs) {
            $result = $query->get();
        } else {
            $result = $query->pluck('id')->toArray();
        }
    }

    return $result;
}
function getDepartmentItems($deptID)
{
    return $query = DB::table('orderfulfillment_items')->where('department_id', $deptID)->get();
}
function getVariants()
{
    return $query = DB::table('orderfulfillment_variants')->whereNull('deleted_at')->get();
}

function getUsersByZip($zipID)
{
    return $query = DB::table('orderfulfillment_user_zip_codes_mappings')->select('orderfulfillment_users.name', 'orderfulfillment_users.id')->join('orderfulfillment_users', 'orderfulfillment_users.id', '=', 'orderfulfillment_user_zip_codes_mappings.user_id')->whereNULL('orderfulfillment_user_zip_codes_mappings.deleted_at')->where('orderfulfillment_users.type', '=', 'measurement')->where('orderfulfillment_user_zip_codes_mappings.zip_id', $zipID)->get();
}
/*function getUserTimeSlots($zipID)
{
    return $query = DB::table('orderfulfillment_user_time_slot_assigns')
        ->select('orderfulfillment_user_time_slot_assigns.*')
        ->whereNULL('orderfulfillment_user_time_slot_assigns.deleted_at')
        ->where('orderfulfillment_user_time_slot_assigns.zip_code_id',$zipID)
        ->get();
}*/

function getZipCode($zipId = "")
{
    $query = DB::table('orderfulfillment_zip_codes')->whereNull('deleted_at');

    if (!empty($zipId)) {
        $query->where('id', $zipId);
    }
    $result = $query->get();
    return $result;
}
function getBookingInfo($bookingID)
{
    return $query = DB::table('orderfulfillment_bookings')->select('orderfulfillment_bookings.*')->whereNULL('orderfulfillment_bookings.deleted_at')->where('orderfulfillment_bookings.id', $bookingID)->first();
}

function getTimeSlotByZipId($userId)
{
    $timeSlotId = DB::table('orderfulfillment_user_time_slot_assigns')->whereIn('user_id', $userId)->whereNull('deleted_at')->pluck('time_slot_id')->toArray();
    $timeSlotDetail = OrderFulfillmentTimeSlot::whereIn('id', $timeSlotId)->get();
    return $timeSlotDetail;
}
function getBookingStatus()
{
    $statusArray = ['not called', 'confirmed', 'rescheduled', 'not respond', 'cancelled'];
    return $statusArray;
}

function getUsersTimeSlot($userObjs = false, $zipID, $slotID, $userID = -1)
{
    $query = DB::table('orderfulfillment_user_time_slot_assigns');
    $query->join('orderfulfillment_users', 'orderfulfillment_users.id', '=', 'orderfulfillment_user_time_slot_assigns.user_id');
    $query->whereNull('orderfulfillment_user_time_slot_assigns.deleted_at');
    $query->where('orderfulfillment_user_time_slot_assigns.zip_code_id', $zipID);
    $query->where('orderfulfillment_user_time_slot_assigns.time_slot_id', $slotID);
    $query->where('orderfulfillment_users.type', '=', 'measurement');
    $query->whereNull('orderfulfillment_users.deleted_at');
    $result = [];
    if ($userObjs) {
        $result = $query->get();
    } else {
        $result = $query->pluck('orderfulfillment_users.id')->toArray();
    }
    if ($userID > 0) {
        $query->where('orderfulfillment_users.id', $userID);
        $result = $query->first();
    }
    return $result;
}
function getBookedUsers($userObjs = false, $UserIDS, $slotID, $date, $bookingID)
{
    $query = DB::table('orderfulfillment_booking_assigns');
    $query->whereNull('orderfulfillment_booking_assigns.deleted_at');
    $query->where('orderfulfillment_booking_assigns.booking_id', '!=', $bookingID);
    $query->whereIn('orderfulfillment_booking_assigns.user_id', $UserIDS);
    $query->where('orderfulfillment_booking_assigns.slot_id', $slotID);
    $query->whereDate('orderfulfillment_booking_assigns.date', $date);


    $result = [];
    if ($userObjs) {
        $result = $query->get();
    } else {
        $result = $query->pluck('orderfulfillment_booking_assigns.user_id')->toArray();
    }

    return $result;
}
function assignBookingUser($bookingID)
{
    $query = DB::table('orderfulfillment_booking_assigns');
    $query->whereNull('orderfulfillment_booking_assigns.deleted_at');
    $query->where('orderfulfillment_booking_assigns.booking_id', '=', $bookingID);
    $result = $query->first();
    return $result;
}

function getProductByCategory($categoryId = -1, $storeID)
{
    if ($storeID > 0) {
        $contractIds = DB::table('stores')->where('id', $storeID)->pluck('contract_id')->toArray();
        $productIds = DB::table('product_contract_mappings')->whereIn('contract_id', $contractIds)->pluck('product_id')->toArray();
        $query = DB::table('products')->whereNull('products.deleted_at')->whereIn('products.id', $productIds)->selectRaw("products.*,store_product_pricing_mappings.sale_price");
        $query->join('store_product_pricing_mappings', 'store_product_pricing_mappings.product_id', 'products.id');
        $query->whereNull('store_product_pricing_mappings.deleted_at');
        $query->where('store_product_pricing_mappings.store_id', $storeID);
    }
    if ($categoryId > 0 && $categoryId != 'undefined') {
        $query->where('products.category_id', $categoryId);
    }
    $productData = $query->get();
    return $productData;
}

function getContractProducts($contractID)
{
    return $productIDs = DB::table('product_contract_mappings')->where('contract_id',$contractID)->where('deleted_at', '=', NULL)->pluck('product_id')->toArray();
}
function getProductByID($productID=-1,$contractID=-1,$categoryID=-1,$storeID=-1)
{
    $singleProduct = DB::table('products')->whereNull('products.deleted_at')->selectRaw("products.*,store_product_pricing_mappings.sale_price,product_contract_mappings.discount");
    $singleProduct->join('store_product_pricing_mappings','store_product_pricing_mappings.product_id','products.id');
    $singleProduct->join('product_contract_mappings', 'product_contract_mappings.product_id', '=', 'store_product_pricing_mappings.product_id');

    $singleProduct->where('store_product_pricing_mappings.product_id',$productID);
    $singleProduct->whereNull('store_product_pricing_mappings.deleted_at');
    $singleProduct->whereNull('product_contract_mappings.deleted_at');
    $singleProduct->where('product_contract_mappings.contract_id',$contractID);
    if($storeID > 0){
        $singleProduct->where('store_product_pricing_mappings.store_id',$storeID);
    }
    $result=$singleProduct->first();

    return $result;



}

function calculateProductQuote($productID,$width,$height)
{
    $products = DB::table('products')->selectRaw("band_price_mappings.length,band_price_mappings.width,band_price_mappings.price");
    $products->join('band_price_mappings','band_price_mappings.band_id','products.band_id');
    $products->where('products.id',$productID)->where('products.deleted_at', '=', NULL);
    $result=$products->where('band_price_mappings.width','>=',$width);
    $result=$products->where('band_price_mappings.length','>=',$height)->first();
    return $result;
}

function getProductAdditionalCharges($productID,$storeID=-1)
{

    $charges= DB::table('store_product_pricing_mappings')->where('product_id',$productID)->where('store_id',$storeID)->where('deleted_at',NULL)->first();
    $totalcharges=0;
    $margin=isset($charges->margin) && $charges->margin > 0 ? $charges->margin : 0;
    $vat=isset($charges->vat) && $charges->vat > 0 ? $charges->vat : 0;
    $totalcharges+= ($margin + $vat) - $charges->discount;

    return $totalcharges;


}
function overallProductPrice($bandPrice,$additionalCharges=-1,$contractDiscount=-1)
{
    if($contractDiscount > 0){
        $buyingprice=($bandPrice * ($contractDiscount/100));
        $buyingprice=$bandPrice - $buyingprice;
    }
    else{
        $buyingprice=$bandPrice;
    }
    if($additionalCharges > 0){
        // echo $additionalCharges;exit;
        $totalPrice=($buyingprice + ($buyingprice * ($additionalCharges/100)));

    }
    else{
        $totalPrice=$buyingprice;
    }
        return number_format($totalPrice,2);
}
