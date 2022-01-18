<?php

namespace App\Http\Controllers;

use App\Models\OrderFulfillmentItem;
use App\Models\OrderFulfillmentSupplier;
use App\Models\OrderFulfillmentSupplierStock;
use App\Models\OrderFulfillmentStockOrder;
use App\Models\OrderFulfillmentDepartment;
use App\Models\OrderFulfillmentSupplierStockOrder;
use App\Models\OrderFulfillmentInventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Validator;

class SupplierStockController extends Controller
{

    public function index()
    {
        $departments=OrderFulfillmentDepartment::whereNULL('deleted_at')->get();
        $suppliers=OrderFulfillmentSupplier::whereNULL('deleted_at')->get();
        $variants=getVariants();
        $bills = OrderFulfillmentSupplierStock::select('orderfulfillment_stock_orders.*', 'orderfulfillment_suppliers.name as supplier_name', 'orderfulfillment_suppliers.company_name')->whereNULL('orderfulfillment_stock_orders.deleted_at');
        $bills->join('orderfulfillment_suppliers', 'orderfulfillment_stock_orders.supplier_id', '=', 'orderfulfillment_suppliers.id');

        $dt = [
            'departments' => $departments,
            'suppliers' => $suppliers,
            'variants' => $variants,
            'totalItems' => $bills->count(),

        ];
        return view('stocks.list', $dt);
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
        $bills = OrderFulfillmentSupplierStock::select('orderfulfillment_stock_orders.*', 'orderfulfillment_suppliers.name as supplier_name', 'orderfulfillment_suppliers.company_name')->whereNULL('orderfulfillment_stock_orders.deleted_at');
        $bills->join('orderfulfillment_suppliers', 'orderfulfillment_stock_orders.supplier_id', '=', 'orderfulfillment_suppliers.id');
        foreach ($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if ($search != "") {

                if ($col == 'id') {
                    $bills->where('orderfulfillment_stock_orders.' . $col, $search);
                }
                if ($col == 'name') {
                    $colpp = 'id';
                    $bills->where('orderfulfillment_suppliers.' . $colpp, $search);
                }

            }
        }
        if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            if ($sortColumnName == 'id') {
                $bills->orderBy("orderfulfillment_stock_orders.id", "desc");
            }
            if ($sortColumnName == 'price') {
                $bills->orderBy("orderfulfillment_stock_orders.total_price", "desc");
            }
            if ($sortColumnName == 'qty') {
                $bills->orderBy("orderfulfillment_stock_orders.qty", "desc");
            }
        } else {

            $bills->orderBy("orderfulfillment_stock_orders.id", "desc");
        }
        //$user->groupBy('orderfulfillment_users.id');
        $iTotalRecords = $bills->count();
        $bills->skip($start);
        $bills->take($length);
        $billData = $bills->get();
        $data = [];
        $i = 1;
        foreach ($billData as $billObj) {
            $action = "";
            $action .= '<a href="' . url('stockorder/detail') . '/' . $billObj->id . '" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3 preview" data-id="' . $billObj->id . '">
            <i class="la la-eye"></i>
        </a>';

            $action .= '<a href="' . url('stockorder/edit') . '/' . $billObj->id . '" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details">
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
            if($billObj->is_verified==0){
                $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon delete" data-id="' . $billObj->id . '" title="Delete">
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

            $data[] = [
                "id" => $billObj->id,
                "name" => $billObj->supplier_name,
                "company_name" => $billObj->company_name,
                //"dept" => $billObj->dept_name,
                "price" => $billObj->total_price,
                "qty" => $billObj->qty,
                "created_at" => Carbon::create($billObj->created_at)->format(config('app.date_time_format', 'M j, Y, g:i a')),
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
        $id = $request->id;
        $validate = true;
        $validateInput = $request->all();
        $rules = [
            'supplier_stock_id' => 'required|max:150',
            'dept_stock.*' => 'required|max:150',
            'unit_stock.*' => 'required|max:150',
            'variant_stock.*' => 'required|max:150',
            'per_unit_price.*' => 'required|max:150',
            'qty_unit_price.*' => 'required|max:150',
            'total_variant_price.*' => 'required|max:150',
            'overall_total_price' => 'required|max:150',
            'overall_total_qty' => 'required|max:150',

        ];
        $messages=[
            'supplier_stock_id.required' => 'supplier field is required!',
            'dept_stock.*.required' => 'department field is required!',
            'unit_stock.*.required' => 'unit stock field is required!',
            'variant_stock.*.required' => 'Varaint stock field is required!',
            'per_unit_price.*.required' => 'per unit price field is required!',
            'qty_unit_price.*.required' => 'quantity unit price field is required!',
            'total_variant_price.*.required' => 'total price unit  field is required!',


        ];
        $validator = Validator::make($validateInput, $rules,$messages);
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
                $stockOrder=new  OrderFulfillmentSupplierStock();
                $id=$request->id;
                $supplier_id=$request->supplier_stock_id;
                $dept_ids=$request->dept_stock;
                $item_stock=$request->item_stock;
                $unit_stock=$request->unit_stock;
                $qty_stock=$request->qty_stock;
                $variant_stocks=$request->variant_stock;
                $variant_per_unit_price=$request->per_unit_price;
                $variant_qty_unit_price=$request->qty_unit_price;
                $variant_total_variant_price=$request->total_variant_price;
                $variantData=array();
                $variants=$request->name;
                if ($id > 0) {
                    foreach($variants as $variant){
                        $variantData[]=array(
                            'id'=>$id,
                            'name'=>$variant,
                            'updated_at'=> Carbon::now()->format("Y-m-d H:i:s"),
                        );

                    }

                    $query=DB::table('orderfulfillment_variants')->upsert($variantData,['id'], ['name']);
                    $return = [
                        'status' => 'error',
                        'message' => 'Variant is not updated successfully',
                    ];
                    if ($query) {
                        $return = [
                            'status' => 'success',
                            'message' => 'Variant is updated successfully',

                        ];
                    }
                }
                else{

                    $stock_order_items=array();
                    $stockOrder->supplier_id=$supplier_id;
                    $stockOrder->qty=$request->overall_total_qty;
                    $stockOrder->total_price=$request->overall_total_price;
                    $stockOrder->created_by=Auth::user()->id;
                    $stockOrder->created_at=Carbon::now()->format("Y-m-d H:i:s");
                    $qry=$stockOrder->save();
                    $orderID=$stockOrder->id;
                    foreach($dept_ids as $key=>$dept_id)
                    {
                        foreach($variant_stocks[$key] as $va=>$variantinfo)
                        {
                            $itemsInfo=explode('~',$item_stock[$key]);
                            $stock_order_items[]=array(
                                'stock_order_id'=>$orderID,
                                'department_id'=>$dept_id,
                                'item_id'=>$itemsInfo[0],
                                'variant_id'=>$variantinfo,
                                'per_unit_price'=>$variant_per_unit_price[$key][$va],
                                'qty'=>$variant_per_unit_price[$key][$va],
                                'total_price'=>$variant_total_variant_price[$key][$va],
                                'created_at'=>Carbon::now()->format("Y-m-d H:i:s"),


                            );
                        }

                    }
                    if(!empty($stock_order_items)) {
                         OrderFulfillmentSupplierStockOrder::insert($stock_order_items);
                    }

                }

                DB::commit();
                $return = [
                    'status' => 'success',
                    'message' => 'stock supplier is save successfully',
                ];

            }
            catch(\Exception $e){
                $return = [
                    'status' => 'error',
                    'message' => 'stock supplier is not save successfully',
                ];
            }

        }

        return response()->json($return);
    }
    public function destroy(Request $request)
    {
        $id = $request->id;
        $res = OrderFulfillmentSupplierStock::find($id);
        if ($res) {
            $res->delete();
            OrderFulfillmentSupplierStockOrder::where('stock_order_id',$request->id)
                ->update(['deleted_at' =>Carbon::now()->format("Y-m-d H:i:s")]);
            return response()->json(['status' => 'success', 'message' => 'Stock Order is deleted successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Stock Order not deleted ']);
        }
    }

