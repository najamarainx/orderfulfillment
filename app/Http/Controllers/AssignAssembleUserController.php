<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\OrderFulfillmentAssignAssembleUser;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Validator;

class AssignAssembleUserController extends Controller
{
    public function index()
    {

        return view('assembled_orders.assign_list');
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
        $sql = OrderFulfillmentAssignAssembleUser::select('orderfulffillment_assign_assemble_users.*','orderfulfillment_users.name as assigned_to','ab.name as assigned_from');
        $sql->join('orders','orders.id','orderfulffillment_assign_assemble_users.order_id');
        $sql->join('orderfulfillment_users','orderfulffillment_assign_assemble_users.user_id','orderfulfillment_users.id');
        $sql->join('orderfulfillment_users as ab','orderfulffillment_assign_assemble_users.added_by','ab.id');
        $sql->where('orderfulfillment_users.type','assembler');
        $sql->whereNULL('orders.deleted_at');
        $sql->where('orders.status','assembling');
        $sql->whereNULL('orderfulffillment_assign_assemble_users.deleted_at');
        $sql->whereNULL('orderfulfillment_users.deleted_at');
        if(Auth::user()->is_head==1){
            $sql->where('orderfulffillment_assign_assemble_users.user_id',Auth::user()->id);
        }

        foreach ($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if ($search != "") {
                if ($col == 'order_id') {
                    $sql->where('orderfulffillment_assign_assemble_users.order_id', $search);

                    // $sql->where($col, $search);
                }
               if ($col == 'status') {
                    $col = "orderfulffillment_assign_assemble_users.status";
                    $sql->where($col, $search);
                }
            }
        }

        if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            $sql->orderBy($sortColumnName, $sortColumnSortOrder);
        } else {
            $sql->orderBy("orderfulffillment_assign_assemble_users.id", "desc");
        }
        $iTotalRecords = $sql->count();
        $sql->skip($start);
        $sql->take($length);
        $orderData = $sql->get();

        $data = [];
        foreach ($orderData as $orderObj) {
            $action = "";
            $action .= '<a href="' . url('assembled-order/detail') . '/' . $orderObj->order_id . '" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3 preview">
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
                $status='<span class="label label-lg label-light-success label-inline"  style="cursor:pointer">' . $orderObj->status . '</span>';
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

    public function getUserAssembleStatus(Request $request)
    {
        $assemblerStatus=OrderFulfillmentAssignAssembleUser::where('id',$request->id)->first();
        $return = [
            'status' => 'success',
            'assembler_status' => $assemblerStatus,
        ];
        return response()->json($return);
    }

    public function updateAssemblingStatus(Request $request)
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
                'assembling_status.required' => 'assembling status field is required',

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
                $query = OrderFulfillmentAssignAssembleUser::where('id',$request->assembling_id)
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

    public function assemblerOrderCheck(Request $request)
    {
        $validate = true;
        $validateInput = $request->all();
        $rules = [
            'order_id'=>'required',
        ];
        $messages = [
            'order_id.required' => 'something wrong !',
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
              if($request->status == 'packing'){
                  $totalOrderTasks=orderAssignTaskStatuses($request->order_id,'','orderfulffillment_assign_assemble_users');
                  $totalCompletedOrderTasks=orderAssignTaskStatuses($request->order_id,'completed','orderfulffillment_assign_assemble_users');
                }elseif($request->status == 'installation'){
                $totalOrderTasks=orderAssignTaskStatuses($request->order_id,'','orderfulfillment_packings');
                $totalCompletedOrderTasks=orderAssignTaskStatuses($request->order_id,'completed','orderfulfillment_packings');
              }  elseif($request->status == 'completed'){
                $totalOrderTasks=orderAssignTaskStatuses($request->order_id,'','orderfulfillment_installations');
                $totalCompletedOrderTasks=orderAssignTaskStatuses($request->order_id,'completed','orderfulfillment_installations');
              }
              else{
                $totalOrderTasks=orderAssignTaskStatuses($request->order_id,'','orderfulffillment_assign_assemble_users');
                $totalCompletedOrderTasks=orderAssignTaskStatuses($request->order_id,'completed','orderfulffillment_assign_assemble_users');
              }
            //   print_r($totalCompletedOrderTasks);exit;
                if($totalOrderTasks==$totalCompletedOrderTasks)
                {
                    $query=Order::where('id',$request->order_id)->whereNull('deleted_at')->update(['status'=>$request->status]);
                }
                if(isset($query)){

                    $return = [
                        'status' => 'success',
                        'message' => 'Order ready for assign '.$request->status.' successfully!'
                    ];
                }
                else
                {
                    $return = [
                        'status' => 'error',
                        'message' => 'still order pending from assembler assign users'
                    ];
                }

        }
        return response()->json($return);
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
