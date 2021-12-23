<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderFulfillmentAssignAssembleUser;
use App\Models\OrderFulfillmentDepartment;
use App\Models\OrderFulfillmentStockOrderItem;
use App\Models\OrderFulfillmentUser;
use App\Models\OrderFulfillmentVariant;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AssembledOrderController extends Controller
{
    //

    public function index()
    {
        $stores = $query = DB::table('stores')->whereNull('deleted_at')->get();
        $dt = ['stores' => $stores];
        return view('assembled_orders.list', $dt);
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
        $sql->where('orders.status', 'assembling');
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
                if ($col == 'name') {
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
            $action .= '<a href="' . url('assembled-order/assign_user') . '/' . $orderObj->id . '" class="btn btn-icon btn-light btn-hover-primary btn-sm assigned_order" data-id="' . $orderObj->id . '">
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

            $action .= '<a href="' . url('assembled-order/detail') . '/' . $orderObj->id . '" target="_blank"  class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3 ">
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
                "name" => $orderObj->store_name,
                "created_at" => Carbon::create($orderObj->created_at)->format(config('app.date_time_format', 'M j, Y, g:i a')),
                "status" => $orderObj->status,
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

    public function getAssemblerUsers(Request $request)
    {
        $assemblerUsers = OrderFulfillmentUser::where('is_head', '0')->get();
        if (!($assemblerUsers->isEmpty())) {
            $data['assemblerUsers'] = $assemblerUsers;
        } else {
            $response = ['status' => 'error'];
        }
        return view('assembled_orders.assigned_task', $data);
    }
    public function getAssemblerUsersList(Request $request)
    {
        $records = [];
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $sortColumnIndex = $request->order[0]['column']; // Column index
        $sortColumnName = $request->columns[$sortColumnIndex]['data']; // Column name
        $sortColumnSortOrder = $request->order[0]['dir']; // asc or desc
        $columns = $request->columns;
        $sql = OrderFulfillmentUser::where('is_head', '1')->select('orderfulfillment_users.*', 'o_as_u.user_id as o_as_u_id','o_as_u.id as assigned_id','o_as_u.status');
        $sql->leftJoin('orderfulffillment_assign_assemble_users as o_as_u',function($q){
                 $q->on('orderfulfillment_users.id', 'o_as_u.user_id');
                 $q->whereNULL('o_as_u.deleted_at');
        });
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
                "status"=> '<span class="badge badge-success badge-pill worker_assign_status" style="cursor:pointer" >' .  $userObj->status  . '</span>',
                "action" => $action
            ];
        }
        $records["data"] = $data;
        $records["draw"] = $draw;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        echo json_encode($records);
    }

    public function assignedAssmblerTask(Request $request)
    {
        if (!empty($request->user_id) && !empty($request->order_id)) {
            $assemblerUsers = OrderFulfillmentAssignAssembleUser::where(['user_id' => $request->user_id, 'order_id' => $request->order_id])->whereNull('deleted_at')->first();
            if (empty($assemblerUsers)) {
                $assemblerUsers = new OrderFulfillmentAssignAssembleUser();
                $assemblerUsers->order_id = $request->order_id;
                $assemblerUsers->user_id = $request->user_id;
                $assemblerUsers->added_by = Auth::user()->id;
                $query = $assemblerUsers->save();
                if ($query) {
                    $response = ['status' => 'success', 'message' => 'Saved Successfully'];
                }
            } else {
                $response = ['status' => 'success', 'message' => 'This user is already Assigned'];
            }


            return response()->json($response);
        }
    }

    public function deleteAssemblerUser(Request $request)
    {
        $assembler_id = $request->id;
        $assemblerStatus=OrderFulfillmentAssignAssembleUser::where('id',$request->id)->first();
        if($assemblerStatus->status == 'pending'){
            OrderFulfillmentAssignAssembleUser::where(['id' => $assembler_id])->update(['deleted_at' => Carbon::now()->format('Y-m-d')]);
            $response = ['status' => 'success', 'message' => 'Deleted Successfully'];
        }else{
            $response = ['status' => 'error', 'message' => 'You cannot deleted this record!'];
        }
        return response()->json($response);
    }
}
