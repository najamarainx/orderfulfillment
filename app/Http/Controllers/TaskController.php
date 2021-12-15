<?php

namespace App\Http\Controllers;

use App\Models\OrderFulfillmentAssignedTask;
use Illuminate\Http\Request;
use App\Models\OrderFulfillmentSaleLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class TaskController extends Controller
{
    public function index()
    {
        $assignTaskArray = assignTaskStatus();
        $departments = getDepartment(-1, true);
        $dt = ['AssignTaskArray' => $assignTaskArray, 'departments' => $departments];
        return view('tasks.list',$dt);
    }

    public function getList(Request $request)
    {
        if (Auth::user()->type == 'team_lead') {
            $getUsers = getUsersDepartments(true, session()->get('department_id'), 'worker');
        } else {
            $getUsers = getUsersDepartments(true, '-1', 'worker');
        }
        $records = [];
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $sortColumnIndex = $request->order[0]['column']; // Column index
        $sortColumnName = $request->columns[$sortColumnIndex]['data']; // Column name
        $sortColumnSortOrder = $request->order[0]['dir']; // asc or desc
        $columns = $request->columns;
        $sql = OrderFulfillmentSaleLog::select('orderfulfillment_sale_logs.*','orderfulfillment_items.name as item_name','orderfulfillment_variants.name as variant_name','orderfulfillment_departments.name as department_name','orderfulfillment_users.name as assigned_user')->where('orderfulfillment_sale_logs.is_verified','1');
        $sql->leftJoin('orderfulfillment_assigned_tasks','orderfulfillment_assigned_tasks.task_id','orderfulfillment_sale_logs.id');
        $sql->leftJoin('orderfulfillment_users','orderfulfillment_users.id','orderfulfillment_assigned_tasks.user_id');
        $sql->join('orders','orders.id','orderfulfillment_sale_logs.order_id');
        $sql->join('orderfulfillment_items','orderfulfillment_items.id','orderfulfillment_sale_logs.item_id');
        $sql->join('orderfulfillment_variants','orderfulfillment_variants.id','orderfulfillment_sale_logs.variant_id');
        $sql->join('orderfulfillment_departments','orderfulfillment_departments.id','orderfulfillment_sale_logs.department_id');
        $sql->where('orders.paid_percentage','>=','40');
        $sql->whereNULL('orderfulfillment_items.deleted_at');
        $sql->whereNULL('orderfulfillment_variants.deleted_at');
        $sql->whereNULL('orderfulfillment_assigned_tasks.deleted_at');
        $sql->whereNULL('orders.deleted_at');
        if (Auth::user()->type == 'team_lead') {

            $sql->where('orderfulfillment_sale_logs.department_id', '=', session()->get('department_id'));
        }

        /*foreach ($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if ($search != "") {
                if ($col == 'id') {
                    $colp='orders.id';
                    $sql->where($colp, $search);

                }
                if ($col == 'name') {
                    $colp='orders.store_id';
                    $sql->where($colp, $search);

                }

            }
        }*/

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
            if($orderObj->status=='pending'){
                        $action .= '<a href="javascript:;" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3 assign_task" data-id="' . $orderObj->id . '">
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



            $data[] = [
                "id" => $orderObj->id,
                "department" =>$orderObj->department_name,
                "item" =>$orderObj->item_name,
                "variant"=>$orderObj->variant_name,
                "qty"=>$orderObj->qty,
                "status"=>'<span class="badge badge-success badge-pill" style="cursor:pointer">' . $orderObj->status . '</span>',
                "date"=>Carbon::create($orderObj->updated_at)->format(config('app.date_time_format', 'M j, Y, g:i a')),
                "assigned"=>ucfirst($orderObj->assigned_user),
                "action"=>$action
            ];
        }

        $records["data"] = $data;
        $records["draw"] = $draw;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        echo json_encode($records);
    }

    public function getTaskInfo(Request $request)
    {

        if(Auth::user()->type=='team_lead'){$getUsers=getUsersDepartments(true,session()->get('department_id'),'worker');
        }else{ $getUsers=getUsersDepartments(true,'-1','worker');}
        $selected_user=OrderFulfillmentAssignedTask::select('user_id')->whereNull('deleted_at')->where('task_id',$request->id)->first();
        $return = [
            'status' => 'success',
            'data' => $getUsers,
            'id' => $request->id,
            'user_id' =>isset($selected_user->user_id) && !empty($selected_user->user_id) ? $selected_user->user_id : '' ,
        ];
        if (empty($getUsers)) {
            $return = [
                'status' => 'error',
                'message' => 'Data not found for user'
            ];
        }
        return response()->json($return);
    }



    public function assignuserTask(Request $request)
    {
        $validate = true;
        $validateInput = $request->all();
        $rules = [
            'task_id' => 'required|max:150',
            'user_id' => 'required',


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
            return response()->json($return);
        }
        if ($validate) {
            DB::beginTransaction();
            try{
                    $taskInfo=OrderFulfillmentAssignedTask::where('task_id',$request->task_id)->WhereNULL('deleted_at')->first();
                    if(!empty($taskInfo))
                    {
                        OrderFulfillmentAssignedTask::whereNULL('deleted_at')
                            ->where('task_id',$request->task_id)
                            ->update(['deleted_at' =>Carbon::now()->format("Y-m-d H:i:s")]);
                    }

                    $assignTask = new  OrderFulfillmentAssignedTask();
                    $assignTask->task_id=$request->task_id;
                    $assignTask->user_id=$request->user_id;
                    $assignTask->added_by=Auth::user()->id;
                    $assignTask->created_at=Carbon::now()->format("Y-m-d H:i:s");
                    $query=$assignTask->save();
                    $return = [
                        'status' => 'error',
                        'message' => 'task not assigned against this user',
                    ];
                    if ($query) {
                        $return = [
                            'status' => 'success',
                            'message' => 'task assigned this user successfully',

                        ];
                    }
                DB::commit();

            }
            catch(\Exception $e){
                $return = [
                    'status' => 'error',
                    'message' => 'task not assigned against this user',
                ];
            }
        }
        return response()->json($return);
    }


    public function completedTasksList()
    {
        $assignTaskArray = assignTaskStatus();
        $departments = getDepartment(-1, true);
        $dt = ['AssignTaskArray' => $assignTaskArray, 'departments' => $departments];
        return view('tasks.completed_list', $dt);
    }

    public function getCompletedTasksList(Request $request)
    {
        $type =  Auth::user()->type;
        $records = [];
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $sortColumnIndex = $request->order[0]['column']; // Column index
        $sortColumnName = $request->columns[$sortColumnIndex]['data']; // Column name
        $sortColumnName = 'orderfulfillment_sale_logs.id'; // Column name
        $sortColumnSortOrder = $request->order[0]['dir']; // asc or desc
        $columns = $request->columns;
        $department_id =  session()->get('department_id');
        $orderSaleLogDetail = OrderFulfillmentSaleLog::with(['orderDetails' => function ($q) {
            $q->where('payment', 'verified');
            $q->where('paid_percentage', '>=', '40');
            $q->whereNull('deleted_at');
        }, 'departmentDetails', 'itemDetails' => function ($item) {
            $item->whereNull('deleted_at');
        }, 'variantDetails' => function ($variant) {
            $variant->whereNull('deleted_at');
        }, 'assignedTask' => function ($task) {
            $task->whereNull('deleted_at');
            $task->with(['assignedUser' => function ($user) {
                $user->whereNull('deleted_at');
            }]);
        }])->whereNull('deleted_at')->where('status', 'completed');
        if ($type == 'team_lead') {
            $orderSaleLogDetail->where('department_id', $department_id);
        }


        foreach ($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if ($search != "") {
                if ($col == 'date') {
                    $col = "orderfulfillment_sale_logs.updated_at";
                    $orderSaleLogDetail->Where($col, 'like', '%' . $search . '%');

                    // $orderSaleLogDetail->where($col, $search);
                }
                if ($col == 'department_id') {
                    $col = "orderfulfillment_sale_logs.department_id";
                    $orderSaleLogDetail->where($col, $search);
                }
                if ($col == 'status') {
                    $col = "orderfulfillment_sale_logs.status";
                    $orderSaleLogDetail->where($col, $search);
                }
            }
        }
        if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            $orderSaleLogDetail->orderBy($sortColumnName, $sortColumnSortOrder);
        } else {
            $orderSaleLogDetail->orderBy("orderfulfillment_sale_logs.id", "desc");
        }
        $iTotalRecords = $orderSaleLogDetail->count();
        $orderSaleLogDetail->skip($start);
        $orderSaleLogDetail->take($length);
        $orderSaleLogDetailData = $orderSaleLogDetail->get();
        $data = [];
        foreach ($orderSaleLogDetailData as $orderObj) {
            $data[] = [
                "id" => $orderObj->id,
                "department_id" => $orderObj->departmentDetails->name,
                "item_id" => $orderObj->itemDetails->name,
                "variant_id" =>  $orderObj->variantDetails->name,
                "qty" => $orderObj->qty,
                "date" =>  !empty($orderObj->updated_at) ? Carbon::parse($orderObj->updated_at)->format('Y-m-d H:i:s') : '',
                "status" => '<span class="badge badge-success badge-pill booking_assign_status" style="cursor:pointer" >' . $orderObj->status . '</span>',
                "assign_to" => '<span class="badge badge-success badge-pill booking_assign_status" style="cursor:pointer>' .  !empty($orderObj->assignedTask->assignedUser) ? $orderObj->assignedTask->assignedUser->name  : '' . '</span>',
            ];
        }
        $records["data"] = $data;
        $records["draw"] = $draw;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        echo json_encode($records);
    }
}