    public function detailProduct($id){
        $orderItems= OrderFulfillmentStockOrder::with(['stockOrderDetail'=>function($query){
            $query->with(['orderItem','orderVariant']);
        },'supplierDetail'])->where('id',$id)->first();
        $dt = ['orderItems'=>$orderItems];
        return view('stocks.preview',$dt);
    }

    public function editPurchaseOrder($purchaseOrderID)
    {
        $purchaseOrderInfo=getPurchaseOrderInfo($purchaseOrderID);
        if($purchaseOrderInfo->is_verified==0)
        {
            $departments=OrderFulfillmentDepartment::whereNULL('deleted_at')->get();
            $suppliers=OrderFulfillmentSupplier::whereNULL('deleted_at')->get();
            $items=OrderFulfillmentItem::whereNULL('deleted_at')->get();
            $variants=getVariants();
            $orderItems= OrderFulfillmentStockOrder::with(['stockOrderDetail'=>function($query){
                $query->with(['orderItem'=>function($item){
                    $item->with(['orderVariant'=>function($variant){
                        $variant->whereNULL('deleted_at');
                    }]);
                }]);
                $query->whereNULL('deleted_at');
            },'supplierDetail'])->where('id',$purchaseOrderID)->first();

            $dt=[
                'departments' => $departments,
                'suppliers' => $suppliers,
                'variants' => $variants,
                'orderItems' => $orderItems,
                'items' => $items,
                ];
            return view('stocks.edit_purchase_order',$dt);
        }
        else{

            return redirect()->back()->with('error', 'Stock adds in inventory now it can t be edited now');
        }


    }

