<?php

namespace App\Http\Controllers;

use App\Models\OrderFulfillmentItem;
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
use MongoDB\Driver\Session;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{

    public function index()
    {
        $type = Auth::user()->type;
        $usersTypeArray = ['assembler','packaging','installation'];
        $zipcode = Zip::whereNULL('orderfulfillment_zip_codes.deleted_at')->select('orderfulfillment_zip_codes.*');
        if($type == 'installation'){
            $zipcode->join('orderfulfillment_user_zip_codes_mappings as u_zip_map','orderfulfillment_zip_codes.id','u_zip_map.zip_id');
            // $zipcode->join('orderfulfillment_users as user','u_zip_map.user_id','user.id');
            $zipcode->where('u_zip_map.user_id',Auth::user()->id);
        }
        $zipcodes  = $zipcode->get();
        $departments = getDepartment(-1, true);
        $query = OrderFulfillmentRole::whereNULL('orderfulfillment_roles.deleted_at')->select('orderfulfillment_roles.*');
        if ($type == 'production_manager') {
            $query->whereIn('orderfulfillment_roles.name', ['Team Lead', 'Worker','Screen']);
        }else if($type == 'team_lead'){
            $query->whereIn('orderfulfillment_roles.name', ['Worker']);
        }else if(in_array($type,$usersTypeArray)){
            // $query->join('orderfulfillment_users as o_u','orderfulfillment_roles.added_by','o_u.id');
            $query->where('orderfulfillment_roles.added_by',Auth::user()->id);
        }
        $roles = $query->get();
        $dt = [

            'zipcodes' => $zipcodes,
            'roles' => $roles,
            'departments' => $departments
        ];
        $department_id =  session()->get('department_id');
        $usersTypeArray = ['assembler','packaging','installation'];
        $user = OrderFulfillmentUser::select('orderfulfillment_users.*', 'orderfulfillment_roles.name as role_name')->whereNULL('orderfulfillment_users.deleted_at')->whereNotIn('orderfulfillment_users.type', ['developer', 'super_admin'])->where('orderfulfillment_users.id','!=',auth()->user()->id);
        $user->join('orderfulfillment_roles', 'orderfulfillment_users.role_id', '=', 'orderfulfillment_roles.id');
        if ($type == 'production_manager') {
            $user->join('orderfulfillment_user_departments as o_user_dpt', 'orderfulfillment_users.id', 'o_user_dpt.user_id');
        }else if($type == 'team_lead'){
            $user->join('orderfulfillment_user_departments as o_user_dpt', 'orderfulfillment_users.id', 'o_user_dpt.user_id');
            $user->where('o_user_dpt.department_id',$department_id);
        }else if(in_array($type,$usersTypeArray)){
            $user->where('type',$type);
        }
        $dt['totalItems'] = $user->count();
        return view('users.list', $dt);
    }
    public function getList(Request $request)
    {
        $usersTypeArray = ['assembler','packaging','installation'];
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
        }else if(in_array($type,$usersTypeArray)){
            $user->where('type',$type);
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
            $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-hover-primary btn-icon edit mr-2" data-id="' . $userObj->id . '" title="Edit details">
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
        </span></a>';
            }
            if(hasPermission('deleteUser')){
            $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-hover-primary delete" data-id="' . $userObj->id . '" title="Delete">
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
                "user_type" => str_replace('_',' ',ucfirst($userObj->type)),
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
        $usersTypeArray = ['assembler','packaging','installation'];
        $validate = true;
        $id = $request->id;
        $useremail = $request->email;
        // $password = $this->generatePassword();
        $phoneNumber = $request->phone;
        $user = new OrderFulfillmentUser();
        // Get the value from the form
        $validateInput = $request->all();
        if(!in_array(Auth::user()->type,$usersTypeArray)){
            $rules = [
                'email' => 'required',
                'phone' => 'required',
                'name' => 'required',
                'user_role' => 'required',
                'user_type' => 'required',
            ];
        }else{
            $rules = [
                'email' => 'required',
                'phone' => 'required',
                'name' => 'required',
                'user_role' => 'required',
            ];
        }
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

            if(!in_array(Auth::user()->type,$usersTypeArray)){
                $user->type = $request->user_type;
                if(!empty($request->is_head)){
                    $user->is_head = $request->is_head;
                }else{
                    $user->is_head = '0';
                }
            }else{
                $user->type = Auth::user()->type;
            }
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
                    if($type =='team_lead'){
                        $userDepartment->department_id =Session()->get('department_id');
                    }else{
                        $userDepartment->department_id = $request->user_department;
                    }

                    $userDepartment->added_by = Auth::user()->id;
                    $userDepartment->save();
                }
                if ($request->user_type == 'installation' || $request->user_type == 'measurement' || Auth::user()->type == 'installation') {
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

    public function UserProfile(){
        return view('users.profile');
    }

    public function updateUserProfile(Request $request){
        $validate = true;
        $validateInput = $request->all();

        $rules = [

            'name' => 'required',
            'email' => 'required|max:100',
            'phone' => 'required|max:100',

        ];
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

            $id=Auth::user()->id;
            $userObj = OrderFulfillmentUser::find($id);
            if ($request->hasFile('user_image')) {
                $userAttach = $request->file('user_image');
                $userAttach = uniqid() . '.' . $request->user_image->getClientOriginalExtension();
                $request->user_image->move(public_path('user/profile/'), $userAttach);
                $userObj->photo = $userAttach;
                if(\File::exists(public_path('user/profile/'.$request->old_image))){
                    \File::delete(public_path('user/profile/'.$request->old_image));
                }
            }
            $userObj->name=$request->name;
            //$userObj->u_name=$request->u_name;
            $userObj->phone_number=$request->phone;
            $userObj->address=$request->address;
            $userObj->country=$request->country;
            $userObj->city=$request->city;
            $userObj->state=$request->state;
            $userObj->zip_code=$request->zip_code;

            if(!$userObj->save())
            {
                $return = [
                    'status' => 'error',
                    'message' => 'User information is not saved ',
                ];
            }
            else
            {
                $return = [
                    'status' => 'success',
                    'message' => 'User information is save successfully',
                ];
            }
        }
        return response()->json($return);
    }

    public function updateUserPassword(Request $request){

        $validate = true;
        $validateInput = $request->all();

        $rules = [

            'currentpassword' => 'required',
            'newpassword' => 'min:8|required_with:password_confirmation|same:cpassword',
            'cpassword' => 'min:8'
        ];
       $message =  [];
        $validator = Validator::make($validateInput, $rules, $message,[
            'newpassword' => 'New Password',
            'cpassword' => 'Confirm Password',
        ]);
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
            $id = Auth::user()->id;
            $userObj = OrderFulfillmentUser::find($id);
            $user = OrderFulfillmentUser::where('id', $id)->first();
            $newpassword = Hash::make($request->newpassword);
            $validatePassword = Hash::check($request->currentpassword, $user->password);

            if ($validatePassword > 0) {
                $userObj->password=$newpassword;
                if(!$userObj->save())
                {
                    $return = [
                        'status' => 'error',
                        'message' => 'Your information is not saved.',
                    ];
                }
                else
                {
                    $return = [
                        'status' => 'success',
                        'message' => 'Your information is save successfully.',
                    ];
                }

            } else {
                $return = [
                    'status' => 'error',
                    'message' => 'Your current Password is Not Match.',
                ];

            }
        }
        return response()->json($return);
    }
}
