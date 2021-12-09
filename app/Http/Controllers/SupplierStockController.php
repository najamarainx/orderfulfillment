<?php

namespace App\Http\Controllers;

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

        $dt = [
            'departments' => $departments,
            'suppliers' => $suppliers,
            'variants' => $variants,

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
            $bills->orderBy("orderfulfillment_stock_orders.supplier_id", "desc");
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

            $action .= '<a href="' . url('stockorder/edit') . '/' . $billObj->id . '" class="btn btn-sm btn-clean btn-icon " title="Edit details">
                            <i class="la la-edit"></i>
                        </a>';
            $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon delete" data-id="' . $billObj->id . '" title="Delete">
                            <i class="la la-trash"></i>
                        </a>';
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
                    $query = OrderFulfillmentSupplierStockOrder::insert($stock_order_items);

                   foreach ($stock_order_items as $key=>$stock_order_item) {
                       $model = OrderFulfillmentInventoryItem::where('item_id', $stock_order_item['item_id'])->where('variant_id', $stock_order_item['variant_id'])->first();
                        if (isset($model) && !empty($model)) {

                            $model->qty += $stock_order_item['qty'];
                        } else {

                            $model = new OrderFulfillmentInventoryItem();
                            $model->department_id = $stock_order_item['department_id'];
                            $model->item_id = $stock_order_item['item_id'];
                            $model->variant_id =$stock_order_item['variant_id'];
                            $model->qty=$stock_order_item['qty'];
                            $model->created_by=Auth::user()->id;
                        }
                        $model->save();

                    }
                }

            }

            DB::commit();
            $return = [
                'status' => 'success',
                'message' => 'stock supplier is save successfully',
            ];

        }

        return response()->json($return);
    }
    public function destroy(Request $request)
    {
        $id = $request->id;
        $res = OrderFulfillmentSupplierStock::find($id);
        if ($res) {
            $res->delete();
            return response()->json(['status' => 'success', 'message' => 'Stock Order is deleted successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Stock Order not deleted ']);
        }
    }

    public function detailProduct($id){
        $orderItems= OrderFulfillmentStockOrder::with(['stockOrderDetail'=>function($query){
            $query->with(['orderItem','orderVariant']);
        },'supplierDetail'])->where('id',$id)->first();
        // echo "<pre>"; print_r($orderItems);exit;
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
            $variants=getVariants();
            $purchaseorderItems= OrderFulfillmentStockOrder::with(['stockOrderDetail'=>function($query){
                $query->with(['orderItem','orderVariant']);
            },'supplierDetail'])->where('id',$purchaseOrderID)->first();
            echo "<pre>";
            print_r($purchaseorderItems);
            echo "</pre>";
            die;

            $dt=[
                'departments' => $departments,
                'suppliers' => $suppliers,
                'variants' => $variants,
                ];

        }
        else{

            return redirect()->back()->with('error', 'ERROR: You Can t Access This Page Now');
        }


    }




}
