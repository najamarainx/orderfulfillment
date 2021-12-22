<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderFulfillmentAssignedTask;
use App\Models\OrderItem;
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
        $sortColumnName = 'orderfulfillment_assigned_tasks.id'; // Column name
        $sortColumnSortOrder = $request->order[0]['dir']; // asc or desc
        $columns = $request->columns;
        $department_id =  session()->get('department_id');


        $orderSaleLogDetail = OrderFulfillmentAssignedTask::with(['saleLogs'=>function($saleLog) use ($department_id){
            $saleLog->whereNull('deleted_at')->whereIn('status', ['in progress','pending']);
            $saleLog->where('department_id', $department_id);
            $saleLog->where('is_verified', 1);
            $saleLog->with(['departmentDetails'=>function($department){
                $department->whereNull('deleted_at');
            }]);
            $saleLog->with(['itemDetails'=>function($item){
                $item->whereNull('deleted_at');
            },'variantDetails']);
        }, 'assignedUser'=>function($user){
            $user->whereNull('deleted_at');
        }]);





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
            $orderSaleLogDetail->orderBy("orderfulfillment_assigned_tasks.id", "asc");
        }
        $iTotalRecords = $orderSaleLogDetail->count();
        $orderSaleLogDetail->skip($start);
        $orderSaleLogDetail->take($length);
        $orderSaleLogDetailData = $orderSaleLogDetail->get();

        $data = [];
        foreach ($orderSaleLogDetailData as $key=> $orderObj) {
           if(!empty($orderObj->saleLogs)){
               $status = '';
               $status .= '<span class="badge badge-success badge-pill worker_assign_status" data-user-id="'.(!empty($orderObj->assignedUser) ? $orderObj->assignedUser->id : '').'"   data-id="'.(!empty($orderObj->saleLogs->id) ? $orderObj->saleLogs->id : '').'" style="cursor:pointer" >' .  $orderObj->saleLogs->status  . '</span>';
               $data[] = [
                   "id" => !empty($orderObj->id) ? $orderObj->id : '',
                   "department_id" => !empty($orderObj->saleLogs) && !empty($orderObj->saleLogs->departmentDetails) ? $orderObj->saleLogs->departmentDetails->name : '',
                   "item_id" => !empty($orderObj->saleLogs) && !empty($orderObj->saleLogs->itemDetails) ?  $orderObj->saleLogs->itemDetails->name : '',
                   "variant_id" => !empty( $orderObj->saleLogs) && !empty($orderObj->saleLogs->variantDetails) ?  $orderObj->saleLogs->variantDetails->name : '',
                   "qty" => !empty($orderObj->saleLogs) && !empty($orderObj->saleLogs->qty) ? $orderObj->saleLogs->qty :'',
                   "date" =>  !empty($orderObj->created_at) ? Carbon::parse($orderObj->created_at)->format('Y-m-d H:i:s') : '',
                   "status" => $status,
                   "assign_to" => !empty($orderObj->assignedUser) && !empty($orderObj->assignedUser->name) ? $orderObj->assignedUser->name : '',
               ];
           }


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

                     $orderInfo=OrderFulfillmentSaleLog::where('id',$request->worker_task_log_id)->whereNull('deleted_at')->first();
                     $totalProducts=checkTaskProductItems($orderInfo->order_id,$orderInfo->product_id,'');
                     $completedtotalProducts=checkTaskProductItems($orderInfo->order_id,$orderInfo->product_id,'completed');
                     if($completedtotalProducts==$totalProducts){
                         OrderItem::where('order_id',$orderInfo->order_id)->whereNull('deleted_at')->update(['status'=>'completed']);
                     }
                     $totalOrderTasks=totalOrderTaskStatus($orderInfo->order_id,'');
                     $totalCompletedOrderTasks=totalOrderTaskStatus($orderInfo->order_id,'completed');
                     if($totalOrderTasks==$totalCompletedOrderTasks)
                     {
                         Order::where('id',$orderInfo->order_id)->whereNull('deleted_at')->update(['status'=>'assembling']);
                     }

                    $return = ['status' => 'success', 'message' => 'Your status updated successfully!'];
                 }
                }else{
                $return = ['status' => 'error', 'message' => 'Sorry your security code is incorrect!'];
            }
            return response()->json($return);
         }
    }
}
