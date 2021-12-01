<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\OrderFulfillmentPermission;

class HasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        if (Auth::guest()) {
            if($request->ajax()){
                $return = [
                    'status' => 'error',
                    'message' => 'User is not logged in.'
                ];
                return response()->json($return);
            } else {
                abort(401, 'User is not logged in.');
            }
        }
        $permissionObj = OrderFulfillmentPermission::where('name',$permission)->first();
        if(!empty($permissionObj)) {
            $userRoleId = Auth::user()->role_id;
            $roleHasPermission = DB::table('orderfulfillment_role_has_permissions')->where('role_id',$userRoleId)->where('permission_id',$permissionObj->id)->first();
            if(empty($roleHasPermission)) {
                if($request->ajax()){
                    $return = [
                        'status' => 'error',
                        'message' => 'User does not have the right permissions',
                    ];
                    return response()->json($return);
                } else {
                    abort(403, 'User does not have the right permissions');
                }
            }
        } else {
            if($request->ajax()) {
                $return = [
                    'status' => 'error',
                    'message' => 'Please contact to admin'
                ];
                return response()->json($return);
            } else {
                abort(403, 'permission not found.');
            }
        }
        return $next($request);
    }
}
