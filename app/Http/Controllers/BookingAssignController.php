<?php

namespace App\Http\Controllers;

use App\Models\OrderFulfillmentTimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
class BookingAssignController extends Controller
{
    public function index(){
        $category  = getCategory('product', -1, true);
        $timeSlotDetail = OrderFulfillmentTimeSlot::where('status', 'active')->get();
        $zipCode  = getZipCode();
        $statusArray = getBookingStatus();
        $date = Carbon::now()->format('Y-m-d');
        $dt = [
            'date' => $date,
            'timeSlotDetail' => $timeSlotDetail,
            'userId' => ['']

        ];
        $timeSlotHtml = View::make('template.booking-slots', $dt)->render();
        $data['timeSlotHtml'] = $timeSlotHtml;
        $data['statusArray'] = $statusArray;

        $data['categories'] = $category;
        $data['zipCode'] = $zipCode;
        return view('bookings.task', $data);
    }
}
