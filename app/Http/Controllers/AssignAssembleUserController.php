<?php

namespace App\Http\Controllers;

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

        return view('tasks.list');
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
        $sql = OrderFulfillmentAssignAssembleUser::select('orderfulfillment_assigned_tasks.*','orderfulfillment_users.name as assigned_to','ab.name as assigned_from');
        $sql->join('orders','orders.id',' orderfulfillment_assigned_tasks.order_id');
        $sql->join('orderfulfillment_users','orderfulfillment_assigned_tasks.user_id',' orderfulfillment_users.id');
        $sql->join('orderfulfillment_users as ab','orderfulfillment_assigned_tasks.added_by',' ab.id');
        $sql->where('orderfulfillment_users.type','assembler');
        $sql->whereNULL('orders.deleted_at');
        $sql->whereNULL('orderfulfillment_assigned_tasks.deleted_at');
        $sql->whereNULL('orderfulfillment_users.deleted_at');

        foreach ($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if ($search != "") {
                if ($col == 'date') {
                    $col = "orderfulfillment_sale_logs.updated_at";
                    $sql->Where($col, 'like', '%' . $search . '%');

                    // $sql->where($col, $search);
                }
                if ($col == 'department_id') {
                    $col = "orderfulfillment_sale_logs.department_id";
                    $sql->where($col, $search);
                }
                if ($col == 'status') {
                    $col = "orderfulfillment_sale_logs.status";
                    $sql->where($col, $search);
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
            if($orderObj->status=='pending' || Auth::user()->type == 'production_manager' || Auth::user()->type == 'team_lead'){
                $action .= '<a href="javascript:;" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3 assign_task" data-id="' . $orderObj->id . '">
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



            $data[] = [
                "id" => $orderObj->id,
                "department_id" =>$orderObj->department_name,
                "item_id" =>$orderObj->item_name,
                "variant_id"=>$orderObj->variant_name,
                "qty"=>$orderObj->qty,
                "status"=>'<span class="badge badge-success badge-pill" style="cursor:pointer">' . $orderObj->status . '</span>',
                "date"=>Carbon::create($orderObj->updated_at)->format(config('app.date_time_format', 'M j, Y, g:i a')),
                "assigned"=>ucfirst($orderObj->assigned_user),
                "action"=>$action
            ];
        }

        $records["data"] = $data;
        $records["draw"] = $draw;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        echo json_encode($records);
    }






}
