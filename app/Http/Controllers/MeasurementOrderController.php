<?php

namespace App\Http\Controllers;

use App\Models\OrderFulfillmentBooking;
use App\Models\OrderFulfillmentBookingOrderLog;
use App\Models\OrderFulfillmentBookingOrderItemLog;
use App\Models\OrderFulfillmentUser;
use App\Models\Order;
use Illuminate\Http\Request;
use DB;

class MeasurementOrderController extends Controller
{
    public function index($id)
    {
        $orderDetail= OrderFulfillmentBookingOrderLog::with(['orderdetail'=>function($query){
            $query->with(['orderProducts','orderCategory']);
        }])->where('booking_id',$id)->first();
    // echo "<pre>"; print_r($orderDetail);exit;
        $storeCategoreis = getStoreCategory(true, -1, "", 1);
        if(!empty($orderDetail)){
             $data['orderDetail'] = $orderDetail;
        }
        $data['categories'] = $storeCategoreis;
        return view('measurements.order', $data);
    }

    public function getProductByCategory(Request $request)
    {
        $categoryProducts  = getProductByCategory($request->id, 1);
        if (!($categoryProducts->isEmpty())) {
            $dt = ['status' => 'success', 'products' => $categoryProducts];
            return response()->json($dt);
        }
    }

    public function getProductMinPrices(Request $request)
    {
        $parameterPrices  = DB::table('products')->whereNull('deleted_at')->where('id', $request->id)->select('min_order_length', 'min_order_width')->first();
        if (!empty($parameterPrices)) {
            $dt = ['status' => 'success', 'price' => $parameterPrices];
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

    public function storeMeasurementOrder(Request $request)
    {
        $bookingData  = OrderFulfillmentBooking::where('id', $request->booking_id)->first();
        if (!empty($bookingData)) {
            $store_id = 1;
            $order = new OrderFulfillmentBookingOrderLog;
            $order->booking_id = $bookingData->id;
            $order->store_id = $store_id;
            $order->name = $bookingData->first_name . ' ' . $bookingData->last_name;
            $order->email = $bookingData->email;
            $order->phone = $bookingData->phone_number;
            $order->total_price = $request->order_total_price;
            $order->paid_amount = $request->paid_price;
            $order->address = $bookingData->address;
            $order->zip_code = $request->post_code;
            $price_percentage = ($request->paid_price / $request->order_total_price) * 100;
            if ($request->order_total_price == $request->paid_price) {
                $order->payment_type = 'full';
            } else {
                $order->payment_type = 'partial';
            }
            $order->paid_percentage = $price_percentage;
            $order->save();
            $orderId = $order->id;
            $cateogry_id = $request->category_id;
            $product_id = $request->product_id;
            $order_qty = $request->order_qty;
            $measurement = $request->measurement;
            $length = $request->length;
            $width = $request->width;
            $fitting = $request->fitting;
            $fitting_option = $request->fitting_option;
            $side_control = $request->side_control;
            $chain_color = $request->chain_color;
            $order_qty = $request->order_qty;
            $customer_note = $request->customer_note;
            $order_price = $request->order_price;
            if (!empty($orderId)) {
                $orderArr = [];
                foreach ($product_id as $key => $productArr) {
                    $orderArr[] = [
                        'order_id' => $orderId,
                        'product_id' => $productArr,
                        'category_id' => $cateogry_id[$key],
                        'dimension' => $length[$key] . 'x' . $width[$key],
                        'fitting_type' => $fitting[$key],
                        'fitting_option' => !empty($fitting_option[$key]) ? $fitting_option[$key] : NULL,
                        'side_control' => $side_control[$key],
                        'chain_color' => $chain_color[$key],
                        'qty' => $order_qty[$key],
                        'scale' => $measurement[$key],
                        'price' => $order_price[$key],

                    ];
                }

                $orderItemId = OrderFulfillmentBookingOrderItemLog::insert($orderArr);
                if (!empty($orderItemId)) {
                    $return = ['status' => 'success', 'message' => 'Your order submitted successfully!'];
                } else {
                    $return = ['status' => 'error', 'message' => 'Sorry Your order not submitted!'];
                }
                return response()->json($return);
            }
        }
    }
}
