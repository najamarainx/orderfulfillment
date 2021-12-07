<?php

namespace App\Http\Controllers;
use App\Models\OrderFulfillmentUserZipCode;
use App\Models\OrderFulfillmentTimeSlot;
use App\Models\OrderFulfillmentUserTimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Zip;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Validator;

class UserTimeSlotController extends Controller
{
    public function index($zipID)
    {
        //$slots = OrderFulfillmentTimeSlot::get();
        $usersBYZipCode = getUsersByZip($zipID);
        $userTimeSlots=getUserTimeSlots($zipID);
        $slots=OrderFulfillmentTimeSlot::with(['slot_users'=>function($qry) use ($zipID){
            $qry->where('zip_code_id',$zipID);
            $qry->whereNULL('deleted_at');

        }])->get();
        $dt = [

            'zip_id'=>$zipID,
            'slots'=>$slots,
            'usersBYZipCode'=>$usersBYZipCode,
            'userTimeSlots'=>$userTimeSlots,

        ];
        return view('zips.user_time_slot', $dt);

    }

    public function store(Request $request)
    {

       $time_slots=$request->time_slot;
       $user_zips=$request->user_zip;
       $userzipCodes=array();
       if(!empty($time_slots)){
           foreach($time_slots as $key=>$time_slot) {
               if (!empty($time_slots[$key]) ) {
                   foreach ($user_zips[$key] as $v => $check) {
                       if(!empty($check)) {
                           $userzipCodes[] = array(
                               'time_slot_id' => $time_slot,
                               'zip_code_id' => $request->id,
                               'user_id' => $check,
                               'created_by' => Auth::user()->id,
                               'created_at' => Carbon::now()->format("Y-m-d H:i:s"),
                           );
                       }
                   }
               }
           }
       }

       if(!empty($userzipCodes)){
           $res = OrderFulfillmentUserTimeSlot::where('zip_code_id',$request->id)->first();
           if($res){
               OrderFulfillmentUserTimeSlot::where('zip_code_id',$request->id)
                   ->update(['deleted_at' =>  Carbon::now()->format("Y-m-d H:i:s")]);
           }

           $query = OrderFulfillmentUserTimeSlot::insert($userzipCodes);
           if($query){
               $return = [
                   'status' => 'success',
                   'message' => 'assigned slot users is  successfully',
               ];
           }
       }else {
           $return = [
               'status' => 'error',
               'message' => 'something wrong please try again!',
           ];
       }
       return response()->json($return);

    }



}
