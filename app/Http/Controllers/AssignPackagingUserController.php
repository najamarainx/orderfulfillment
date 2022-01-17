<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\OrderFulfillmentPackagingUser;
use App\Models\Order;
use App\Models\OrderFulfillmentAssignAssembleUser;
use App\Models\OrderFulfillmentAssignPackaging;
use App\Models\OrderFulfillmentVariant;
use App\Models\OrderFulfillmentDepartment;
use App\Models\OrderFulfillmentUser;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Validator;
class AssignPackagingUserController extends Controller
{
    public function index(){
        $stores =  DB::table('stores')->whereNull('deleted_at')->get();
        $sql = OrderFulfillmentPackagingUser::select('orderfulfillment_packings.*','orderfulfillment_users.name as assigned_to','ab.name as assigned_from');
        $sql->join('orders','orders.id','orderfulfillment_packings.order_id');
        $sql->join('orderfulfillment_users','orderfulfillment_packings.user_id','orderfulfillment_users.id');
        $sql->join('orderfulfillment_users as ab','orderfulfillment_packings.added_by','ab.id');
        $sql->where('orderfulfillment_users.type','packaging');
        $sql->whereNULL('orders.deleted_at');
        $sql->where('orders.status','packing');
        $sql->whereNULL('orderfulfillment_packings.deleted_at');
        $sql->whereNULL('orderfulfillment_users.deleted_at');
        $dt = ['stores' => $stores,'totalPackagingOrder'=>$sql->count()];
        return view('packaging_orders.list',$dt);
    }

    public function getList(Request $request)
    {

        $records = [];
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $sortColumnIndex = $request->order[0]['column']; // Column index
        $sortColumnName = $request->columns[$sortColumnIndex]['data']; // Column name
        $sortColumnSortOrder = $request->order[0]['dir']; // asc or desc
        $columns = $request->columns;
        $sql = Order::select('orders.*', 'stores.name as store_name')->where('orders.payment', 'verified');
        $sql->join('stores', 'orders.store_id', 'stores.id');
        $sql->where('orders.paid_percentage', '>=', '40');
        $sql->where('orders.status','packing');
        $sql->whereNULL('stores.deleted_at');
        $sql->whereNULL('orders.deleted_at');
        foreach ($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if ($search != "") {
                if ($col == 'id') {
                    $colp = 'orders.id';
                    $sql->where($colp, $search);
                }
                if ($col == 'store_id') {
                    $colp = 'orders.store_id';
                    $sql->where($colp, $search);
                }
            }
        }

        if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            $sql->orderBy($sortColumnName, $sortColumnSortOrder);
        } else {
            $sql->orderBy("id", "desc");
        }
        $iTotalRecords = $sql->count();
        $sql->skip($start);
        $sql->take($length);
        $orderData = $sql->get();
        $data = [];
        foreach ($orderData as $orderObj) {
            $action = "";
                $action .= '<a href="' . url('packaging-order/assign_user') . '/' . $orderObj->id . '" class="btn btn-icon btn-light btn-hover-primary btn-sm assigned_order" data-id="' . $orderObj->id . '">
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
                $action .= '<a href="' . url('packaging-order/detail') . '/' . $orderObj->id . '" target="_blank"  class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3 ">
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
           
            $data[] = [
                "id" => $orderObj->id,
                "store_id" => $orderObj->store_name,
                "name" => $orderObj->name,
                "phone" => $orderObj->phone,
                "created_at" => Carbon::create($orderObj->created_at)->format(config('app.date_time_format', 'M j, Y, g:i a')),
                "status" => '<span class="label label-lg label-light-warning label-inline">' .$orderObj->status.'</span>',
                "action" => $action
            ];
        }


