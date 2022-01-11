@extends('layouts.app')
@section('title', 'Booking')

@section('page_level_css_plugin')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page_level_css')

@endsection
@section('content')
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="card card-custom gutter-b">
                        <div class="card-header border-0 py-5">
                            <h3 class="card-title align-items-center">
                                <span class="card-label font-weight-bolder text-dark">Customer Booking</span>
                            </h3>
                        </div>
                        <div class="card-body pt-0 pb-3">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <p><b>Customer Name</b></p>
                                    <p><b>Customer Phone No</b></p>
                                    <P><b>Customer Address</b></P>
                                    <P><b>Binds Category</b></P>
                                    <P><b>Booking Date</b></P>
                                    <p><b>Slot Time</b></p>
                                    <p><b>Status</b></p>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <P>{{ $bookingDetail->first_name . ' ' . $bookingDetail->last_name }}</P>
                                    <P>{{ $bookingDetail->phone_number }}</P>
                                    <P>{{ $bookingDetail->address }}</P>
                                    <P>{{ $bookingDetail->bookingCategory->name }}</P>
                                    <P>{{ \Carbon\Carbon::parse($bookingDetail->date)->format('m/d/Y') }}</P>
                                    <P>{{ date('g:i a', strtotime($bookingDetail->bookingSlot->booking_from_time)) . ' - ' . date('g:i a', strtotime($bookingDetail->bookingSlot->booking_to_time)) }}
                                    </P>

                                    <P><span
                                            class="badge badge-success badge-pill booking_assign_status">{{ $bookingDetail->bookingDetail->assign_status }}</span>
                                    </P>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card card-custom gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0 py-5">
                            <h3 class="card-title align-items-center">
                                <span class="card-label font-weight-bolder text-dark">Book By Customer Support</span>
                            </h3>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-0 pb-3">

                            <!-- begin: Invoice-->
                            <!-- begin: Invoice footer-->
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex flex-column mb-10 mb-md-0">
                                        <div class="d-flex align-items-center">

                                            <div>
                                                <a href="#"
                                                    class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ $bookingDetail->bookingDetail->bookedUser->u_name }}</a>
                                                <span
                                                    class="text-muted font-weight-bold d-block">{{ $bookingDetail->bookingDetail->bookedUser->email }}</span>
                                            </div>
                                        </div>
                                        <hr class="w-100">
                                        <div class="row">
                                            <span class="col-md-6 col-xs-12 font-weight-bold">Appointment Date</span>
                                            <span
                                                class="col-md-6 col-xs-12 text-md-right text-sm-left text-xs-left">{{ \Carbon\Carbon::parse($bookingDetail->date)->format('m/d/Y') }}</span>
                                        </div>
                                        <hr class="w-100">
                                        {{-- <div class="row">
                                        <span class="col-md-6 col-xs-12 font-weight-bold">Appointment Time</span>
                                        <span class="col-md-6 col-xs-12 text-md-right text-sm-left text-xs-left">11:30 AM</span>
                                    </div> --}}
                                    </div>
                                </div>
                            </div>
                            <!-- end: Invoice footer-->
                            <!-- end: Invoice-->


                        </div>
                        <!--end::Body-->
                    </div>
                    <div class="card card-custom gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0 py-5">
                            <h3 class="card-title align-items-center">
                                <span class="card-label font-weight-bolder text-dark">Booking Assigned to Measurement
                                    Person</span>
                            </h3>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-0 pb-3">

                            <!-- begin: Invoice-->
                            <!-- begin: Invoice footer-->
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex flex-column mb-10 mb-md-0">
                                        <div class="d-flex align-items-center">

                                            <div>
                                                <a href="#"
                                                    class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ $bookingDetail->bookingDetail->assignedUser->u_name }}</a>
                                                <span
                                                    class="text-muted font-weight-bold d-block">{{ $bookingDetail->bookingDetail->assignedUser->email }}</span>
                                            </div>
                                        </div>
                                        <hr class="w-100">
                                        <div class="row">
                                            <span class="col-md-6 col-xs-12 font-weight-bold">Appointment Date</span>
                                            <span
                                                class="col-md-6 col-xs-12 text-md-right text-sm-left text-xs-left">{{ !empty($bookingDetail->bookingDetail->date) ? \Carbon\Carbon::parse($bookingDetail->bookingDetail->date)->format('m/d/Y') : '' }}</span>
                                        </div>
                                        <hr class="w-100">
                                        {{-- <div class="row">
                                        <span class="col-md-6 col-xs-12 font-weight-bold">Appointment Time</span>
                                        <span class="col-md-6 col-xs-12 text-md-right text-sm-left text-xs-left">11:30 AM</span>
                                    </div> --}}
                                    </div>
                                </div>
                            </div>
                            <!-- end: Invoice footer-->
                            <!-- end: Invoice-->


                        </div>
                        <!--end::Body-->
                    </div>
                </div>
            </div>
            @if(!empty($bookingDetail->bookingOrder))
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card card-custom gutter-b">
                        <div class="card-header border-0 py-5">
                            <h3 class="card-title align-items-center">
                                @php $month = date('m');
                                                $orderId = $month . str_pad($bookingDetail->bookingOrder->id, STR_PAD_RIGHT);
                                @endphp
                                <span class="card-label font-weight-bolder text-dark">Booking Order (#{{$orderId}})</span>
                            </h3>
                        </div>
                        <div class="card-body pt-0 pb-3">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <p>Date: {{\Carbon\carbon::parse($bookingDetail->bookingOrder->created_at)->format('m/d/Y') }}</p>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 text-right">
                                   
                                    <p>Total Amount: 	£{{$bookingDetail->bookingOrder->total_price}}</p>
                                    <p>Paid Amount: 	£{{$bookingDetail->bookingOrder->paid_amount}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <table class="table table-condensed table-head-custom table-vertical-center"
                                        id="kt_advance_table_widget_3_check">
                                        <thead>
                                            <tr class="text-left text-uppercase">
                                                <th class="px-0">Product Name</th>
                                                <th>Quantity</th>
                                                <th class="text-info">Dimensions</th>
                                                <th>Measurement</th>
                                                <th style="min-width: 137px">Fittings Type</th>
                                                <th>Side Of Controls
                                                </th>
                                                <th>Chain Color
                                                </th>
                                                <th>Fittings Option
                                                </th>
                                               
                                               <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!$bookingDetail->bookingOrder->orderdetail->isEmpty())
                                            @foreach ($bookingDetail->bookingOrder->orderdetail as $orderDetailObj)
                                            <tr id="2" class="sub-container">
                                                <td class="pl-0">
                                                    <a href="#"
                                                        class="text-dark-75 font-weight-normal text-hover-primary mb-1 ">{{$orderDetailObj->orderProducts->name}}</a>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-normal d-block ">{{$orderDetailObj->qty}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-normal d-block ">{{$orderDetailObj->dimension}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-normal d-block ">{{$orderDetailObj->scale}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-normal d-block ">{{$orderDetailObj->fitting_type}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-normal d-block ">{{$orderDetailObj->side_control}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-normal d-block ">{{$orderDetailObj->chain_color}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-normal d-block ">{{!empty($orderDetailObj->fitting_option) ? $orderDetailObj->fitting_option : '' }}</span>
                                                </td>
                                               
                                                <td>
                                                    <span class="text-dark-75 font-weight-normal d-block ">{{$orderDetailObj->price}}</span>

                                                </td>

                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
