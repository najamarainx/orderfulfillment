<?php

namespace App\Http\Controllers;

use App\Models\OrderFulfillmentTimeSlot;
use App\Models\OrderFulfillmentBookingAssign;
use App\Models\OrderFulfillmentBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;

class MeasurementBookingController extends Controller
{
    public function index()
    {
        $category  = getCategory('product', -1, true);
        $data['categories'] = $category;
        return view('bookings.task', $data);
    }

    public function getList(Request $request)
    {
        $type =  Auth::user()->type;
        $records = [];
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $sortColumnIndex = $request->order[0]['column']; // Column index
        $sortColumnName = $request->columns[$sortColumnIndex]['data']; // Column name
        $sortColumnName = 'orderfulfillment_bookings.id'; // Column name
        $sortColumnSortOrder = $request->order[0]['dir']; // asc or desc
        $columns = $request->columns;

        $booking = DB::table('orderfulfillment_bookings')->select('orderfulfillment_bookings.*', 'booking_assign.date as assign_date', 'booking_assign.assign_status', 'booking_assign.booking_id', 'booking_assign.id as assign_id', 'ots.booking_from_time', 'ots.booking_to_time')->whereNull('orderfulfillment_bookings.deleted_at')->leftJoin('orderfulfillment_time_slots as ots', 'orderfulfillment_bookings.time_slot_id', 'ots.id')->whereNull('ots.deleted_at');
        $booking->join('orderfulfillment_booking_assigns as booking_assign', 'orderfulfillment_bookings.id', 'booking_assign.booking_id')->whereNULL('booking_assign.deleted_at');
        $booking->whereIn('orderfulfillment_bookings.booking_status', ['confirmed', 'rescheduled']);

        // if ($request->status == 'confirmed') {
        //     $booking->whereIn('orderfulfillment_bookings.booking_status', ['confirmed', 'rescheduled']);
        // }
        //  else {
        //     $booking->whereIn('orderfulfillment_bookings.booking_status', ['not called', 'not respond', 'cancelled']);
        // }
        foreach ($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if ($search != "") {
                if ($col == 'date') {
                    $col = "booking_assign.date";
                    $booking->where($col, $search);
                }
                if ($col == 'category_id') {
                    $col = "orderfulfillment_bookings.category_id";
                    $booking->where($col, $search);
                }
                if ($col == 'phone_number') {
                    $col = "orderfulfillment_bookings.phone_number";
                    $booking->where($col, 'like', '%' . $search . '%');
                }
                if ($col == 'assign_status') {
                    $col = "booking_assign.assign_status";
                    $booking->where($col, $search);
                }
                if ($col == 'first_name') {
                    $col1 = 'orderfulfillment_bookings.first_name';
                    $col2 = 'orderfulfillment_bookings.last_name';
                    $booking->Where($col1, 'like', '%' . $search . '%');
                    $booking->orWhere($col2, 'like', '%' . $search . '%');
                }
            }
        }
        if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            $booking->orderBy($sortColumnName, $sortColumnSortOrder);
        } else {
            $booking->orderBy("orderfulfillment_bookings.id", "desc");
        }
        $iTotalRecords = $booking->count();
        $booking->skip($start);
        $booking->take($length);
        $bookingData = $booking->get();
        $data = [];
        foreach ($bookingData as $bookingObj) {
            $categoryName = "";
            if ($bookingObj->category_id != "") {

                $category = DB::table('categories')->whereNull('deleted_at')->find($bookingObj->category_id);
                $categoryName = $category->name;
            }
            $action = "";
            if ($request->status == 'confirmed' && $bookingObj->assign_status!='pending') {
                $action .= '<a href="' . url('booking-order/create_order') . '/' . $bookingObj->booking_id . '" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                <span class="svg-icon svg-icon-md svg-icon-primary">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                            <rect fill="#000000" opacity="0.3" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000) " x="7.5" y="7.5" width="2" height="9" rx="1"></rect>
                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997) "></path>
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
            </a>';

            }
            if ($request->status == 'confirmed') {
                $action .= '<a  href="' . url('booking-task/detail') . '/' . $bookingObj->assign_id . '/' . $bookingObj->booking_id . '"  class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3 preview" data-id="1">
                <i class="la la-eye"></i>
            </a>';
            }
            $data[] = [
                "id" => $bookingObj->id,
                "date" => Carbon::parse($bookingObj->assign_date)->format('Y-m-d'),
                "time_slot" => Carbon::create($bookingObj->booking_from_time)->format('H:ia') . ' ' . Carbon::create($bookingObj->booking_to_time)->format('H:ia'),
                "category_id" => $categoryName,
                "first_name" => $bookingObj->first_name . ' ' . $bookingObj->last_name,
                "phone_number" => $bookingObj->phone_number,
                "booking_status" =>  '<span class="badge badge-success badge-pill booking_status" style="cursor:pointer" data-id="' . $bookingObj->id . '">' . $bookingObj->booking_status . '</span>',
                "assign_status" => '<span class="badge badge-success badge-pill booking_assign_status" style="cursor:pointer" data-id="' . $bookingObj->assign_id . '">' . $bookingObj->assign_status . '</span>',
                "action" => $action
            ];
        }
        $records["data"] = $data;
        $records["draw"] = $draw;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        echo json_encode($records);
    }

    public function updateAssignBookingStatus(Request $request)
    {
        $query  = OrderFulfillmentBookingAssign::where('id', $request->assign_id)->update(['assign_status' => $request->booking_status]);
        $return = [
            'status' => 'success',
            'message' => 'Status updated successfully!'
        ];
        if (empty($query)) {
            $return = [
                'status' => 'success',
                'message' => 'sorry we cannot udpate'
            ];
        }
        return response()->json($return);
    }
    public function bookingDetail($assignId, $id)
    {

        $bookingDetail  = OrderFulfillmentBooking::with(['bookingDetail' => function ($q) use ($assignId) {
            $q->with(['assignedUser', 'bookedUser']);
            $q->where('id', $assignId);
        }, 'bookingCategory', 'bookingSlot','bookingOrder'=>function($order) use($id){
               $order->where('payment','verified');
               $order->where('paid_percentage','>=','40');
               $order->where('booking_id',$id);
               $order->whereNull('deleted_at');
               $order->with(['orderdetail'=>function($orderItem){
                   $orderItem->with(['productDetail']);
                    $orderItem->whereNull('deleted_at');
               }]);
        }])->where('orderfulfillment_bookings.id', $id)->first();
        echo "<pre>"; print_r($bookingDetail);exit;

        if (
            !empty($bookingDetail) && !empty($bookingDetail->bookingDetail)
            && !empty($bookingDetail->bookingDetail->assignedUser)
            && !empty($bookingDetail->bookingDetail->bookedUser)
        ) {
            $dt = ['bookingDetail' => $bookingDetail];
            return view('bookings.preview', $dt);
        } else {
            abort(404);
        }
    }
}
