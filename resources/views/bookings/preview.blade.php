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
                            <span class="card-label font-weight-bolder text-dark">Customer Booking (#1023)</span>
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
                                <P>{{$bookingDetail->first_name .' '. $bookingDetail->last_name}}</P>
                                <P>{{$bookingDetail->phone_number}}</P>
                                <P>{{$bookingDetail->address}}</P>
                                <P>{{$bookingDetail->bookingCategory->name}}</P>
                                <P>{{ \Carbon\Carbon::parse($bookingDetail->date)->format('m/d/Y')}}</P>
                                <P>{{ date('g:i a',strtotime($bookingDetail->bookingSlot->booking_from_time)).' - '.date('g:i a',strtotime($bookingDetail->bookingSlot->booking_to_time)) }}</P>

                                <P><span class="badge badge-success badge-pill booking_assign_status">{{$bookingDetail->bookingDetail->assign_status}}</span></P>
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
                                            <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{$bookingDetail->bookingDetail->bookedUser->u_name}}</a>
                                            <span class="text-muted font-weight-bold d-block">{{$bookingDetail->bookingDetail->bookedUser->email}}</span>
                                        </div>
                                    </div>
                                    <hr class="w-100">
                                    <div class="row">
                                        <span class="col-md-6 col-xs-12 font-weight-bold">Appointment Date</span>
                                        <span class="col-md-6 col-xs-12 text-md-right text-sm-left text-xs-left">{{ \Carbon\Carbon::parse($bookingDetail->date)->format('m/d/Y')}}</span>
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
                            <span class="card-label font-weight-bolder text-dark">Booking Assigned to Measurement Person</span>
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
                                            <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{$bookingDetail->bookingDetail->assignedUser->u_name}}</a>
                                            <span class="text-muted font-weight-bold d-block">{{$bookingDetail->bookingDetail->assignedUser->email}}</span>
                                        </div>
                                    </div>
                                    <hr class="w-100">
                                    <div class="row">
                                        <span class="col-md-6 col-xs-12 font-weight-bold">Appointment Date</span>
                                        <span class="col-md-6 col-xs-12 text-md-right text-sm-left text-xs-left">{{ !empty($bookingDetail->bookingDetail->date) ?  \Carbon\Carbon::parse($bookingDetail->bookingDetail->date)->format('m/d/Y') : ''}}</span>
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
    </div>
</div>
@endsection
