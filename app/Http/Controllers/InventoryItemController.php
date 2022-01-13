<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\Models\OrderFulfillmentItem;
use App\Models\OrderFulfillmentVariant;
use App\Models\OrderFulfillmentInventoryItem;
class InventoryItemController extends Controller
{
    //
    public function index(){
        $departments = getDepartment(-1, true);
        $items  = OrderFulfillmentItem::whereNull('deleted_at')->get();
        $variants  = OrderFulfillmentVariant::whereNull('deleted_at')->get();
        $inventoryItem = DB::table('orderfulfillment_inventory_items as oiitem')
        ->leftJoin('orderfulfillment_departments as d','oiitem.department_id','d.id')
        ->leftJoin('orderfulfillment_items as i','oiitem.item_id','i.id')
        ->leftJoin('orderfulfillment_variants as ov','oiitem.variant_id','ov.id')
        ->select('i.name as item_name','d.name as department_name','ov.name as variant_name','oiitem.qty as orderItem_qty','oiitem.id as orderInventory_id')
        ->whereNull('d.deleted_at')
        ->whereNull('i.deleted_at')
        ->whereNull('ov.deleted_at')
        ->whereNull('oiitem.deleted_at');
        $dt = ['departments' => $departments,'items'=>$items,'variants'=>$variants,'totalItems'=>$inventoryItem->count()];

        return View('inventory.list',$dt);
    }

    public function getList(Request $request)
    {
        $records = [];
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $sortColumnIndex = $request->order[0]['column']; // Column index
        $sortColumnName = $request->columns[$sortColumnIndex]['data']; // Column name
        $sortColumnName = 'oiitem.id';
        $sortColumnSortOrder = $request->order[0]['dir']; // asc or desc
        $columns = $request->columns;

        $inventoryItem = DB::table('orderfulfillment_inventory_items as oiitem')
        // ->leftJoin('orderfulfillment_stock_orders as order_stock','oiitem.department_id','order_stock.department_id')
        // ->leftJoin('orderfulfillment_stock_order_items as order_stock_item','order_stock.id','order_stock_item.stock_order_id')
        ->leftJoin('orderfulfillment_departments as d','oiitem.department_id','d.id')
        ->leftJoin('orderfulfillment_items as i','oiitem.item_id','i.id')
        ->leftJoin('orderfulfillment_variants as ov','oiitem.variant_id','ov.id')
        ->select('i.name as item_name','d.name as department_name','ov.name as variant_name','oiitem.qty as orderItem_qty','oiitem.id as orderInventory_id')
        ->whereNull('d.deleted_at')
        ->whereNull('i.deleted_at')
        ->whereNull('ov.deleted_at')
        ->whereNull('oiitem.deleted_at');
        foreach ($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if ($search != "") {
                if ($col == 'department') {
                    $col = 'oiitem.department_id';
                    $inventoryItem->where($col, $search);
                }
                if ($col == 'item') {
                    $col = 'oiitem.item_id';
                    $inventoryItem->where($col, $search);
                }
                if ($col == 'variant') {
                    $col = 'oiitem.variant_id';
                    $inventoryItem->where($col, $search);
                }
                if ($col == 'created_at') {
                    $dateArr = explode('|', $search);
                    $dateFrom = Carbon::create($dateArr[0] . " 00:00:00")->format('Y-m-d H:i:s');
                    $dateTo = Carbon::create($dateArr[1] . " 23:59:59")->format('Y-m-d H:i:s');
                    $inventoryItem->whereBetween('created_at', [$dateFrom, $dateTo]);
                }
            }
        }
        if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            $inventoryItem->orderBy($sortColumnName, $sortColumnSortOrder);
        } else {
            $inventoryItem->orderBy("oiitem.id", "desc");
        }
        $iTotalRecords = $inventoryItem->count();
        $inventoryItem->skip($start);
        $inventoryItem->take($length);
        $inventoryItemData = $inventoryItem->get();
        $data = [];
        foreach ($inventoryItemData as $inventoryItemObj) {



            $data[] = [
                "id" => $inventoryItemObj->orderInventory_id,
                "department" => $inventoryItemObj->department_name,
                "item" => $inventoryItemObj->item_name,
                "variant" => $inventoryItemObj->variant_name,
                "qty" => $inventoryItemObj->orderItem_qty,
            ];
        }

        $records["data"] = $data;
        $records["draw"] = $draw;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        echo json_encode($records);
    }
}
