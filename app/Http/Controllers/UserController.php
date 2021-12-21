<?php

namespace App\Http\Controllers;

use App\Models\OrderFulfillmentUserZipCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OrderFulfillmentUser;
use App\Models\OrderFulfillmentRole;
use App\Models\OrderFulfillmentUserDepartment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Zip;
use Carbon\Carbon;
use Auth;

class UserController extends Controller
{

    public function index()
    {
        $type = Auth::user()->type;
        $zipcodes = Zip::whereNULL('deleted_at')->get();
        $departments = getDepartment(-1, true);
        $query = OrderFulfillmentRole::whereNULL('deleted_at');
        if ($type == 'production_manager') {
            $query->whereIn('name', ['Team Lead', 'Worker','Screen']);
        }else if($type == 'team_lead'){
            $query->whereIn('name', ['Worker']);
        }
        $roles = $query->get();
        $dt = [

            'zipcodes' => $zipcodes,
            'roles' => $roles,
            'departments' => $departments
        ];

        return view('users.list', $dt);
    }
    public function getList(Request $request)
    {
        $type = auth()->user()->type;
        $records = [];
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $sortColumnIndex = $request->order[0]['column']; // Column index
        $sortColumnName = $request->columns[$sortColumnIndex]['data']; // Column name
        $sortColumnSortOrder = $request->order[0]['dir']; // asc or desc
        $columns = $request->columns;
        $department_id =  session()->get('department_id');
        $user = OrderFulfillmentUser::select('orderfulfillment_users.*', 'orderfulfillment_roles.name as role_name')->whereNULL('orderfulfillment_users.deleted_at')->whereNotIn('orderfulfillment_users.type', ['developer', 'super_admin'])->where('orderfulfillment_users.id','!=',auth()->user()->id);
        $user->join('orderfulfillment_roles', 'orderfulfillment_users.role_id', '=', 'orderfulfillment_roles.id');
        if ($type == 'production_manager') {
            $user->join('orderfulfillment_user_departments as o_user_dpt', 'orderfulfillment_users.id', 'o_user_dpt.user_id');
        }else if($type == 'team_lead'){
            $user->join('orderfulfillment_user_departments as o_user_dpt', 'orderfulfillment_users.id', 'o_user_dpt.user_id');
            $user->where('o_user_dpt.department_id',$department_id);
        }
        foreach ($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if ($search != "") {

                if ($col == 'name') {
                    $user->where('orderfulfillment_users.' . $col, 'like', '%' . $search . '%');
                }
                if ($col == 'email') {
                    $user->where('orderfulfillment_users.' . $col,  'like', '%' . $search . '%');
                }
                if ($col == 'phone_number') {
                    $user->where('orderfulfillment_users.' . $col, 'like', '%' . $search . '%');
                }
                if ($col == 'role') {
                    $colp = 'id';
                    $user->where('orderfulfillment_roles.' . $colp, $search);
                }
                if ($col == 'user_type') {
                    $colp = 'type';
                    $user->where('orderfulfillment_users.' . $colp, 'like', '%' . $search . '%');
                }
            }
        }
        if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            if ($sortColumnName == 'Sr') {
                $user->orderBy("orderfulfillment_users.id", "desc");
            }
            if ($sortColumnName == 'phone_number') {
                $user->orderBy("orderfulfillment_users.phone_number", "desc");
            }
            if ($sortColumnName == 'role') {
                $user->orderBy("orderfulfillment_users.role_id", "desc");
            }
            if ($sortColumnName == 'user_type') {
                $user->orderBy("orderfulfillment_users.type", "desc");
            }
        } else {
            $user->orderBy("orderfulfillment_users.name", "desc");
        }
        //$user->groupBy('orderfulfillment_users.id');
        $iTotalRecords = $user->count();
        $user->skip($start);
        $user->take($length);
        $userData = $user->get();
        $data = [];
        $i = 1;
        foreach ($userData as $userObj) {
            $action = "";
            if(hasPermission('editUser')){
            $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon edit" data-id="' . $userObj->id . '" title="Edit details">
                            <i class="la la-edit"></i>
                        </a>';
            }
            if(hasPermission('deleteUser')){
            $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon delete" data-id="' . $userObj->id . '" title="Delete">
                            <i class="la la-trash"></i>
                        </a>';
            }




            $name="";
            $name.='<p class="m-0 font-weight-bolder">'.$userObj->name.'</p>';
            if($userObj->type=='worker')
            {
                $name.='<small>Security Code : <span class="m-0 text-dark font-weight-bolder">'.$userObj->security_code.'</span></small>';
            }

            $data[] = [
                "Sr" => $i,
                "name" =>$name,
                "email" => $userObj->email,
                "phone_number" => $userObj->phone_number,
                "role" => $userObj->role_name,
                "user_type" => $userObj->type,
                "created_at" => Carbon::create($userObj->created_at)->format(config('app.date_time_format', 'M j, Y, g:i a')),
                "action" => $action
            ];
            $i++;
        }
        $records["data"] = $data;
        $records["draw"] = $draw;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        echo json_encode($records);
    }

    public function store(Request $request)
    {

        $type = auth()->user()->type;
        $validate = true;
        $id = $request->id;
        $useremail = $request->email;
        $password = $this->generatePassword();
        $phoneNumber = $request->phone;
        $user = new OrderFulfillmentUser();
        // Get the value from the form
        $validateInput = $request->all();
        $rules = [
            'email' => 'required',
            'phone' => 'required',
            'name' => 'required',
            'user_role' => 'required',
            'user_type' => 'required',


        ];
        if ($id > 0) {
            $user = OrderFulfillmentUser::findOrFail($id);
            if ($useremail != $user->email) {
                $rules['email'] = 'required|unique:orderfulfillment_users,email';
            }
            if ($phoneNumber != $user->phone_number) {
                $rules['phone_number'] = 'required|unique:orderfulfillment_users,phone_number';
            }
        } else {

            $rules['email'] = 'required|unique:orderfulfillment_users,email';
            $rules['phone'] = 'required|unique:orderfulfillment_users,phone_number';
        }
        $validator = Validator::make($validateInput, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $allMsg = [];
            foreach ($errors->all() as $message) {
                $allMsg[] = $message;
            }
            $return['status'] = 'error';
            $return['message'] = collect($allMsg)->implode('<br />');
            $validate = false;
        }
        if ($validate) {
            $user->email = $useremail;
            $user->phone_number = $phoneNumber;
            $user->name = $request->name;
            $user->added_by = Auth::user()->id;
            if ($id == '') {
                // $password = $this->generatePassword();
                $password ='developer123';
                $user->password = Hash::make($password);
            }
            $user->role_id = $request->user_role;
            $user->type = $request->user_type;
            if ($id == "") {
                $user->email_verified_at = Carbon::now()->format("Y-m-d H:i:s");
            }

            $query = $user->save();

            $return = [
                'status' => 'error',
                'message' => 'Data is not save successfully',
            ];
            if ($query) {
                $userID = $user->id;
                if ($type == 'production_manager' or $type =='team_lead') {
                    $userDepartment = OrderFulfillmentUserDepartment::where('user_id', $userID)->first();
                    if (empty($userDepartment)) {
                        $userDepartment  = new OrderFulfillmentUserDepartment;
                    }
                    $userDepartment->user_id = $userID;
                    $userDepartment->department_id = $request->user_department;
                    $userDepartment->added_by = Auth::user()->id;
                    $userDepartment->save();
                }
                if ($request->user_type == 'installation' || $request->user_type == 'measurement') {
                    DB::table('orderfulfillment_user_zip_codes_mappings')->where('user_id', $userID)->delete();

                    $zipIDS = $request->input('zip_id');
                    $zipmapping = array();
                    foreach ($zipIDS as $zipID) {
                        $zipmapping[] = array(
                            'user_id' => $userID,
                            'zip_id' => $zipID,
                            'created_by' => Auth::user()->id,
                            'created_at' => Carbon::now()->format("Y-m-d H:i:s")
                        );
                    }
                    DB::table('orderfulfillment_user_zip_codes_mappings')->insert($zipmapping);
                }

                if ($request->user_type == 'worker' && $id=='') {
                    $code=$this->generatePassword();
                    $securityCode=$userID.''.$code;
                    $affected = DB::table('orderfulfillment_users')
                        ->where('id', $userID)
                        ->update(['security_code' =>$securityCode]);



                }


                $return = [
                    'status' => 'success',
                    'message' => 'User is save successfully',
                ];
            }
        }
        return response()->json($return);
    }

    public function generatePassword()
    {
        $comb = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $shfl = str_shuffle($comb);
        $pwd = substr($shfl, 0, 8);
        return $pwd;
    }

    public function getUserById(Request $request)
    {
        $zipIDs = array();
        $id = $request->id;
        $query = OrderFulfillmentUser::where('orderfulfillment_users.id', $id);
        if(Auth::user()->type == 'production_manager'){
              $query->join('orderfulfillment_user_departments as o_user_dpt' , 'orderfulfillment_users.id' , 'o_user_dpt.user_id');
              $query->select('orderfulfillment_users.*','o_user_dpt.department_id');
        }else{
            $query->select('orderfulfillment_users.*');
        }
        $user = $query->first();
        if ($user->type == 'installation' or $user->type == 'measurement') {
            $zipcodes = OrderFulfillmentUserZipCode::where('user_id', $user->id)->get();
            if (!empty($zipcodes)) {
                foreach ($zipcodes as $zipcode) {
                    $zipIDs[] = $zipcode->zip_id;
                }

                $zipIDs = implode(',', $zipIDs);
            }
        }
        $return = [
            'status' => 'success',
            'data' => $user,
            'zipIDs' => $zipIDs,

        ];
        if (empty($user)) {
            $return = [
                'status' => 'error',
                'message' => 'Data not found for edit',

            ];
        }
        return response()->json($return);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $res = OrderFulfillmentUser::find($id);
        if ($res) {
            $res->delete();
            if(Auth::user()->type == 'production_manager'){
                OrderFulfillmentUserDepartment::where('user_id',$id)->update(['deleted_at'=>date('Y-m-d H:i:s')]);
            }
            return response()->json(['status' => 'success', 'message' => 'User is deleted successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'User not deleted ']);
        }
    }
}
