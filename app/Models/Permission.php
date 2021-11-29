<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Permission extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static function assignPermission($roleId) {
        $permissions = DB::table('permissions')->pluck('id')->toArray();
        if (count($permissions) > 0) {
            foreach ($permissions as $permissionId) {
                DB::table('role_has_permissions')->insert(
                    ['permission_id' => $permissionId, 'role_id' => $roleId]
                );
            }
        }
    }

    public function checkPermissionAssigned($id) {
        $check = true;
        $checkRolesPermissionCount = DB::table('role_has_permissions')->where('permission_id',$id)->count();
        if($checkRolesPermissionCount) {
            $check = false;
        }
        return $check;
    }
}
