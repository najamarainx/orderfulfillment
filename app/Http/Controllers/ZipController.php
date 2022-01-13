<?php

namespace App\Http\Controllers;

use App\Models\OrderFulfillmentCategory;
use App\Models\OrderFulfillmentPackagingUser;
use App\Models\OrderFulfillmentBooking;
use App\Models\OrderFulfillmentTimeSlot;
use App\Models\OrderFulfillmentUserZipCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Zip;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Validator;

class ZipController extends Controller
{
    public function index()
    {
        $totalItems = DB::table('orderfulfillment_zip_codes')->whereNull('deleted_at')->count();
        
        return view('zips.list',compact('totalItems'));
    }

    public function getZipcodesDropdownList()
    {
        $zipcodes = getZipCode(-1);
        if (!($zipcodes->isEmpty())) {
            $response['Status'] = 'success';
            $response['key'] = '200';
            $response['zipcodes'] = $zipcodes;
        } else {
            $response['Status'] = 'error';
            $response['key'] = '400';
            $response['message'] = 'No Post code found';
        }
        return response()->json($response, $response['key']);
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

        $userId = auth()->user()->id;
        $charges = DB::table('orderfulfillment_zip_codes');
        $charges->where('deleted_at', NULL);

        foreach ($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if ($search != "") {

                if ($col == 'Name') {
                    $col1 = 'name';
                    $charges->where($col1, 'like', '%' . $search . '%');
                }
            }
        }
        if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            if ($sortColumnName == 'Sr') {
                $charges->orderBy("id", "desc");
            }
            if ($sortColumnName == 'created_at') {
                $charges->orderBy("created_at", "desc");
            }
        } else {
            $charges->orderBy("name", "desc");
        }
        $iTotalRecords = $charges->count();
        $charges->skip($start);
        $charges->take($length);
        $chargesData = $charges->get();
        $data = [];
        $i = 1;
        foreach ($chargesData as $chargesObj) {
            $action = "";
            $action .= '<a href="' . url('user-time-slot/detail') . '/' . $chargesObj->id . '" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3 preview" data-id="' . $chargesObj->id . '">
            <i class="la la-eye"></i>';
            $action .= '<a href="javascript:;" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3 edit" data-id="' . $chargesObj->id . '">
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

            $action .= '<a href="javascript:;" class="btn btn-icon btn-light btn-hover-primary btn-sm delete" data-id="' . $chargesObj->id . '" title="Delete">
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
                "Sr" => $i,
                "Name" => $chargesObj->name,
                "created_at" => Carbon::create($chargesObj->created_at)->format(config('app.date_time_format', 'M j, Y, g:i a')),
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
            'name' => 'required|max:150',

        ];

        $validator = Validator::make($validateInput, $rules);
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

            $zip = new Zip();
            if ($id > 0) {
                $zip = Zip::findOrFail($id);
            }

            $zip->name = $request->name;
            $zip->created_by = Auth::user()->id;
            $query = $zip->save();
            $return = [
                'status' => 'error',
                'message' => 'Post code is not save successfully',
            ];
            if ($query) {
                $return = [
                    'status' => 'success',
                    'message' => 'Post code is save successfully',
                    'zipId' => $zip->id,
                ];
            }
        }

        return response()->json($return);
    }

    public function getZipById(Request $request)
    {
        $id = $request->id;
        $zip = Zip::where('id', $id)->first();
        $return = [
            'status' => 'success',
            'data' => $zip,

        ];
        if (empty($zip)) {
            $return = [
                'status' => 'error',
                'message' => 'Data not found for edit',

            ];
        }
        return response()->json($return);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $res = Zip::find($id);
        if ($res) {
            $res->delete();
            return response()->json(['status' => 'success', 'message' => 'Post code is deleted successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Post code not deleted ']);
        }
    }

    public function getZipCodeTimeSlots(Request $request)
    {
        if (!empty($request->zip_code_id)) {
            $date = Carbon::parse($request->date)->format('Y-m-d');
            $userId   = getUsersByZip($request->zip_code_id);
            $userIDs= $userId->pluck('id')->toArray();
            $timeSlotId = DB::table('orderfulfillment_user_time_slot_assigns')->whereIn('user_id', $userIDs)->whereNull('deleted_at')->pluck('time_slot_id')->toArray();
            $timeSlotDetail = OrderFulfillmentTimeSlot::whereIn('id', $timeSlotId)->get();
            $timeSlots = [];
            foreach($timeSlotDetail as $key => $timeSlotObj){
                $booking = OrderFulfillmentBooking::whereDate('date', $date)->where(['time_slot_id'=> $timeSlotObj->id,'zip_code_id'=>$request->zip_code_id]);
                $totalBooking = $booking->count();
                $timeSlots[]=array(
                    'slot_id'=> $timeSlotObj->id,
                    'booking_from_time' => date('g:i a',strtotime($timeSlotObj->booking_from_time)),
                    'booking_to_time' => date('g:i a',strtotime($timeSlotObj->booking_to_time)),
                );
                if(count($userId) <= $totalBooking) {
                    $timeSlots[$key]['booked'] = 'disabled';
                }else{
                    $timeSlots[$key]['booked'] = '';
                }
            }
            if (!($timeSlotDetail->isEmpty())) {
                $response['status'] = 'success';
                $response['timeSlotDetail'] = $timeSlots;
            } else {
                $response['timeSlotDetail'] = '';
            }
            return response()->json($response);
        }
    }
}