        $records["data"] = $data;
        $records["draw"] = $draw;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        echo json_encode($records);
    }

    public function detail($id)
    {
        $departments = OrderFulfillmentDepartment::get();
        $variants = OrderFulfillmentVariant::get();
        $orderItems = Order::with(['orderdetail' => function ($query) {
            $query->with('orderProducts');
        }])->where('id', $id)->first();
        $dt = [
            'orderItems' => $orderItems,
            'departments' => $departments,
            'variants' => $variants,

        ];
        return view('orders.assign_detail', $dt);
    }


    public function getAssignList(Request $request)
    {

        $records = [];
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $sortColumnIndex = $request->order[0]['column']; // Column index
        $sortColumnName = $request->columns[$sortColumnIndex]['data']; // Column name
        $sortColumnSortOrder = $request->order[0]['dir']; // asc or desc
        $columns = $request->columns;
        $sql = OrderFulfillmentPackagingUser::select('orderfulfillment_packings.*','orderfulfillment_users.name as assigned_to','ab.name as assigned_from');
        $sql->join('orders','orders.id','orderfulfillment_packings.order_id');
        $sql->join('orderfulfillment_users','orderfulfillment_packings.user_id','orderfulfillment_users.id');
        $sql->join('orderfulfillment_users as ab','orderfulfillment_packings.added_by','ab.id');
        $sql->where('orderfulfillment_users.type','packaging');
        $sql->whereNULL('orders.deleted_at');
        $sql->where('orders.status','packing');
        $sql->whereNULL('orderfulfillment_packings.deleted_at');
        $sql->whereNULL('orderfulfillment_users.deleted_at');
        if(Auth::user()->is_head==1){
            $sql->where('orderfulfillment_packings.user_id',Auth::user()->id);
        }

        foreach ($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if ($search != "") {
                if ($col == 'order_id') {
                    $sql->where('orderfulfillment_packings.order_id', $search);

                    // $sql->where($col, $search);
                }
                if ($col == 'status') {
                    $col = "orderfulfillment_packings.status";
                    $sql->where($col, $search);
                }
            }
        }

        if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            $sql->orderBy($sortColumnName, $sortColumnSortOrder);
        } else {
            $sql->orderBy("orderfulfillment_packings.id", "desc");
        }
        $iTotalRecords = $sql->count();
        $sql->skip($start);
        $sql->take($length);
        $orderData = $sql->get();
        $data = [];
        foreach ($orderData as $orderObj) {
            $action = "";
            $action .= '<a href="' . url('packaging-order/detail') . '/' . $orderObj->order_id . '" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3 preview">
            <i class="la la-eye"></i>
        </a>';
        $assign_status_class = null;
        if($orderObj->status == 'pending'){
            $assign_status_class = 'label-light-danger';
         }
        if($orderObj->status == 'in progress'){
            $assign_status_class = 'label-light-warning';
         }
        if($orderObj->status == 'completed'){
            $assign_status_class = 'label-light-success';
         }
            if($orderObj->status=='completed' && Auth::user()->is_head==1){
                $status='<span class="label label-lg label-light-success label-inline "  style="cursor:pointer">' . $orderObj->status . '</span>';
            }else{
                $status='<span class="label label-lg '.$assign_status_class.' label-inline assemble_update" data-id="'.$orderObj->id.'" style="cursor:pointer">' . $orderObj->status . '</span>';
            }

            $data[] = [
                "id" => $orderObj->id,
                "order_id" =>$orderObj->order_id,
                "assigned_from"=>ucfirst($orderObj->assigned_from),
                "assigned_to"=>ucfirst($orderObj->assigned_to),
                "date"=>Carbon::create($orderObj->created_at)->format(config('app.date_time_format', 'M j, Y, g:i a')),
                "status"=>$status,
                "action"=>$action,
            ];
        }

        $records["data"] = $data;
        $records["draw"] = $draw;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        echo json_encode($records);
    }

    public function getUserPackagedStatus(Request $request)
    {
        $assemblerStatus=OrderFulfillmentPackagingUser::where('id',$request->id)->first();
        $return = [
            'status' => 'success',
            'assembler_status' => $assemblerStatus,
        ];
        return response()->json($return);
    }

    public function updatePackagedStatus(Request $request)
    {
        $validate = true;
        $validateInput = $request->all();
        $rules = [
            'assembling_id'=>'required',
            'order_id'=>'required',
            'assembling_status' => 'required|max:150',

        ];
        $messages = [
            'assembling_id.required' => 'something wrong !',
            'order_id.required' => 'something wrong !',
            'assembling_status.required' => 'packaging status field is required',

        ];
        $validator = Validator::make($validateInput, $rules, $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $allMsg = [];
            foreach ($errors->all() as $message) {
                $allMsg[] = $message;
            }
            $return['status'] = 'error';
            $return['message'] = collect($allMsg)->implode('<br />');
            $validate = false;
            return response()->json($return);
        }
        if($validate) {
            $query = OrderFulfillmentPackagingUser::where('id',$request->assembling_id)
                ->update([
                    'status' =>$request->assembling_status,
                    'updated_at' =>Carbon::Now()->format('Y-m-d H:i:s'),
                ]);


            $return = [
                'status' => 'error',
                'message' => 'Status not updated please try again!'
            ];
            if ($query) {
                $return = [
                    'status' => 'success',
                    'message' => 'Status  updated successfully!'
                ];
            }
        }
        return response()->json($return);
    }

    public function getPackagingUsers(Request $request)
    {
        return view('packaging_orders.assigned_task');
    }
    public function getPackagingUsersList(Request $request)
    {
        $records = [];
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $sortColumnIndex = $request->order[0]['column']; // Column index
        $sortColumnName = $request->columns[$sortColumnIndex]['data']; // Column name
        $sortColumnSortOrder = $request->order[0]['dir']; // asc or desc
        $columns = $request->columns;
        $sql = OrderFulfillmentUser::where('orderfulfillment_users.is_head', '1')->select('orderfulfillment_users.*', 'o_as_u.user_id as o_as_u_id','o_as_u.id as assigned_id','o_as_u.status','from_user.name as from_name');
        $sql->leftJoin('orderfulfillment_packings as o_as_u',function($q){
                 $q->on('orderfulfillment_users.id', 'o_as_u.user_id');
                 $q->whereNULL('o_as_u.deleted_at');
        });
        $sql->leftJoin('orderfulfillment_users as from_user','o_as_u.added_by', 'from_user.id');
        $sql->where('orderfulfillment_users.type',Auth::user()->type);
        $sql->whereNULL('orderfulfillment_users.deleted_at');
        foreach ($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if ($search != "") {
                if ($col == 'name') {
                    $colp = 'orderfulfillment_users.name';
                    $sql->where($colp, $search);
                }
            }
        }

        if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            $sql->orderBy($sortColumnName, $sortColumnSortOrder);
        } else {
            $sql->orderBy("id", "desc");
        }
        $iTotalRecords = $sql->count();
        $sql->skip($start);
        $sql->take($length);
        $userData = $sql->get();
        // print_r($userData);exit;
        $data = [];
        foreach ($userData as $userObj) {
            $assign_status_class = null;
            if($userObj->status  == 'pending'){
                $assign_status_class = 'label-light-danger';
             }
            if($userObj->status  == 'in progress'){
                $assign_status_class = 'label-light-warning';
             }
            if($userObj->status  == 'completed'){
                $assign_status_class = 'label-light-success';
             }
            $action = "";
            $action .= '<div class="text-right">';
            if (empty($userObj->o_as_u_id)) {
                $action .= ' <button class="btn btn-primary btn-sm mr-2 save_assemled_user"  data-user-id="' . $userObj->id . '">
            Save</button>';
            }
            if (!empty($userObj->o_as_u_id)) {
                $action .= '<button class="btn btn-primary btn-sm delete_assemled_user" data-assmbler-id = "' . $userObj->assigned_id . '" data-user-id="' . $userObj->id . '">x</button>';
            }
            $action .= '</div>';
            $data[] = [
                "id" => $userObj->id,
                "name" => $userObj->name,
                "added_by" =>$userObj->from_name,
                "status"=> '<span class="label label-lg '.$assign_status_class.' label-inline worker_assign_status" style="cursor:pointer" >' .  $userObj->status  . '</span>',
                "action" => $action
            ];
        }
        $records["data"] = $data;
        $records["draw"] = $draw;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        echo json_encode($records);
    }
    public function deletePackagingUser(Request $request)
    {
        $assembler_id = $request->id;
        $assemblerStatus=OrderFulfillmentPackagingUser::where('id',$request->id)->first();
        if($assemblerStatus->status == 'pending'){
            OrderFulfillmentPackagingUser::where(['id' => $assembler_id])->update(['deleted_at' => Carbon::now()->format('Y-m-d')]);
            $response = ['status' => 'success', 'message' => 'Deleted Successfully'];
        }else{
            $response = ['status' => 'error', 'message' => 'You cannot deleted this record!'];
        }
        return response()->json($response);
    }
    public function assignList()
    {
        return view('packaging_orders.assign_list');
    }
    public function assignedPackagingTask(Request $request)
    {
        if (!empty($request->user_id) && !empty($request->order_id)) {
            $packagingUsers = OrderFulfillmentAssignPackaging::where(['user_id' => $request->user_id, 'order_id' => $request->order_id])->whereNull('deleted_at')->first();
            if (empty($packagingUsers)) {
                $packagingUsers = new OrderFulfillmentAssignPackaging();
                $packagingUsers->order_id = $request->order_id;
                $packagingUsers->user_id = $request->user_id;
                $packagingUsers->added_by = Auth::user()->id;
                $query = $packagingUsers->save();
                if ($query) {
                    $response = ['status' => 'success', 'message' => 'Saved Successfully'];
                }
            } else {
                $response = ['status' => 'success', 'message' => 'This user is already Assigned'];
            }


            return response()->json($response);
        }
    }
}
