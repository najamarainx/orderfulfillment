<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class OrderFulfillmentPermission extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'orderfulfillment_permissions';

    public static function assignPermission($roleId)
    {
        $permissions = DB::table('orderfulfillment_permissions')->pluck('id')->toArray();
        if (count($permissions) > 0) {
            foreach ($permissions as $permissionId) {
                DB::table('orderfulfillment_role_has_permissions')->insert(
                    ['permission_id' => $permissionId, 'role_id' => $roleId]
                );
            }
        }
    }

    public function checkPermissionAssigned($id)
    {
        $check = true;
        $checkRolesPermissionCount = DB::table('orderfulfillment_role_has_permissions')->where('permission_id', $id)->count();
        if ($checkRolesPermissionCount) {
            $check = false;
        }
        return $check;
    }
    public function checkRoleAssigned($id)
    {
        $check = true;
        $checkRolesnCount = DB::table('orderfulfillment_role_has_permissions')->where('role_id', $id)->count();
        if ($checkRolesnCount) {
            $check = false;
        }
        return $check;
    }
}
