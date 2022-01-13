<?php

namespace App\Http\Controllers;

use App\Models\OrderFulfillmentDepartment;
use App\Models\OrderFulfillmentInventoryItem;
use App\Models\OrderFulfillmentSaleLog;
use App\Models\OrderFulfillmentVariant;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderFulfillmentUser;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class OrderController extends Controller
{
    public function index()
    {
        $stores = DB::table('stores')->whereNull('deleted_at')->get();
        $sql = Order::select('orders.*', 'stores.name as store_name')->where('orders.payment', 'verified');
        $sql->join('stores', 'orders.store_id', 'stores.id');
        $sql->where('orders.paid_percentage', '<=', '40');
        $sql->whereNULL('stores.deleted_at');
        $sql->whereNULL('orders.deleted_at');
        $dt = ['stores' => $stores,'totalPendingOrders'=>$sql->count()];
        return view('orders.list', $dt);
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
        if (!empty($request->order_status) && $request->order_status == 'confirmed') {
            $sql->where('orders.paid_percentage', '>=', '40');
            $sql->whereNotIn('orders.status', ['assembling','packing','installation','completed']);
        } elseif (!empty($request->order_status) && $request->order_status == 'pending') {
            $sql->where('orders.paid_percentage', '<=', '40');
        }

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
            if (!empty($request->order_status) && $request->order_status == 'confirmed') {
                $action .= '<a href="' . url('orders/detail') . '/' . $orderObj->id . '" target="_blank"  class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3 ">
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
            if($request->order_status == 'admin_order')
            {
                $action .= '<a href="' . url('orders/getOrderDetailHistory') . '/' . $orderObj->id . '" target="_blank"  class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3 ">
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


            /*$action .= '<a href="javascript:;" class="btn btn-icon btn-light btn-hover-primary btn-sm delete" data-id="' . $orderObj->id . '" title="Delete">
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
            </a>';*/
            $order_status = null;
            if($orderObj->status == 'pending'){
                $order_status = 'label-light-danger';
             }
            if($orderObj->status == 'in progress'){
                $order_status = 'label-light-warning';
             }
            if($orderObj->status == 'completed'){
                $order_status = 'label-light-success';
             }
            if($orderObj->status == 'assigned inventory'){
                $order_status = 'label-light-warning';
             }
            
            if($orderObj->status == 'production'){
                $order_status = 'label-light-warning';
             }
            if($orderObj->status == 'assembling'){
                $order_status = 'label-light-warning';
             }
            if($orderObj->status == 'packing'){
                $order_status = 'label-light-warning';
             }
            if($orderObj->status == 'installation'){
                $order_status = 'label-light-warning';
             }
            $data[] = [
                "id" => $orderObj->id,
                "store_id" => $orderObj->store_name,
                "name" => $orderObj->name,
                "phone" => $orderObj->phone,
                "created_at" => Carbon::create($orderObj->created_at)->format(config('app.date_time_format', 'M j, Y, g:i a')),
                "status" => '<span class="'.(isset($order_status) && !empty($order_status) ? 'label label-lg ' .$order_status : '').' label-inline">' .$orderObj->status.'</span>',
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

    public function getAssignedProductInventory(Request $request)
    {
        $saveassignedInventory = OrderFulfillmentSaleLog::select('orderfulfillment_sale_logs.*', 'orderfulfillment_departments.name as department_name', 'orderfulfillment_items.name as item_name', 'orderfulfillment_variants.name as variant_name')->where('orderfulfillment_sale_logs.order_id', $request->orderID)->where('orderfulfillment_sale_logs.product_id', $request->ProductID);
        $saveassignedInventory->join('orderfulfillment_departments', 'orderfulfillment_sale_logs.department_id', '=', 'orderfulfillment_departments.id');
        $saveassignedInventory->join('orderfulfillment_items', 'orderfulfillment_sale_logs.item_id', '=', 'orderfulfillment_items.id');
        $saveassignedInventory->join('orderfulfillment_variants', 'orderfulfillment_sale_logs.variant_id', '=', 'orderfulfillment_variants.id');
        $saveassignedInventory->whereNULL('orderfulfillment_sale_logs.deleted_at');
        $assignedInventory = $saveassignedInventory->get();

        $departments = OrderFulfillmentDepartment::get();
        $variants = OrderFulfillmentVariant::get();

        $dt = [
            'departments' => $departments,
            // 'variants' => $variants,
            'assignedInventory' => $assignedInventory,
            'product_id' => $request->ProductID,

        ];

        $inventoryassignedHtml = View::make('template.product_inventory', $dt)->render();
        $data['inventoryassignedHtml'] = $inventoryassignedHtml;
        return response()->json($data);
    }
    public function saleLog(Request $request)
    {

        $validate = true;
        $validateInput = $request->all();
        $rules = [
            'product_id' => 'required|max:150',
            'order_id' => 'required|max:150',
            'department.*' => 'required|max:150',
            'item_id.*' => 'required|max:150',
            'variant.*' => 'required|max:150',
            'qty.*' => 'required|max:150',
            'choose_qty.*' => 'required|max:150',


        ];
        $messages = [
            'product_id.required' => 'something wrong against product!',
            'order_id.required' => 'something wrong against product order field is required!',
            'department.*.required' => 'department field is required!',
            'item_id.*.required' => 'item field is required!',
            'variant.*.required' => 'Variant  field is required!',
            'qty.*.required' => 'qty field is required!',
            'choose_qty.*.required' => 'choose_qty field is required!',
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
        if ($validate) {

            DB::beginTransaction();
            try {

                // $saleLog = new  OrderFulfillmentSaleLog();
                $product_id = $request->product_id;
                $departments = $request->department;
                $item_ids = $request->item_id;
                $variants = $request->variant;
                //$qtys=$request->qty;
                $choose_qty = $request->choose_qty;
                $order_id = $request->order_id;

                $inventoryData = array();
                foreach ($departments as $key => $department) {
                    $inventoryData[] = array(
                        'order_id' => $order_id,
                        'product_id' => $product_id,
                        'department_id' => $department,
                        'item_id' => $item_ids[$key],
                        'variant_id' => $variants[$key],
                        'qty' => $choose_qty[$key],
                        'created_by' => Auth::user()->id,
                        'created_at' => Carbon::now()->format("Y-m-d H:i:s"),
                    );
                }
                if (!empty($inventoryData)) {
                    $query = OrderFulfillmentSaleLog::insert($inventoryData);
                }
                $return = [
                    'status' => 'error',
                    'message' => 'inventory is not added agaist this product',
                ];
                if ($query) {
                    $return = [
                        'status' => 'success',
                        'message' => 'Inventory ready to assigned this product',

                    ];
                }
                DB::commit();
            } catch (\Exception $e) {

                $return = [
                    'status' => 'error',
                    'message' => 'inventory is not added agaist this product',
                ];
            }
        }

        return response()->json($return);
    }

    public function saveProceedOrderInventory(Request $request)
    {
        $orderID = $request->order_id;
        $saleLogInventorys = OrderFulfillmentSaleLog::where('order_id', $orderID)->where('is_verified', 0)->get();

        DB::beginTransaction();
        try {
            if (!$saleLogInventorys->isEmpty()) {
                foreach ($saleLogInventorys as $saleLogInventory) {
                    $qty = OrderFulfillmentInventoryItem::select('qty')->where('department_id', $saleLogInventory->department_id)->where('item_id', $saleLogInventory->item_id)->where('variant_id', $saleLogInventory->variant_id)->first();
                    OrderFulfillmentInventoryItem::where('department_id', $saleLogInventory->department_id)
                        ->where('item_id', $saleLogInventory->item_id)
                        ->where('variant_id', $saleLogInventory->variant_id)
                        ->update(['qty' => $qty->qty - $saleLogInventory->qty]);

                    OrderFulfillmentSaleLog::where('department_id', $saleLogInventory->department_id)
                        ->where('id', $saleLogInventory->id)
                        ->update(['is_verified' => '1']);
                }

                DB::commit();
                Order::where('id', $orderID)->update(['status' => 'assigned inventory']);
                $return = [
                    'status' => 'success',
                    'message' => 'Inventory assigned against order',

                ];
            } else {

                $return = [
                    'status' => 'success',
                    'message' => 'you already assign inventory',

                ];
            }
        } catch (\Exception $e) {

            $return = [
                'status' => 'error',
                'message' => 'Inventory not assigned against order',
            ];
        }

        return response()->json($return);
    }

    public function productInventoryList(Request $request)
    {
        $saveassignedInventory = OrderFulfillmentSaleLog::select('orderfulfillment_sale_logs.*', 'orderfulfillment_departments.name as department_name', 'orderfulfillment_items.name as item_name', 'orderfulfillment_variants.name as variant_name', 'orderfulfillment_inventory_items.qty as available_qty')->where('orderfulfillment_sale_logs.order_id', $request->orderID)->where('orderfulfillment_sale_logs.product_id', $request->ProductID);
        $saveassignedInventory->join('orderfulfillment_departments', 'orderfulfillment_sale_logs.department_id', '=', 'orderfulfillment_departments.id');
        $saveassignedInventory->join('orderfulfillment_items', 'orderfulfillment_sale_logs.item_id', '=', 'orderfulfillment_items.id');
        $saveassignedInventory->join('orderfulfillment_variants', 'orderfulfillment_sale_logs.variant_id', '=', 'orderfulfillment_variants.id');
        $saveassignedInventory->join('orderfulfillment_inventory_items', function ($q) {
            $q->on('orderfulfillment_sale_logs.department_id', '=', 'orderfulfillment_inventory_items.department_id');
            $q->on('orderfulfillment_sale_logs.item_id', '=', 'orderfulfillment_inventory_items.item_id');
            $q->on('orderfulfillment_sale_logs.variant_id', '=', 'orderfulfillment_inventory_items.variant_id');
        });
        $saveassignedInventory->whereNULL('orderfulfillment_sale_logs.deleted_at');
        $saveassignedInventory->whereNULL('orderfulfillment_inventory_items.deleted_at');
        $assignedInventory = $saveassignedInventory->get();
        $departments = OrderFulfillmentDepartment::whereNULL('deleted_at')->get();
        $variants = OrderFulfillmentVariant::whereNULL('deleted_at')->get();

        $dt = [
            'departments' => $departments,
            'variants' => $variants,
            'assignedInventory' => $assignedInventory,
            'product_id' => $request->ProductID,

        ];

        $inventoryassignedHtml = View::make('template.edit_product_inventory', $dt)->render();
        $data['inventoryassignedHtml'] = $inventoryassignedHtml;
        return response()->json($data);
    }

    public function getItemVariant(Request $request)
    {
        $varinats_id  =  OrderFulfillmentInventoryItem::where(['department_id' => $request->depID, 'item_id' => $request->itemID])->whereNull('deleted_at')->pluck('variant_id')->toArray();
        $variant_ids = getProductSaleLogVariant($request->orderID, $request->productID, $request->depID, $request->itemID);
        $variants = OrderFulfillmentVariant::whereNull('deleted_at');

        if (!empty($variant_ids)) {
            $variants->whereNotIn('id', $variant_ids);
        }
        if (!empty($varinats_id)) {
            $variants->whereIn('id', $varinats_id);
            $result = $variants->get();
        } else {
            $result = '';
        }

        return response()->json($result);
    }

    public function logItemDelete(Request $request)
    {
        $productID = $request->product_id;
        $logID = $request->log_id;
        $query = OrderFulfillmentSaleLog::where('id', $logID)
            ->update(['deleted_at' => Carbon::now()->format("Y-m-d H:i:s")]);
        $return = [
            'status' => 'error',
            'message' => 'inventory not removed from items product',
        ];
        if ($query) {
            $return = [
                'status' => 'success',
                'message' => 'remove inventory items from product',
            ];
        }

        return response()->json($return);
    }

    public function logItemUpdate(Request $request)
    {
        $productID = $request->product_id;
        $logID = $request->log_id;
        $query = OrderFulfillmentSaleLog::where('id', $logID)
            ->where('is_verified', 0)
            ->update(['updated_at' => Carbon::now()->format("Y-m-d H:i:s"), 'qty' => $request->qty]);
        $return = [
            'status' => 'error',
            'message' => 'quantity not updated agaisnt product inventory',
        ];
        if ($query) {
            $return = [
                'status' => 'success',
                'message' => 'quantity updated agaisnt product inventory',
            ];
        }

        return response()->json($return);
    }


    public function confirmedOrderList()
    {
        $stores = $query = DB::table('stores')->whereNull('deleted_at')->get();
        $sql = Order::select('orders.*', 'stores.name as store_name')->where('orders.payment', 'verified');
        $sql->join('stores', 'orders.store_id', 'stores.id');
        $sql->where('orders.paid_percentage', '>=', '40');
        $sql->whereNotIn('orders.status', ['assembling','packing','installation','completed']);
        $sql->whereNULL('stores.deleted_at');
        $sql->whereNULL('orders.deleted_at');

        $dt = ['stores' => $stores,'totalConfirmedOrder'=>$sql->count()];
        return view('orders.confirmed_order_list', $dt);
    }

    public function adminOrderList()
    {
        $stores = $query = DB::table('stores')->whereNull('deleted_at')->get();
        $sql = Order::select('orders.*', 'stores.name as store_name')->where('orders.payment', 'verified');
        $sql->join('stores', 'orders.store_id', 'stores.id');
        $sql->whereNULL('stores.deleted_at');
        $sql->whereNULL('orders.deleted_at');
        $dt = ['stores' => $stores,'totalOrders'=>$sql->count()];
        return view('orders.admin_order_list', $dt);
    }




    public function getOrderDetailHistory($id){
        $order_Info  =  Order::where('orders.id',$id)->whereNull('orders.deleted_at');
        $order_Info->join('stores','orders.store_id','stores.id');
        $orderInfo=$order_Info->first();
        $orderBookingInfo='';
        if(!empty($orderInfo->booking_id)){
           $orderBookingInfo  = orderBookingInfo($orderInfo->booking_id);
        }

        $orderProductItemsInventory=orderProductInventory($id);
        $orderAssembleInfo  = orderAssemble($id);
        $orderInstallationInfo  = orderInstallation($id);
        $orderPackingInfo = orderPackings($id);
        $orderPamentLogsInfo = paymentLog($id);

        $dt=[

            'orderInfo'=>$orderInfo,
            'orderProductItemsInventory'=>$orderProductItemsInventory,
            'orderBookingInfo'=>$orderBookingInfo,
            'orderAssembleInfo'=>$orderAssembleInfo,
            'orderInstallationInfo'=>$orderInstallationInfo,
            'orderPackingInfo'=>$orderPackingInfo,
            'orderPamentLogsInfo'=>$orderPamentLogsInfo,


        ];

        return view('orders.admin_order_history', $dt);

    }

}
