<?php

namespace App\Http\Controllers;

use App\Models\OrderFulfillmentSupplier;
use App\Models\OrderFulfillmentSupplierStock;
use App\Models\OrderFulfillmentStockOrder;
use App\Models\OrderFulfillmentDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Zip;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Validator;

class SupplierStockController extends Controller
{

    public function index()
    {
        $departments = OrderFulfillmentDepartment::whereNULL('deleted_at')->get();
        $suppliers = OrderFulfillmentSupplier::whereNULL('deleted_at')->get();

        $dt = [

            'departments' => $departments,
            'suppliers' => $suppliers,

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

        $bills = OrderFulfillmentSupplierStock::select('orderfulfillment_stock_orders.*', 'orderfulfillment_suppliers.name as supplier_name', 'orderfulfillment_departments.name as dept_name', 'orderfulfillment_suppliers.company_name')->whereNULL('orderfulfillment_stock_orders.deleted_at');
        $bills->join('orderfulfillment_suppliers', 'orderfulfillment_stock_orders.supplier_id', '=', 'orderfulfillment_suppliers.id');
        $bills->join('orderfulfillment_departments', 'orderfulfillment_stock_orders.department_id', '=', 'orderfulfillment_departments.id');
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
                if ($col == 'dept') {
                    $colp = 'department_id';
                    $bills->where('orderfulfillment_stock_orders.' . $colp, $search);
                }
            }
        }
        if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            if ($sortColumnName == 'id') {
                $bills->orderBy("orderfulfillment_stock_orders.id", "desc");
            }
            if ($sortColumnName == 'dept') {
                $bills->orderBy("orderfulfillment_stock_orders.department_id", "desc");
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
            $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon edit" data-id="' . $billObj->id . '" title="Edit details">
                            <i class="la la-edit"></i>
                        </a>';
            $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon delete" data-id="' . $billObj->id . '" title="Delete">
                            <i class="la la-trash"></i>
                        </a>';
            $data[] = [
                "id" => $billObj->id,
                "name" => $billObj->supplier_name,
                "company_name" => $billObj->company_name,
                "dept" => $billObj->dept_name,
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
}
