<?php

namespace App\Http\Controllers;

use App\Models\OrderFulfillmentCategory;
use App\Models\OrderFulfillmentPermission;

use Illuminate\Http\Request;
class PermissionController extends Controller
{
    public function index() {
        $categories = OrderFulfillmentCategory::whereNull('deleted_at')->get();
        $dt = [
            'categories' => $categories
        ];
        return view('permissions.list', $dt);
    }

    public function store(Request $request) {
        $id = $request->id;
        $permission = new OrderFulfillmentPermission();
        if($id > 0) {
            $permission = OrderFulfillmentPermission::findOrFail($id);
        }
        $permission->category_id = $request->category_id;
        $permission->name = $request->name;
        $query = $permission->save();
        $return = [
            'status' => 'error',
            'message' => 'Data is not save successfully',
        ];
        if($query) {
            $return = [
                'status' => 'success',
                'message' => 'Permission is save successfully',
            ];
        }
        return response()->json($return);
    }
}
