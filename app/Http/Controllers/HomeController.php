<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderFulfillmentBooking;
use App\Models\OrderFulfillmentUser;
use App\Models\Order;
use App\Models\OrderFulfillmentDepartment;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $booking = OrderFulfillmentBooking::whereNull('deleted_at');
        if(Auth::user()->type != 'super_admin' || Auth::user()->type != 'developer' ){
            $booking->orWhere('created_by',Auth::user()->id);
        }
        $data['totalBookings']  =  $booking->count();

        $user= OrderFulfillmentUser::whereNull('deleted_at');
        if(Auth::user()->type != 'super_admin' || Auth::user()->type != 'developer' ){
            $booking->orWhere('added_by',Auth::user()->id)->where('type',Auth::user()->type);
        }
        $data['totalUsers']  = $user->count();
        $data['totalOrders'] = Order::whereNull('deleted_at')->count();
        $data['totalDepartments'] = OrderFulfillmentDepartment::whereNull('deleted_at')->count();
        return view('home',$data);
    }
}
