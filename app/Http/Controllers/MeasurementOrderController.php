<?php

namespace App\Http\Controllers;

use App\Models\OrderFulfillmentBooking;
use App\Models\OrderFulfillmentUser;
use Illuminate\Http\Request;
use DB;
class MeasurementOrderController extends Controller
{
    public function index(){
        $storeCategoreis = getStoreCategory(true,-1,"",1);
        $dt = ['categories'=>$storeCategoreis];
        return view('measurements.order',$dt);
    }

    public function getProductByCategory(Request $request){
       $categoryProducts  = getProductByCategory($request->id,1);
       if(!($categoryProducts->isEmpty())){
           $dt = ['status'=>'success','products'=>$categoryProducts];
           return response()->json($dt);
       }
    }

    public function getProductMinPrices(Request $request){
       $parameterPrices  = DB::table('products')->whereNull('deleted_at')->where('id',$request->id)->select('min_order_length','min_order_width')->first();
       if(!empty($parameterPrices)){
           $dt = ['status'=>'success','price'=>$parameterPrices];
           return response()->json($dt);
       }
    }
    public function getProductQuote($productID, Request $request)
    {
        $storeId = 1;
        $store = DB::table('stores')->where('id', $storeId)->where('deleted_at', '=', NULL)->first();
        $productIDs = getContractProducts($store->contract_id);
        if (!empty($store) && in_array($productID, $productIDs)) {
            $productInfo = getProductByID($productID, $store->contract_id, '-1', $store->id);
            //echo "<pre>";print_r($productInfo);exit;
            $width = $request->width;
            $height = $request->length;
            $minorderheight = $request->min_length;
            $minorderwidth = $request->min_width;

            if ($request->measure == 'cm') {
                $width = $request->width_measure / 2.54;
                $height = $request->height_measure / 2.54;
            }
            if ($request->measure == 'mm') {
                $width = $request->width_measure / 25.4;
                $height = $request->height_measure / 25.4;
            }
            if ($width >= $minorderwidth && $height >= $minorderheight) {
                $result = calculateProductQuote($productID, $width, $height);
                if ($result) {
                    $bandPrice = $result->price;
                    $additionalCharges = getProductAdditionalCharges($productID, $store->id);
                    //echo "<pre>";print_r($bandPrice);exit;
                    $contractDiscount = $productInfo->discount;
                    $scale = $request->measure;
                    $totalPrice = overallProductPrice($bandPrice, $additionalCharges, $contractDiscount);
                    return response()->json(['status' => 'success', 'price' => $totalPrice]);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'we can\'t make this product in those sizes']);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => 'we can\'t make this product in those sizes']);
            }

        } else {
            return response()->json(['status' => 'error', 'message' => 'you can\'t access this store product price']);
        }

    }

    public function storeMeasurementOrder(Request $request){
      $bookingData  = OrderFulfillmentBooking::where('id',$request->booking_id)->first();
       if(!empty($bookingData)){
           $store_id =1;
          $order = new Order;
          $order->booking_id = $bookingData->id;
          $order->store_id = $store_id;
          $order->name = $bookingData->first_name . ' '. $bookingData->last_name;
          $order->email = $bookingData->email;
          $order->phone_number = $bookingData->phone_number;
          $order->total_price = $request->order_total_price;
          $order->paid_amount = $request->paid_price;
          $order->address = $request->address;
          $order->zip_code = $request->post_code;
          $price_percentage = ($request->paid_price / 100) * $request->order_total_price;
          if($request->order_total_price == $request->paid_price){
              $order->payment_type = 'full';
          }else{
            $order->payment_type = 'partial';
          }
          $order->paid_percentage = $price_percentage;

       }
    }
}
