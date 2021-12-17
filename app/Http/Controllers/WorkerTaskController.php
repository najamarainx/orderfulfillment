<?php

namespace App\Http\Controllers;

use App\Models\OrderFulfillmentAssignedTask;
use Illuminate\Http\Request;
use App\Models\OrderFulfillmentSaleLog;
use App\Models\OrderFulfillmentStockOrder;
use App\Models\OrderFulfillmentUser;
use Auth;
use Illuminate\Support\Carbon;
class WorkerTaskController extends Controller
{
    public function getWorkerTasksByDepartment(){
        $workers  =   getUsersDepartments(true,session()->get('department_id'),'screen');
        // print_r($workers);exit;
        $data['workers'] = $workers;
        return view('workers.task-list',$data);

    }
    public function getWorkerTasksList(Request $request)
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
        }])->whereNull('deleted_at')->whereIn('status', ['in progress','completed']);
            $orderSaleLogDetail->where('department_id', $department_id);




        foreach ($columns as $field) {
            $col = $field['data'];

            $search = $field['search']['value'];
            if ($search != "") {
                if ($col == 'date') {
                    $col = "orderfulfillment_sale_logs.updated_at";
                    $orderSaleLogDetail->Where($col, 'like', '%' . $search . '%');

                    // $orderSaleLogDetail->where($col, $search);
                }
                if ($col == 'assign_to') {
                    $col = "orderfulfillment_assigned_tasks.user_id";
                    $orderSaleLogDetail->where($col, $search);
                }
                // if ($col == 'status') {
                //     $col = "orderfulfillment_sale_logs.status";
                //     $orderSaleLogDetail->where($col, $search);
                // }
            }
        }
        if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            $orderSaleLogDetail->orderBy($sortColumnName, $sortColumnSortOrder);
        } else {
            $orderSaleLogDetail->orderBy("orderfulfillment_sale_logs.id", "asc");
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
                "status" => '<span class="badge badge-success badge-pill worker_assign_status"  data-user-id="'.$orderObj->assignedTask->assignedUser->id.'" data-id="'.$orderObj->id.'" style="cursor:pointer" >' . $orderObj->status . '</span>',
                "assign_to" => '<span class="badge badge-success badge-pill"  style="cursor:pointer>' .  !empty($orderObj->assignedTask->assignedUser) ? $orderObj->assignedTask->assignedUser->name  : '' . '</span>',
            ];
        }
        $records["data"] = $data;
        $records["draw"] = $draw;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        echo json_encode($records);
    }

    public function updateWorkertaskStatus(Request $request){
         if(!empty($request->security_code)){
           $userDetail = OrderFulfillmentUser::where(['id'=>$request->worker_id,'security_code'=>$request->security_code])->whereNull('deleted_at')->first();
             if(!empty($userDetail)){
                 $query   = OrderFulfillmentSaleLog::where('id',$request->worker_task_log_id)->whereNull('deleted_at')->update(['status'=>$request->worker_status]);
                 if($query){
                    $return = ['status' => 'success', 'message' => 'Your status updated successfully!'];
                 }
                }else{
                $return = ['status' => 'error', 'message' => 'Sorry your security code is incorrect!'];
            }
            return response()->json($return);
         }
    }
}
