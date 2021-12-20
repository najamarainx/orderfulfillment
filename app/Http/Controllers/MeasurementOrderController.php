<?php

namespace App\Http\Controllers;

use App\Models\OrderFulfillmentBooking;
use App\Models\OrderFulfillmentBookingOrderLog;
use App\Models\OrderFulfillmentBookingOrderItemLog;
use App\Models\OrderFulfillmentUser;
use App\Models\Order;
use App\Models\OrderFulfillmentBookingAssign;
use App\Models\OrderFulfillmentItem;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Auth;

class MeasurementOrderController extends Controller
{
    public function index($id)
    {
        $orderDetail =  OrderFulfillmentBookingOrderLog::where('booking_id', $id)->whereNull('deleted_at')->first();
        if (isset($orderDetail)  && $orderDetail->is_verified == 1) {
            return redirect()->back()->with('error', 'Order submitted now it can t be edited');
        } else {
            $orderDetail = OrderFulfillmentBookingOrderLog::with(['orderdetail' => function ($query) {
                $query->with(['orderProducts', 'orderCategory']);
                $query->whereNull('deleted_at');
            }])->whereNull('deleted_at')->where('booking_id', $id)->first();
            $storeCategoreis = getStoreCategory(true, -1, "", 1);
            if (!empty($orderDetail)) {
                $data['orderDetail'] = $orderDetail;
            }
            $data['categories'] = $storeCategoreis;
            return view('measurements.order', $data);
        }
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
        if (!empty($store) && !empty($productID) && in_array($productID, $productIDs)) {
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
        $orderId = $request->order_id;
        $verified_id = $request->verified_id;
        $bookingData  = OrderFulfillmentBooking::where('id', $request->booking_id)->first();
        $orderInfo  =  getMeasurementsOrderInfo($orderId);
        if (empty($orderInfo)) {
            $is_verified = 0;
        } else {
            $is_verified =  $orderInfo->is_verified;
        }
        if ($is_verified == 0) {
            if (!empty($bookingData)) {
                DB::beginTransaction();
                if (!empty($request->order_qty)) {

                    $price_percentage = ($request->paid_price / $request->order_total_price) * 100;
                    if ($request->order_total_price == $request->paid_price) {
                        $payment_type = 'full';
                    } else {
                        $payment_type = 'partial';
                    }
                    $store_id = 1;
                    $main_order_data = [
                        'booking_id' => $bookingData->id,
                        'store_id' => $store_id,
                        'name' => $bookingData->first_name . ' ' . $bookingData->last_name,
                        'email' => $bookingData->email,
                        'phone' => $bookingData->phone_numbe,
                        'total_price' => $request->order_total_price,
                        'paid_amount' => $request->paid_price,
                        'address' => $bookingData->address,
                        'zip_code' => $request->post_code,
                        'paid_percentage' => $price_percentage,
                        'payment_type' => $payment_type,
                        'created_by'=>Auth::user()->id
                    ];

                    if (!empty($orderId)) {
                        $log_order   = OrderFulfillmentBookingOrderLog::where('id', $orderId)->update($main_order_data);
                        if ($verified_id == 1) {
                            $log_order   = OrderFulfillmentBookingOrderLog::where('id', $orderId)->update(['is_verified' => 1]);
                        }
                        $main_order = Order::create($main_order_data);
                    } else {
                        if ($verified_id == 0) {
                            $log_order =  OrderFulfillmentBookingOrderLog::create($main_order_data);
                            // $order = new OrderFulfillmentBookingOrderLog;
                        } else {
                            if (!empty($orderId)) {
                                $order   = OrderFulfillmentBookingOrderLog::where('id', $orderId)->update($main_order_data);
                            } else {
                                $log_order = OrderFulfillmentBookingOrderLog::create($main_order_data);
                                $log_order_update   = OrderFulfillmentBookingOrderLog::where('id', $log_order->id)->update(['is_verified' => 1]);
                            }
                            $main_order = Order::create($main_order_data);
                        }
                    }
                }
                if (!empty($orderId)) {
                    OrderFulfillmentBookingOrderItemLog::where('order_id', $orderId)->update(['deleted_at' => Carbon::now()->format('Y-m-d')]);
                }
                if ($verified_id == 0) {
                    $order_id =  !empty($log_order->id) ? $log_order->id : $orderId;
                    $main_order_id = '';
                } else {
                    $order_id = !empty($log_order->id) ? $log_order->id : $orderId;
                    $main_order_id = $main_order->id;
                }
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

                if (!empty($order_id)) {
                    $LogOrderArr = [];
                    $mainOrderArr = [];
                    if (!empty($product_id)) {
                        foreach ($product_id as $key => $productArr) {
                            if ($order_id) {
                                $LogOrderArr[] = [
                                    'order_id' => $order_id,
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
                                    'customer_note'=>!empty($customer_note[$key]) ? $customer_note[$key] : ''

                                ];
                            }
                            if (!empty($main_order_id)) {
                                $mainOrderArr[] = [
                                    'order_id' => $main_order_id,
                                    'product_id' => $productArr,
                                    'dimension' => $length[$key] . 'x' . $width[$key],
                                    'fitting_type' => $fitting[$key],
                                    'fitting_option' => !empty($fitting_option[$key]) ? $fitting_option[$key] : NULL,
                                    'side_control' => $side_control[$key],
                                    'chain_color' => $chain_color[$key],
                                    'qty' => $order_qty[$key],
                                    'scale' => $measurement[$key],
                                    'price' => $order_price[$key],
                                    'customer_note'=>!empty($customer_note[$key]) ? $customer_note[$key] : ''
                                ];
                            }
                        }

                        if ($verified_id == 0) {
                            $orderItemId = OrderFulfillmentBookingOrderItemLog::insert($LogOrderArr);
                        } else {
                            $orderItemId = OrderFulfillmentBookingOrderItemLog::insert($LogOrderArr);
                            $orderItemId = OrderItem::insert($mainOrderArr);
                            OrderFulfillmentBookingAssign::where(['booking_id'=>$bookingData->id])->whereNull('deleted_at')->update(['assign_status'=>'completed']);
                        }
                    } else {
                        $return = ['status' => 'error', 'message' => 'Sorry Your order not submitted!'];
                        return response()->json($return);
                    }

                    if (!empty($orderItemId)) {
                        DB::commit();
                        $return = ['status' => 'success', 'verified_id' => $verified_id, 'message' => 'Your order submitted successfully!'];
                    } else {
                        $return = ['status' => 'error', 'message' => 'Sorry Your order not submitted!'];
                    }
                    return response()->json($return);
                } else {
                    $return = ['status' => 'error', 'message' => 'Sorry Your order not submitted!'];
                }
                return response()->json($return);
            }
        } else {
            $return = ['status' => 'verified', 'message' => 'Your order confirmed now it can t be edited now!'];
            return response()->json($return);
        }
    }

    public function getOrderItemById(Request $request)
    {
        $orderItem = OrderFulfillmentBookingOrderItemLog::where('id', $request->id)->first();
        $return = [
            'status' => 'success',
            'data' => $orderItem
        ];
        if (empty($orderItem)) {
            $return = [
                'status' => 'error',
                'message' => 'Data not found for edit'
            ];
        }
        return response()->json($return);
    }
}
