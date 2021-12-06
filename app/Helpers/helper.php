<?php


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\OrderFulfillmentPermission;


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


