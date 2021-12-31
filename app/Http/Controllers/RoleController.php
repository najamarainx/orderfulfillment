<?php

namespace App\Http\Controllers;

use App\Models\OrderFulfillmentPermission;
use Illuminate\Http\Request;
use App\Models\OrderFulfillmentRole;
use App\Models\OrderFulfillmentUser;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    //
    public function index()
    {
        return view('roles.list');
    }

    public function getList(Request $request)
    {
        $usersTypeArray = ['assembler','packaging','installation'];
        $records = [];
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $sortColumnIndex = $request->order[0]['column']; // Column index
        $sortColumnName = $request->columns[$sortColumnIndex]['data']; // Column name
        $sortColumnSortOrder = $request->order[0]['dir']; // asc or desc
        $sortColumnName = 'orderfulfillment_roles.id';
        $columns = $request->columns;

        $userType = auth()->user()->type;
        $role = OrderFulfillmentRole::select('orderfulfillment_roles.*');
        if(in_array($userType , $usersTypeArray)){
            $role->where('added_by',Auth::user()->id);
            // $role->join('orderfulfillment_users as o_u','orderfulfillment_roles.added_by','o_u.id');
        }
        // if($userType != 'super_admin') {
        //     $role->whereIn('id', $userRoleIds);
        // }
        foreach ($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if ($search != "") {
                if ($col == 'id') {
                    $role->where($col, $search);
                }
                if ($col == 'name') {
                    $role->where($col, 'like', '%' . $search . '%');
                }
                if ($col == 'created_at') {
                    $dateArr = explode('|', $search);
                    $dateFrom = Carbon::create($dateArr[0] . " 00:00:00")->format('Y-m-d H:i:s');
                    $dateTo = Carbon::create($dateArr[1] . " 23:59:59")->format('Y-m-d H:i:s');
                    $role->whereBetween('created_at', [$dateFrom, $dateTo]);
                }
            }
        }
        if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            $role->orderBy($sortColumnName, $sortColumnSortOrder);
        } else {
            $role->orderBy("orderfulfillment_roles.id", "desc");
        }
        $iTotalRecords = $role->count();
        $role->skip($start);
        $role->take($length);
        $roleData = $role->get();
        $data = [];
        $userId = auth()->user()->id;
        $checkuser=array('Super Admin','Developer','Measurement','Production Manager','Team Lead','Worker','Screen','assembler','packaging');
        foreach ($roleData as $roleObj) {
            $action = "";
            if (hasPermission('assignPermissionRole')) {
            $action .= '<a href="javascript:;" class="btn btn-icon btn-light btn-hover-primary btn-sm assign_permission" data-id="' . $roleObj->id . '">
            <span class="svg-icon svg-icon-md svg-icon-primary">
                <!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                        <rect fill="#000000" opacity="0.3" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000) " x="7.5" y="7.5" width="2" height="9" rx="1"></rect>
                        <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997) "></path>
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>
        </a>';
            }
            if (hasPermission('editRole') && (!in_array($roleObj->name,$checkuser))) {
            $action .= '<a href="javascript:;" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3 edit" data-id="' . $roleObj->id . '">
                <span class="svg-icon svg-icon-md svg-icon-primary">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Write.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"></rect>
                            <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)"></path>
                            <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
            </a>';

            }

            if (hasPermission('deleteRole') && (!in_array($roleObj->name,$checkuser))) {
            $action .= '<a href="javascript:;" class="btn btn-icon btn-light btn-hover-primary btn-sm delete" data-id="' . $roleObj->id . '" title="Delete">
                <span class="svg-icon svg-icon-md svg-icon-primary">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Trash.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"></rect>
                            <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
                            <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
            </a>';
            }
            $data[] = [
                "id" => $roleObj->id,
                "name" => $roleObj->name,
                "created_at" => Carbon::create($roleObj->created_at)->format(config('app.date_time_format', 'M j, Y, g:i a')),
                "action" => $action
            ];
        }
        $records["data"] = $data;
        $records["draw"] = $draw;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        echo json_encode($records);
    }

    public function store(Request $request)
    {
        $id = $request->id;
        $role = new OrderFulfillmentRole();
        if ($id > 0) {
            $role = OrderFulfillmentRole::findOrFail($id);
        }
        $role->name = $request->name;
        $role->added_by = Auth::user()->id;
        $role->save();
        $return = [
            'status' => 'success',
            'message' => 'Role save successfully',
        ];
        return response()->json($return);
    }

    public function getRoleById(Request $request)
    {
        $id = $request->id;
        $role = OrderFulfillmentRole::where('id', $id)->first();
        $return = [
            'status' => 'success',
            'data' => $role
        ];
        if (empty($role)) {
            $return = [
                'status' => 'error',
                'message' => 'Data not found for edit'
            ];
        }
        return response()->json($return);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $checkRoleAssign = new OrderFulfillmentUser();
        $res = $checkRoleAssign->checkRoleAssigned($id);
        if ($res) {
            DB::table('orderfulfillment_roles')
                ->where('id', $id)
                ->update(['deleted_at' => Carbon::now()->format('Y-m-d H:i:s')]);
            return response()->json(['status' => 'success', 'message' => 'Role is deleted successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Role not deleted beacuse it is assigned']);
        }
    }

    public function rolePermissions(Request $request)
    {
        $roleId = $request->role_id;
        $permission = DB::table('orderfulfillment_permissions as permissions','orderfulfillment_role_has_permissions.role_id');
        $permission->select('permissions.*', 'categories.name as category_name');
        $permission->Join('orderfulfillment_categories as categories', 'categories.id', '=', 'permissions.category_id');
        if(Auth::user()->type == 'assembler' || Auth::user()->type == 'installation' || Auth::user()->type == 'packaging' || Auth::user()->type == 'accountant' ){
            $permission->Join('orderfulfillment_role_has_permissions', 'permissions.id', '=', 'orderfulfillment_role_has_permissions.permission_id')->where('role_id', $roleId);
        }
        $permissions = $permission->get();
        $assignPermissionTORole = DB::table('orderfulfillment_role_has_permissions')->where('role_id', $roleId)->pluck('permission_id')->toArray();
        $html = '<input type="hidden" name="role_id" value="' . $roleId . '" >';
        $perArr = [];
        foreach ($permissions as $permissionObj) {
            $perArr[$permissionObj->category_name][] = [
                'id' => $permissionObj->id,
                'name' => $permissionObj->name,
            ];
        }

        $userType = auth()->user()->type;
        if (count($perArr)) {
            foreach ($perArr as $categoryName => $permission) {
                $printPermissionHeading = true;
                foreach ($permission as $p) {
                    $showPermission = true;
                    /*if($userType != 'super_admin' or $userType != 'developer') {
                        if(!hasPermission($p['name'])) {
                            $showPermission = false;
                        }
                    }*/
                    if($showPermission) {
                    if ($printPermissionHeading) {
                        $html .= '<div class="col-sm-12" style="margin:5px 0px;">
                                        <div class="caption">
                                            <i class="icon-user font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase"><b>' . $categoryName . '</b></span>
                                        </div>
                                    </div>';
                        $printPermissionHeading = false;
                    }
                    $checked = '';
                    if (in_array($p['id'], $assignPermissionTORole)) {
                        $checked = 'checked="checked"';
                    }
                    $string = $p['name'];
                    $pattern = '/(.*?[a-z]{1})([A-Z]{1}.*?)/';
                    $replace = '${1} ${2}';
                    $html .= '<div class="col-sm-3">
                                <label class="checkbox-inline">
                                    <label class="checkbox checkbox-square checkbox-danger">
                                        <input type="checkbox" ' . $checked . ' name="permission[]" value="' . $p['id'] . '" ><span></span>
                                        ' . ucwords(preg_replace($pattern, $replace, $string)) . '
                                    </label>
                                </label>
                            </div>';
                    }
                }
            }
        }
        $return = [
            'status' => 'success',
            'data' => $html
        ];
        return response()->json($return);
    }


    public function assignPermissions(Request $request)
    {
        $roleId = $request->role_id;
        $permissions = $request->permission;
        DB::table('orderfulfillment_role_has_permissions')->where('role_id', $roleId)->delete();
        $permissionArr = [];
        foreach ($permissions as $permission) {
            $permissionArr[] = [
                'permission_id' => $permission,
                'role_id' => $roleId
            ];
        }
        if (!empty($permissionArr)) {
            DB::table('orderfulfillment_role_has_permissions')->insert($permissionArr);
        }
        return response()->json(['status' => 'success', 'message' => 'Role permissions updated successfully']);
    }
}
