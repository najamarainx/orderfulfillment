@extends('layouts.app')
@section('title', 'Order Detail')

@section('page_level_css_plugin')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection
@php $usersTypeArray = ['assembler','packaging','installation']; @endphp
@section('page_level_css')
    <style>
        @media(max-width: 768px){
            .cust-border-primary {
                border-right: 0 !important;
            }
        }

        .table-custom th,
        .table-custom td {
            border-top: none;
        }

    </style>
@endsection
@section('content')
    <!--begin::Content-->
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Order History Page</h5>
                    <!--end::Page Title-->
                    <!--begin::Actions-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200">
                    </div>
                    <span class="text-muted font-weight-bold mr-4">Order History Page</span>
                    <!--end::Actions-->
                </div>
                <!--end::Info-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <div class="row">


                    <!--begin::card One-->
                    <div class="col-lg-12">
                        <div class="card card-custom gutter-b ml-auto">
                            <!--begin::Header-->
                            <!-- <div class="card-header">
                                <h3 class="card-title align-items-center">
                                    <span class="card-label font-weight-bolder text-dark">Order ID <span>#45895</span></span>
                                </h3>
                            </div> -->
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body">

                                <!--begin::Total-->
                                <div class="container px-0">
                                    <div class="row justify-content-center pb-10">
                                        <div class="col-md-12">
                                            <div class="rounded d-flex align-items-center justify-content-between text-white  position-relative ml-auto px-7 py-5 bgi-no-repeat bgi-size-cover bgi-position-center bg-gray-500">
                                                <div class="font-weight-boldest font-size-h5">TOTAL AMOUNT</div>
                                                <div class="text-right d-flex flex-column">
                                                    <span class="font-weight-boldest font-size-h3 line-height-sm">£{{$orderInfo->total_price}}</span>
                                                    <span class="font-size-sm">Taxes included</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Total-->

                                <!--begin: Datatable-->
                                <div class="table-responsive">

                                    <!-- <div class="first-container pull-left">          -->
                                    <table class="table table-condensed table-head-custom table-vertical-center">
                                        <thead>
                                        <tr>
                                            <th>Payment Logs</th>
                                            <th>Received By</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Designation</th>
                                            <th>Payment Type</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <!-- Tr One:: Start  -->
                                        @if($orderInfo->booking_id=='')
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <div>
                                                    <a  class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">Premimum Blinds</a>

                                                </div>
                                            </td>
                                            <td>£<span>{{$orderInfo->paid_amount}}</span></td>
                                            <td>
                                                <p class="text-dark-75 text-hover-primary mb-0 font-size-lg">{{$orderInfo->created_at}}</p>
                                            </td>
                                            <td>
                                                <div>
                                                    <p class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">NULL</p>

                                                </div>
                                            </td>
                                            <td>Company Account</td>
                                            <td>
                                                <span class="label label-lg label-light-success label-inline">Verified</span>
                                            </td>
                                        </tr>
                                        @else
                                            @php
                                            $i=1;
                                            @endphp
                                            @foreach($orderPamentLogsInfo as $orderPamentLogs)
                                            <tr>
                                                <td>{{$i}}</td>
                                                <td>
                                                    <div>
                                                        <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{$orderPamentLogs->name}}</a>
                                                        <span class="text-muted font-weight-bold d-block">{{$orderPamentLogs->email}}</span>
                                                    </div>
                                                </td>
                                                <td>£<span>{{$orderPamentLogs->paid_amount}}</span></td>
                                                <td>
                                                    <p class="text-dark-75 text-hover-primary mb-0 font-size-lg">{{date('d/m/Y',strtotime($orderPamentLogs->created_at))}}</p>
                                                </td>
                                                <td>
                                                    <div>
                                                        <p class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{str_replace('_',' ',ucfirst($orderPamentLogs->type))}}</p>

                                                    </div>
                                                </td>
                                                <td>{{str_replace('_',' ',ucfirst($orderPamentLogs->payment_type))}}</td>
                                                <td>
                                                    @if($orderPamentLogs->is_verified==1)
                                                    <span class="label label-lg label-light-success label-inline">Verified</span>
                                                    @else
                                                        <span class="label label-lg label-light-danger label-inline">Un Verified</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @php
                                            $i++;
                                            @endphp
                                            @endforeach
                                        @endif




                                        </tbody>
                                    </table>
                                    <!-- </div> -->

                                </div>
                                <!--end: Datatable-->

                            </div>
                            <!--end::Body-->

                        </div>
                    </div>
                    <!--end::card One-->

                    <!--begin::card Two-->
                    <div class="col-lg-12">
                        <div class="card card-custom gutter-b ml-auto">
                            <!--begin::Header-->
                            <div class="card-header">
                                <h3 class="card-title align-items-center">
                                    <span class="card-label font-weight-bolder text-dark">Booking <span> @if(!empty($orderBookingInfo)) # {{$orderBookingInfo->id}} @endif</span></span>
                                </h3>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 cust-border-primary">
                                        <!--begin::Table-->
                                        <div class="table-responsive">
                                            <table class="table table-head-custom table-custom table-vertical-center" id="kt_advance_table_widget_3">
                                                <tr>
                                                    <th class="font_weight py-1">Customer Name</th>
                                                    <td class="float_end py-1">{{$orderInfo->name}}</td>
                                                </tr>
                                                <tr>
                                                    <th class="font_weight py-1">Customer Phone.No</th>
                                                    <td class="float_end py-1">{{$orderInfo->phone}}</td>
                                                </tr>
                                                <tr>
                                                    <th class="font_weight py-1">Customer Email</th>
                                                    <td class="float_end py-1">{{$orderInfo->email}}</td>
                                                </tr>
                                                <tr>
                                                    <th class="font_weight py-1">Customer Address</th>
                                                    <td class="float_end py-1">{{$orderInfo->address}}</td>
                                                </tr>
                                                <tr>
                                                    <th class="font_weight py-1">Customer Postal Code</th>
                                                    <td class="float_end py-1">{{$orderInfo->zip_code}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <!--end::Table-->
                                    </div>
                                    @if(!empty($orderBookingInfo))
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <!--begin::Table-->
                                        <div class="table-responsive">
                                            <table class="table table-head-custom table-custom table-vertical-center" id="kt_advance_table_widget_3">
                                                <tr>
                                                    <th class="font_weight py-1">Category</th>
                                                    <td class="float_end py-1">{{$orderBookingInfo->categoryName}}</td>
                                                </tr>
                                                <tr>
                                                    <th class="font_weight py-1">Booking Date</th>
                                                    <td class="float_end py-1">{{date('d/m/Y',strtotime($orderBookingInfo->created_at))}}</td>
                                                </tr>
                                                <tr>
                                                    <th class="font_weight py-1">Booking Time</th>
                                                    <td class="float_end py-1">{{date('h:s A',strtotime($orderBookingInfo->booking_from_time))}} to {{date('h:s A',strtotime($orderBookingInfo->booking_to_time))}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <!--end::Table-->
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <!--end::Body-->
                            <!-- begin::Footer -->
                            @if(!empty($orderBookingInfo))
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 cust-border-primary">
                                        <h6 class="text-primary">Booking Create By</h6>
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <div class="symbol symbol-50 flex-shrink-0 mr-4">
                                                <div class="symbol-label" style="background-image: url('assets/media/stock-600x400/img-26.jpg')"></div>
                                            </div>
                                            <div>
                                                <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{$orderBookingInfo->created_by}}</a>
                                                <span class="text-muted font-weight-bold d-block">{{$orderBookingInfo->created_email}}</span>
                                            </div>
                                            <div class="row">
                                                <span class="col-md-12 col-xs-12 text-md-right text-sm-left text-xs-right">{{date('d/m/Y',strtotime($orderBookingInfo->created_at))}}</span>
                                                <span class="col-md-12 col-xs-12 text-md-right text-sm-left text-xs-right">{{date('h:i A',strtotime($orderBookingInfo->created_at))}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <h6 class="text-primary">Booking Assign to</h6>
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <div class="symbol symbol-50 flex-shrink-0 mr-4">
                                                <div class="symbol-label" style="background-image: url('assets/media/stock-600x400/img-27.jpg')"></div>
                                            </div>
                                            <div>
                                                <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{$orderBookingInfo->assigned_to}}</a>
                                                <span class="text-muted font-weight-bold d-block">{{$orderBookingInfo->assigned_email}}</span>
                                            </div>
                                            <div class="row">
                                                <span class="col-md-12 col-xs-12 text-md-right text-sm-left text-xs-right">{{date('d/m/Y',strtotime($orderBookingInfo->assigned_date))}}</span>
                                                <span class="col-md-12 col-xs-12 text-md-right text-sm-left text-xs-right">{{date('h:i A',strtotime($orderBookingInfo->assigned_date))}}</span>
                                            </div>
                                        </div>
                                        <hr class="w-100">

                                    </div>
                                </div>
                            </div>
                            @endif
                            <!-- end::Footer -->
                        </div>
                    </div>
                    <!--end::card Two-->
                    @if(!empty($orderInfo))
                    <!--begin::card Three-->
                    <div class="col-lg-12">
                        <div class="card card-custom gutter-b ml-auto">
                            <!--begin::Header-->
                            <div class="card-header">
                                <h3 class="card-title align-items-center">
                                    <span class="card-label font-weight-bolder text-dark">Order ID <span>#{{$orderInfo->id}}</span></span>
                                </h3>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin: Datatable-->
                                <div class="table-responsive">



                                    <!-- <div class="first-container pull-left">          -->
                                    <table class="table table-condensed table-head-custom table-vertical-center">
                                        <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Dimension</th>
                                            <th>Fitting Type</th>
                                            <th>Side of Controls</th>
                                            <th>Chain Color</th>
                                            <th>Fitting Option</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <!-- Tr One:: Start  -->
                                        @foreach($orderProductItemsInventory as $product)
                                        <tr>
                                            <td>{{$product->orderProducts->name}}</td>
                                            <td>{{floor($product->qty)}}</td>
                                            <td>{{$product->dimension}}</td>
                                            <td>{{$product->fitting_type}}</td>
                                            <td>{{$product->side_control}}</td>
                                            <td>{{$product->chain_color}}</td>
                                            <td>{{$product->fitting_option}}</td>
                                            @php
                                            $product_status_class = null;
                                             if($product->status == 'pending'){
                                                    $product_status_class = 'label-light-danger';
                                                }
                                                if($product->status == 'in progress'){
                                                    $product_status_class = 'label-light-warning';
                                                }
                                                if($product->status == 'not respond'){
                                                    $product_status_class = 'label-light-warning';
                                                }
                                                if($product->status == 'assigned'){
                                                    $product_status_class = 'label-light-success';
                                                }
                                                if($product->status == 'completed'){
                                                    $product_status_class = 'label-light-success';
                                                }
                                                
                                            @endphp
                                           <td>
                                                <span class="label label-lg {{ $product_status_class }} label-inline">{{$product->status}}</span>
                                            </td>
                                        </tr>

                                        <tr class="container">
                                            <td colspan="9" style="border-left:5px solid #b10303;background: rgb(236, 236, 236); ">
                                                <div>

                                                    <table class="table table-condensed table-head-custom table-vertical-center">
                                                        <thead>
                                                        <tr class="text-left text-uppercase">
                                                            <th style="min-width: 110px">Department</th>
                                                            <th style="min-width: 120px">Item</th>
                                                            <th style="min-width: 120px">Variant</th>
                                                            <th style="min-width: 120px">Quantity</th>
                                                            <th style="min-width: 120px">Assign to</th>
                                                            <th style="min-width: 120px">Assign Date and time</th>
                                                            <th style="min-width: 120px">Status</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody data-repeater-list="">
                                                        @foreach($product->orderProducts->saleLogProduct as $saleLogItem)

                                                        <tr  data-repeater-item="">
                                                            <td>{{ucfirst($saleLogItem->departmentDetails->name)}}</td>
                                                            <td>{{ucfirst($saleLogItem->itemDetails->name)}}</td>
                                                            <td>{{$saleLogItem->variantDetails->name}}</td>
                                                            <td>{{$saleLogItem->qty}}</td>
                                                            <td>
                                                                <div class="d-flex align-items-center justify-content-start w-100">
                                                                    <div>
                                                                        <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{isset($saleLogItem->assignedTask->assignedUser->name) && !empty($saleLogItem->assignedTask->assignedUser->name) ? $saleLogItem->assignedTask->assignedUser->name : '' }}</a>
                                                                        <span class="text-muted font-weight-bold d-block">{{isset($saleLogItem->assignedTask->assignedUser->email) && !empty($saleLogItem->assignedTask->assignedUser->email) ? $saleLogItem->assignedTask->assignedUser->email :''}}</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center justify-content-start w-100">
                                                                    <div class="row">
                                                                        <span class="col-md-12 col-xs-12 text-md-right text-sm-left text-xs-right">{{date('d/m/Y',strtotime(isset($saleLogItem->assignedTask->created_at) && !empty($saleLogItem->assignedTask->created_at) ? $saleLogItem->assignedTask->created_at : ''))}}</span>
                                                                        <span class="col-md-12 col-xs-12 text-md-right text-sm-left text-xs-right">{{date('h:i A',strtotime(isset($saleLogItem->assignedTask->created_at) && !empty($saleLogItem->assignedTask->created_at) ? $saleLogItem->assignedTask->created_at : ''))}}</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            @php
                                                            $sale_log_status_class = null;
                                                             if($saleLogItem->status == 'pending'){
                                                                    $sale_log_status_class = 'label-light-danger';
                                                                }
                                                                if($saleLogItem->status == 'in progress'){
                                                                    $sale_log_status_class = 'label-light-warning';
                                                                }
                                                                if($saleLogItem->status == 'not respond'){
                                                                    $sale_log_status_class = 'label-light-warning';
                                                                }
                                                                if($saleLogItem->status == 'assigned'){
                                                                    $sale_log_status_class = 'label-light-success';
                                                                }
                                                                if($saleLogItem->status == 'completed'){
                                                                    $sale_log_status_class = 'label-light-success';
                                                                }
                                                                
                                                            @endphp
                                                            <td>
                                                                <span class="label label-lg {{   $sale_log_status_class }} label-inline">{{$saleLogItem->status}}</span>
                                                            </td>
                                                        </tr>
                                                        @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Tr One:: End  -->
                                        @endforeach
                                        <!-- Tr Two:: Start  -->

                                        <!-- Tr Two:: End  -->

                                        </tbody>
                                    </table>
                                    <!-- </div> -->

                                </div>
                                <!--end: Datatable-->
                            </div>
                            <!--end::Body-->

                        </div>
                    </div>
                    <!--end::card Three-->
                    @endif
                    <!--begin::card Four-->
                    <div class="col-lg-12">
                        <div class="card card-custom gutter-b ml-auto">
                            <!--begin::Header-->
                            <div class="card-header">
                                <h3 class="card-title align-items-center">
                                    <span class="card-label font-weight-bolder text-dark">Assembler</span>
                                </h3>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin: Datatable-->
                                <div class="table-responsive">

                                    <!-- <div class="first-container pull-left">          -->
                                    <table class="table table-condensed table-head-custom table-vertical-center">
                                        <thead>
                                        <tr>

                                            <th>Assign From</th>
                                            <th>Assign To</th>
                                            <th>Status</th>
                                            <th>Date / Time</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <!-- Tr One:: Start  -->
                                        @foreach($orderAssembleInfo as $assemble)
                                        <tr>

                                            <td>
                                                <div>
                                                    <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ucfirst($assemble->assigned_from)}}</a>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ucfirst($assemble->assigned_to)}}</a>
                                                </div>
                                            </td>
                                            <td>

                                                <span class="label label-lg label-light-warning label-inline">{{$assemble->status}}</span>
                                            </td>
                                            <td>
                                                <div>
                                                    <p class="text-dark-75 text-hover-primary mb-0 font-size-lg">{{date('d/m/Y',strtotime($assemble->created_at))}}</p>
                                                    <p class="text-dark-75 text-hover-primary mb-0 font-size-lg">{{date('h:i A',strtotime($assemble->created_at))}}</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                    <!-- </div> -->

                                </div>
                                <!--end: Datatable-->
                            </div>
                            <!--end::Body-->

                        </div>
                    </div>
                    <!--end::card Four-->

                    <!--begin::card Five-->
                    <div class="col-lg-12">
                        <div class="card card-custom gutter-b ml-auto">
                            <!--begin::Header-->
                            <div class="card-header">
                                <h3 class="card-title align-items-center">
                                    <span class="card-label font-weight-bolder text-dark">Packing </span>
                                </h3>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin: Datatable-->
                                <div class="table-responsive">

                                    <!-- <div class="first-container pull-left">          -->
                                    <table class="table table-condensed table-head-custom table-vertical-center">
                                        <thead>
                                        <tr>

                                            <th>Assign From</th>
                                            <th>Assign To</th>
                                            <th>Status</th>
                                            <th>Date / Time</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <!-- Tr One:: Start  -->
                                        @foreach($orderPackingInfo as $assemble)
                                            <tr>

                                                <td>
                                                    <div>
                                                        <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ucfirst($assemble->assigned_from)}}</a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ucfirst($assemble->assigned_to)}}</a>
                                                    </div>
                                                </td>
                                                <td>

                                                    <span class="label label-lg label-light-warning label-inline">{{$assemble->status}}</span>
                                                </td>
                                                <td>
                                                    <div>
                                                        <p class="text-dark-75 text-hover-primary mb-0 font-size-lg">{{date('d/m/Y',strtotime($assemble->created_at))}}</p>
                                                        <p class="text-dark-75 text-hover-primary mb-0 font-size-lg">{{date('h:i A',strtotime($assemble->created_at))}}</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                    <!-- </div> -->

                                </div>
                                <!--end: Datatable-->
                            </div>
                            <!--end::Body-->

                        </div>
                    </div>
                    <!--end::card Five-->

                    <!--begin::card Six-->
                    <div class="col-lg-12">
                        <div class="card card-custom gutter-b ml-auto">
                            <!--begin::Header-->
                            <div class="card-header">
                                <h3 class="card-title align-items-center">
                                    <span class="card-label font-weight-bolder text-dark">Installation </span>
                                </h3>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin: Datatable-->
                                <div class="table-responsive">

                                    <!-- <div class="first-container pull-left">          -->
                                    <table class="table table-condensed table-head-custom table-vertical-center">
                                        <thead>
                                        <tr>

                                            <th>Assign From</th>
                                            <th>Assign To</th>
                                            <th>Status</th>
                                            <th>Date / Time</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <!-- Tr One:: Start  -->
                                        @foreach($orderInstallationInfo as $assemble)
                                            <tr>

                                                <td>
                                                    <div>
                                                        <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ucfirst($assemble->assigned_from)}}</a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ucfirst($assemble->assigned_to)}}</a>
                                                    </div>
                                                </td>
                                                <td>

                                                    <span class="label label-lg label-light-warning label-inline">{{$assemble->status}}</span>
                                                </td>
                                                <td>
                                                    <div>
                                                        <p class="text-dark-75 text-hover-primary mb-0 font-size-lg">{{date('d/m/Y',strtotime($assemble->created_at))}}</p>
                                                        <p class="text-dark-75 text-hover-primary mb-0 font-size-lg">{{date('h:i A',strtotime($assemble->created_at))}}</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                    <!-- </div> -->

                                </div>
                                <!--end: Datatable-->
                            </div>
                            <!--end::Body-->

                        </div>
                    </div>
                    <!--end::card Six-->

                    <div class="col-lg-12">
                        <div class="card card-custom gutter-b ml-auto">
                            <!--begin::Body-->
                            <div class="card-body">

                                <!-- begin: Invoice action-->
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <div class="d-flex font-size-sm flex-wrap">
                                                <button type="button" class="btn btn-primary font-weight-bolder py-4 mr-3 mr-sm-14 my-1 px-7">Print Invoice</button>
                                                <button id="cmd" type="button" class="btn btn-light-danger font-weight-bolder mr-3 ml-sm-auto my-1 px-7">Download</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end: Invoice action-->
                            </div>
                            <!--end::Body-->
                        </div>
                    </div>


                </div>
                <!--end::Advance Table Widget 3-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
    <!--end::Content-->
    <!--end::Content-->
@endsection
