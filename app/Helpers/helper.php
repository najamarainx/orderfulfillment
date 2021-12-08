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
    $query = DB::table('orderfulfillment_categories');
     $query->whereNull('deleted_at');
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
function getDepartmentItems($deptID)
{
    return $query = DB::table('orderfulfillment_items')->where('department_id',$deptID)->get();
}
function getVariants()
{
    return $query = DB::table('orderfulfillment_variants')->whereNull('deleted_at')->get();
}

function getUsersByZip($zipID)
{
    return $query = DB::table('orderfulfillment_user_zip_codes_mappings')->select('orderfulfillment_users.name','orderfulfillment_users.id')->join('orderfulfillment_users','orderfulfillment_users.id','=','orderfulfillment_user_zip_codes_mappings.user_id')->whereNULL('orderfulfillment_user_zip_codes_mappings.deleted_at')->where('orderfulfillment_user_zip_codes_mappings.zip_id',$zipID)->get();
}
function getUserTimeSlots($zipID)
{
    return $query = DB::table('orderfulfillment_user_time_slot_assigns')->select('orderfulfillment_user_time_slot_assigns.*')->whereNULL('orderfulfillment_user_time_slot_assigns.deleted_at')->where('orderfulfillment_user_time_slot_assigns.zip_code_id',$zipID)->get();
}

function getZipCode($zipId="")
{
     $query = DB::table('orderfulfillment_zip_codes')->whereNull('deleted_at');

     if(!empty($zipId)){
         $query->where('id',$zipId);
     }
     $result = $query->get();
     return $result;
}

function getTimeSlotByZipId($userId){
    $timeSlotId = DB::table('orderfulfillment_user_time_slot_assigns')->whereIn('user_id',$userId)->whereNull('deleted_at')->pluck('time_slot_id')->toArray();
    $timeSlotDetail = OrderFulfillmentTimeSlot::whereIn('id',$timeSlotId)->get();
    return $timeSlotDetail;
}
function getBookingStatus(){
    $statusArray = ['not called', 'confirmed', 'rescheduled', 'not respond', 'cancelled'];
    return $statusArray;
}




