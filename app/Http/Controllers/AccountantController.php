<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderFulfillmentPaymentLog;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\View;

class AccountantController extends Controller
{
    public function index()
    {
        $sql = Order::select('orders.*')->where('orders.payment', 'verified');
        $sql->where('orders.store_id',1);
        $sql->where('orders.paid_percentage','!=',100);
        $sql->whereNULL('orders.deleted_at');
        $totalItems = $sql->count();

        return view('accountant.list',compact('totalItems'));

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
        $sql = Order::select('orders.*', 'payment_order.payment_type as paymenttype')->where('orders.payment', 'verified');
        $sql->leftjoin('orderfulfillment_payment_logs as payment_order', 'payment_order.order_id', 'orders.id');
        $sql->where('orders.store_id',1);
        $sql->where('orders.paid_percentage','!=',100);
        $sql->whereNULL('orders.deleted_at');

        foreach ($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if ($search != "") {
                if ($col == 'id') {
                    $colp = 'orders.id';
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


            $action .= '<a  class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3 preview" data-id="'.$orderObj->id.'~'.$orderObj->total_price.'">
                <i class="la la-eye"></i>
            </a>';
          
            $orderItem_status_class = null;
            if($orderObj->paid_percentage  <= 40){
                $orderItem_status_class = 'label-light-danger';
             }
            if($orderObj->paid_percentage  > 40 && $orderObj->paid_percentage  <=99 ){
                $orderItem_status_class = 'label-light-warning';
             }
            if($orderObj->paid_percentage  > 99){
                $orderItem_status_class = 'label-light-success';
             }  
          
            $data[] = [
                "id" => $orderObj->id,
                "paid_price" => !empty($orderObj->total_price) ? '£'.$orderObj->total_price : '',
                "paid_amount" => !empty($orderObj->paid_amount) ? '£'.$orderObj->paid_amount : '',
                "paymenttype" => !empty($orderObj->paymenttype) ? $orderObj->paymenttype : '',
                "paid_percentage" => '<span class="label label-lg '.$orderItem_status_class.'  label-inline">'. $orderObj->paid_percentage.'</span>',
                "created_at" => Carbon::create($orderObj->created_at)->format(config('app.date_time_format', 'M j, Y, g:i a')),
                "action" => $action
            ];
        }


        $records["data"] = $data;
        $records["draw"] = $draw;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        echo json_encode($records);
    }

    public function previewPaymentLog(Request $request)
    {
        $orderdetail=explode('~',$request->id);
        $sql = OrderFulfillmentPaymentLog::select('orderfulfillment_payment_logs.*','orderfulfillment_users.name','orderfulfillment_users.type')->where('orderfulfillment_payment_logs.order_id',$orderdetail[0]);
        $sql->join('orderfulfillment_users','orderfulfillment_users.id','=','orderfulfillment_payment_logs.added_by');
        $paymentLog=$sql->get();
        $dt = [
            'paymentLogs' =>$paymentLog,
            'orderID' =>$orderdetail[0],

        ];

        $paymeentLogHtml = View::make('template.payment_log', $dt)->render();
        $data['paymeentLogHtml'] = $paymeentLogHtml;
        $data['totalAmount'] = $orderdetail[1];

        return response()->json($data);

    }

    public function approvePaymentLog(Request $request)
    {
        $verifyAmount=array();
        if(!empty($request->verify_amt))
        {
            foreach($request->verify_amt as $key=>$id)
            {
                $verifyAmount[]=array(

                    'id'=>$key,
                    'is_verified'=>1,

                );

            }

            $qry=OrderFulfillmentPaymentLog::upsert($verifyAmount,['id']);
            $return = [
                'status' => 'error',
                'message' => 'payment log not maintain successfully',
            ];
            if($qry){

                $paidAmount = OrderFulfillmentPaymentLog::where('is_verified', 1)->where('order_id',$request->orderID)->sum('paid_amount');
                $orderInfo= Order::find($request->orderID);
                $totalAmount=$orderInfo->total_price;
                $getTotalPercentage=($paidAmount * 100) / $totalAmount;

                Order::where('id',$request->orderID)
                    ->update(['paid_amount' => $paidAmount,'paid_percentage'=>$getTotalPercentage]);
                $return = [
                    'status' => 'success',
                    'message' => 'payment log maintain successfully',
                ];
            }
        }
        else{
            $return = [
                'status' => 'error',
                'message' => 'payment log not maintain successfully',
            ];
        }

        return response()->json($return);

    }






}
