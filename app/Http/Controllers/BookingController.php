<?php

namespace App\Http\Controllers;

use App\Models\OrderFulfillmentTimeSlot;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
class BookingController extends Controller
{
    public function index(){
        $category  = getCategory('product',-1,true);
        $timeSlotDetail = OrderFulfillmentTimeSlot::where('status', 'active')->get();
        $date = Carbon::now()->format('Y-m-d');
        $dt = [
            'date' => $date,
            'timeSlotDetail' => $timeSlotDetail
        ];
        $timeSlotHtml = View::make('template.booking-slots', $dt)->render();
        $data['timeSlotHtml'] = $timeSlotHtml;

        $data['categories'] = $category;
        return view('bookings.list',$data);
    }
}
