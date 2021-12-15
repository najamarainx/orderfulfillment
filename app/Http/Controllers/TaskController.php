<?php

namespace App\Http\Controllers;

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
        return view('tasks.list');
    }
    public function completedTasksList(){
        return view('tasks.completed_list');
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
        $orderSaleLogDetail = OrderFulfillmentSaleLog::with(['orderDetails'=>function($q){
           $q->where('payment','verified');
           $q->where('paid_percentage','>=','40');
           $q->whereNull('deleted_at');
        },'departmentDetails','itemDetails'=>function($item){
              $item->whereNull('deleted_at');
        },'variantDetails'=>function($variant){
            $variant->whereNull('deleted_at');
        },'assignedTask'=>function($task){
            $task->whereNull('deleted_at');
            $task->with(['assignedUser'=>function($user){
                $user->whereNull('deleted_at');
            }]);
        }])->whereNull('deleted_at')->where('status','completed');
        if($type == 'team_lead'){
            $orderSaleLogDetail->where('department_id',$department_id);
        }
        // $orderSaleLogDetails  = $orderSaleLogDetail->get();
        //  print_r($orderSaleLogDetails);exit;
        // $booking = DB::table('orderfulfillment_bookings')->select('orderfulfillment_bookings.*', 'booking_assign.date as assign_date', 'booking_assign.assign_status', 'booking_assign.booking_id', 'booking_assign.id as assign_id', 'ots.booking_from_time', 'ots.booking_to_time')->whereNull('orderfulfillment_bookings.deleted_at')->leftJoin('orderfulfillment_time_slots as ots', 'orderfulfillment_bookings.time_slot_id', 'ots.id')->whereNull('ots.deleted_at');
        // $booking->join('orderfulfillment_booking_assigns as booking_assign', 'orderfulfillment_bookings.id', 'booking_assign.booking_id')->whereNULL('booking_assign.deleted_at');
        // $booking->whereIn('orderfulfillment_bookings.booking_status', ['confirmed', 'rescheduled']);

        // if ($request->status == 'confirmed') {
        //     $booking->whereIn('orderfulfillment_bookings.booking_status', ['confirmed', 'rescheduled']);
        // }
        //  else {
        //     $booking->whereIn('orderfulfillment_bookings.booking_status', ['not called', 'not respond', 'cancelled']);
        // }
        // foreach ($columns as $field) {
        //     $col = $field['data'];
        //     $search = $field['search']['value'];
        //     if ($search != "") {
        //         if ($col == 'date') {
        //             $col = "booking_assign.date";
        //             $booking->where($col, $search);
        //         }
        //         if ($col == 'category_id') {
        //             $col = "orderfulfillment_bookings.category_id";
        //             $booking->where($col, $search);
        //         }
        //         if ($col == 'phone_number') {
        //             $col = "orderfulfillment_bookings.phone_number";
        //             $booking->where($col, 'like', '%' . $search . '%');
        //         }
        //         if ($col == 'assign_status') {
        //             $col = "booking_assign.assign_status";
        //             $booking->where($col, $search);
        //         }
        //         if ($col == 'first_name') {
        //             $col1 = 'orderfulfillment_bookings.first_name';
        //             $col2 = 'orderfulfillment_bookings.last_name';
        //             $booking->Where($col1, 'like', '%' . $search . '%');
        //             $booking->orWhere($col2, 'like', '%' . $search . '%');
        //         }
        //     }
        // }
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

            $action = "";


            $data[] = [
                "id" => $orderObj->id,
                "department_id" => $orderObj->departmentDetail->name,
                "item_id" => $orderObj->itemDetail->name,
                "variant_id" =>  $orderObj->variantDetail->name,
                "qty" => $orderObj->qty,
                "date" =>  Carbon::parse($orderObj->updated_at)->format('Y-m-d H:i:s'),
                "status" => '<span class="badge badge-success badge-pill booking_assign_status" style="cursor:pointer" >' . $orderObj->status . '</span>',
                "assign_to" => '<span class="badge badge-success badge-pill booking_assign_status" style="cursor:pointer>' . $orderObj->assignedTask->assignedUser->name . '</span>',
                "action" => $action
            ];
        }
        $records["data"] = $data;
        $records["draw"] = $draw;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        echo json_encode($records);
    }
}