    public function saveAndProceedOrder(Request $request)
    {
        $id = $request->id;
        $validate = true;
        $validateInput = $request->all();
        $rules = [

            'supplier_id' => 'required|max:150',
            'overall_total_qty' => 'required|max:150',
            'overall_total_price' => 'required|max:150',
            'department_id.*' => 'required|max:150',
            'item_id.*' => 'required|max:150',
            'variant.*' => 'required|max:150',
            'unit_price.*' => 'required|max:150',
            'qty.*' => 'required|max:150',
            'price.*' => 'required|max:150',


        ];
        $messages=[
            'supplier_id.required' => 'supplier field is required!',
            'overall_total_qty.required' => 'Total overall quantity field is required!',
            'overall_total_price.required' => 'Total overall Price field is required!',
            'department_id.*.required' => 'department field is required!',
            'item_id.*.required' => 'items field is required!',
            'variant.*.required' => 'variant field is required!',
            'unit_price.*.required' => 'unit price field is required!',
            'qty.*.required' => 'quantity price field is required!',
            'price.*.required' => 'price field is required!',



        ];
        $validator = Validator::make($validateInput, $rules,$messages);
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
                    $ordermain=OrderFulfillmentSupplierStock::where('id',$request->id);
                    $qry=$ordermain->update(['total_price'=>$request->overall_total_price,'qty'=>$request->overall_total_qty,'supplier_id'=>$request->supplier_id,'updated_at'=>Carbon::now()->format("Y-m-d H:i:s")]);
                    if($request->is_verified=='1'){$qry=$ordermain->update(['is_verified' => 1]);}
                    if($qry){

                        OrderFulfillmentSupplierStockOrder::where('stock_order_id',$request->id)
                            ->update(['deleted_at' =>Carbon::now()->format("Y-m-d H:i:s")]);

                        $department_ids=$request->department_id;
                        $item_id=$request->item_id;
                        $variant=$request->variant;
                        $unit_price=$request->unit_price;
                        $qty=$request->qty;
                        $price=$request->price;
                        foreach($department_ids as $key=>$department_id){
                            $itemsData[]=array(
                                'stock_order_id'=>$request->id,
                                'department_id'=>$department_id,
                                'item_id'=>$item_id[$key],
                                'variant_id'=>$variant[$key],
                                'per_unit_price'=>$unit_price[$key],
                                'qty'=>$qty[$key],
                                'total_price'=>$price[$key],
                                'created_at'=>Carbon::now()->format("Y-m-d H:i:s"),

                            );
                            if($request->is_verified=='1'){
                                $model = OrderFulfillmentInventoryItem::where('item_id', $item_id[$key])->where('variant_id', $variant[$key])->where('department_id',$department_id)->first();
                                if (isset($model) && !empty($model)) {

                                    $model->qty +=$qty[$key];
                                } else {

                                    $model = new OrderFulfillmentInventoryItem();
                                    $model->department_id = $department_id;
                                    $model->item_id = $item_id[$key];
                                    $model->variant_id =$variant[$key];
                                    $model->qty=$qty[$key];
                                    $model->created_by=Auth::user()->id;
                                }
                                $model->save();
                            }

                        }
                        $query = OrderFulfillmentSupplierStockOrder::insert($itemsData);
                    }
                    DB::commit();
                    $return = [
                        'status' => 'success',
                        'message' => 'stock supplier is save successfully',
                    ];
                }
                catch(\Exception $e){
                    DB::rollback();
                    $return = [
                        'status' => 'error',
                        'message' => 'stock supplier is data not update successfully',
                    ];
                }

        }

        return response()->json($return);
    }



}
