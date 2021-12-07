<?php

namespace App\Http\Controllers;

use App\Models\OrderFulfillmentTimeSlot;
use App\Models\OrderFulfillmentBooking;
use App\Models\OrderFulfillmentCategory;
use App\Models\OrderFulfillmentUserZipCode;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use DB;
class BookingController extends Controller
{
    public function index()
    {
        $category  = getCategory('product', -1, true);
        $timeSlotDetail = OrderFulfillmentTimeSlot::where('status', 'active')->get();
        $zipCode  = getZipCode();
        $date = Carbon::now()->format('Y-m-d');
        $dt = [
            'date' => $date,
            'timeSlotDetail' => $timeSlotDetail,
            'userId'=>['']

        ];
        $timeSlotHtml = View::make('template.booking-slots', $dt)->render();
        $data['timeSlotHtml'] = $timeSlotHtml;

        $data['categories'] = $category;
        $data['zipCode'] = $zipCode;
        return view('bookings.list', $data);
    }
    public function getList(Request $request)
    {
        $records = [];
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $sortColumnIndex = $request->order[0]['column']; // Column index
        $sortColumnName = $request->columns[$sortColumnIndex]['data']; // Column name
        $sortColumnName = 'orderfulfillment_bookings.id'; // Column name
        $sortColumnSortOrder = $request->order[0]['dir']; // asc or desc
        $columns = $request->columns;

        $booking = DB::table('orderfulfillment_bookings')->select('orderfulfillment_bookings.*','ots.booking_from_time','ots.booking_to_time')->whereNull('orderfulfillment_bookings.deleted_at')->leftJoin('orderfulfillment_time_slots as ots','orderfulfillment_bookings.time_slot_id','ots.id')->whereNull('ots.deleted_at');
        if($request->status=='confirmed'){
            $booking->whereIn('orderfulfillment_bookings.booking_status', ['confirmed','rescheduled']);
        }
        else{
            $booking->whereIn('orderfulfillment_bookings.booking_status', ['not called','not respond','cancelled']);
        }
        foreach ($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if ($search != "") {
                if ($col == 'id') {
                    $booking->where($col, $search);
                }
                if ($col == 'category_id') {
                    $booking->where($col, $search);
                }
                if ($col == 'name') {
                    $booking->where($col, 'like', '%' . $search . '%');
                }
                if ($col == 'created_at') {
                    $dateArr = explode('|', $search);
                    $dateFrom = Carbon::create($dateArr[0] . " 00:00:00")->format('Y-m-d H:i:s');
                    $dateTo = Carbon::create($dateArr[1] . " 23:59:59")->format('Y-m-d H:i:s');
                    $booking->whereBetween('created_at', [$dateFrom, $dateTo]);
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
                $category = OrderFulfillmentCategory::find($bookingObj->category_id);
                $categoryName = $category->name;
            }
            $action = "";
            $action .= '<a href="javascript:;" class="btn btn-icon btn-light btn-hover-primary btn-sm assign_permission" data-id="' . $bookingObj->id . '">
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
            $action .= '<a href="javascript:;" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3 edit" data-id="' . $bookingObj->id . '">
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
            $action .= '<a href="javascript:;" class="btn btn-icon btn-light btn-hover-primary btn-sm delete" data-id="' . $bookingObj->id . '" title="Delete">
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

            $data[] = [
                "id" => $bookingObj->id,
                "date" => Carbon::parse($bookingObj->date)->format('Y-m-d'),
                "time_slot" => Carbon::create($bookingObj->booking_from_time)->format('H:ia').' '. Carbon::create($bookingObj->booking_to_time)->format('H:ia'),
                "category_id" => $categoryName,
                "first_name" => $bookingObj->first_name . ' '. $bookingObj->last_name,
                "phone_number" => $bookingObj->phone_number,
                "email" =>  '<span class="badge badge-success badge-pill booking_status" style="cursor:pointer" data-id="' . $bookingObj->id . '">'.$bookingObj->booking_status.'</span>',
                "action" => $action
            ];
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
        if(!empty($id)){
          $booking = OrderFulfillmentBooking::find($id);
        }
        $booking = new OrderFulfillmentBooking();
        $booking->category_id = $request->category_id;
        $booking->date = $request->date;
        $booking->time_slot_id = $request->time_slot;
        $booking->zip_code_id = $request->zip_code;
        $customerName = explode(" ", $request->customer_name);
        $booking->first_name = $customerName[0];
        $booking->last_name = $customerName[1];
        $booking->email = $request->customer_email;
        $booking->phone_number = $request->customer_no;
        $booking->post_code = $request->customer_post_code;
        $booking->address = $request->customer_address;
        // $booking->message = $request->message;
        $booking->save();
        $return = [
            'status' => 'success',
            'message' => 'You booking is added successfully we will contact you soon',
        ];
        return response()->json($return);
    }

    public function getTimeSlotByZipCode(Request $request){

    $userId   = OrderFulfillmentUserZipCode::where('zip_id',$request->zipCode)->whereNull('deleted_at')->pluck('user_id')->toArray();
    $timeSlotId = DB::table('orderfulfillment_user_time_slot_assigns')->whereIn('user_id',$userId)->whereNull('deleted_at')->pluck('time_slot_id')->toArray();
    $timeSlotDetail = OrderFulfillmentTimeSlot::whereIn('id',$timeSlotId)->get();
        if(!($timeSlotDetail->isEmpty())){
            $date = Carbon::now()->format('Y-m-d');
            $dt = [
                 'date' => $date,
                 'timeSlotDetail' => $timeSlotDetail,
                 'userId'=>$userId,
                 'zipCode'=>$request->zipCode,
                 'date'=>$request->date
            ];
            $timeSlotHtml = View::make('template.booking-slots', $dt)->render();
            $data['timeSlotHtml'] = $timeSlotHtml;
            $result = ['status'=>'success','timeSlotHtml'=>$timeSlotHtml];
        }else{
            $result = ['status'=>'error','message'=>'Something went wrong'];
        }
        return response()->json($result);
    }
    public function destroy(Request $request){
        $id = $request->id;
        if ($id) {
            DB::table('orderfulfillment_bookings')
                ->where('id', $id)
                ->update(['deleted_at' => Carbon::now()->format('Y-m-d H:i:s')]);
            return response()->json(['status' => 'success', 'message' => 'Booking is deleted successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Booking not deleted beacuse it is assigned']);
        }
    }

    public function getBookingById(Request $request){
        $id = $request->id;
        $booking = OrderFulfillmentBooking::where('id', $id)->first();
        $return = [
            'status' => 'success',
            'data' => $booking
        ];
        if (empty($booking)) {
            $return = [
                'status' => 'error',
                'message' => 'Data not found for edit'
            ];
        }
        return response()->json($return);
    }

    public function confirmedBookings()
    {
        $category  = getCategory('product', -1, true);
        $timeSlotDetail = OrderFulfillmentTimeSlot::where('status', 'active')->get();
        $zipCode  = getZipCode();
        $date = Carbon::now()->format('Y-m-d');
        $dt = [
            'date' => $date,
            'timeSlotDetail'=>$timeSlotDetail,
            'userId'=>['']

        ];
        $timeSlotHtml = View::make('template.booking-slots', $dt)->render();
        $data['timeSlotHtml'] = $timeSlotHtml;

        $data['categories'] = $category;
        $data['zipCode'] = $zipCode;
        return view('bookings.confirmed_list', $data);
    }






}
