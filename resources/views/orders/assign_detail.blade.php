@extends('layouts.app')
@section('title', 'Order Detail')

@section('page_level_css_plugin')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page_level_css')
    <style>
        .error {
            color: red !important;
        }

    </style>
@endsection
@section('content')
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Detail Page</h5>
                    <!--end::Page Title-->
                    <!--begin::Actions-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200">
                    </div>
                    <span class="text-muted font-weight-bold mr-4">Detail Page</span>
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
                    <!--begin::Advance Table Widget 3-->
                    <div class="col-lg-12">
                        <div class="card card-custom gutter-b">
                            <!--begin::Header-->
                            <div class="card-header border-0 py-5">
                                <h3 class="card-title align-items-center">
                                                <span class="card-label font-weight-bolder text-dark">Order
                                                    (#{{$orderItems->id}})</span>
                                </h3>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body pt-0 pb-3">
                                <!--begin::Table-->
                                <div class="table-responsive">
                                    <table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_3">
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
                                            <th>Status
                                            </th>
                                            <th class="pr-0 text-right" style="min-width: 160px">action
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orderItems->orderdetail as $orderItem)
                                        <tr>
                                            <td class="pl-0">
                                                <a href="#" class="text-dark-75 font-weight-normal text-hover-primary mb-1 ">{{ucfirst($orderItem->orderProducts->name)}}</a>
                                            </td>
                                            <td>
                                                <span class="text-dark-75 font-weight-normal d-block ">{{$orderItem->qty}}</span>
                                            </td>
                                            <td>
                                                <span class="text-dark-75 font-weight-normal d-block ">{{$orderItem->dimension}}</span>
                                            </td>
                                            <td>
                                                <span class="text-dark-75 font-weight-normal d-block ">{{ucfirst($orderItem->scale)}}</span>
                                            </td>
                                            <td>
                                                <span class="text-dark-75 font-weight-normal d-block ">{{ucfirst($orderItem->fitting_type)}}</span>
                                            </td>
                                            <td>
                                                 <span class="text-dark-75 font-weight-normal d-block ">{{ucfirst($orderItem->side_control)}}</span>
                                            </td>
                                            <td>
                                                 <span class="text-dark-75 font-weight-normal d-block ">{{ucfirst($orderItem->chain_color)}}</span>
                                            </td>
                                            <td>
                                                 <span class="text-dark-75 font-weight-normal d-block ">{{ucfirst($orderItem->fitting_option)}}</span>
                                            </td>
                                            <td>
                                                <span class="label label-lg label-light-success label-inline">Pending</span>
                                            </td>
                                            <td class="text-right pr-0">

                                                <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                                                    <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Write.svg-->
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                             width="24px" height="24px"
                                                                             viewBox="0 0 24 24" version="1.1">
                                                                            <g stroke="none" stroke-width="1"
                                                                               fill="none" fill-rule="evenodd">
                                                                                <rect x="0" y="0" width="24"
                                                                                      height="24" />
                                                                                <path
                                                                                    d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z"
                                                                                    fill="#000000" fill-rule="nonzero"
                                                                                    transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)" />
                                                                                <path
                                                                                    d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z"
                                                                                    fill="#000000" fill-rule="nonzero"
                                                                                    opacity="0.3" />
                                                                            </g>
                                                                        </svg>
                                                                        <!--end::Svg Icon-->
                                                                    </span>
                                                </a>
                                                <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm" data-toggle="modal" data-target="#staticBackdrop">
                                                                    <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg-->
                                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<rect x="0" y="0" width="24" height="24"></rect>
																				<path d="M12.8434797,16 L11.1565203,16 L10.9852159,16.6393167 C10.3352654,19.064965 7.84199997,20.5044524 5.41635172,19.8545019 C2.99070348,19.2045514 1.55121603,16.711286 2.20116652,14.2856378 L3.92086709,7.86762789 C4.57081758,5.44197964 7.06408298,4.00249219 9.48973122,4.65244268 C10.5421727,4.93444352 11.4089671,5.56345262 12,6.38338695 C12.5910329,5.56345262 13.4578273,4.93444352 14.5102688,4.65244268 C16.935917,4.00249219 19.4291824,5.44197964 20.0791329,7.86762789 L21.7988335,14.2856378 C22.448784,16.711286 21.0092965,19.2045514 18.5836483,19.8545019 C16.158,20.5044524 13.6647346,19.064965 13.0147841,16.6393167 L12.8434797,16 Z M17.4563502,18.1051865 C18.9630797,18.1051865 20.1845253,16.8377967 20.1845253,15.2743923 C20.1845253,13.7109878 18.9630797,12.4435981 17.4563502,12.4435981 C15.9496207,12.4435981 14.7281751,13.7109878 14.7281751,15.2743923 C14.7281751,16.8377967 15.9496207,18.1051865 17.4563502,18.1051865 Z M6.54364977,18.1051865 C8.05037928,18.1051865 9.27182488,16.8377967 9.27182488,15.2743923 C9.27182488,13.7109878 8.05037928,12.4435981 6.54364977,12.4435981 C5.03692026,12.4435981 3.81547465,13.7109878 3.81547465,15.2743923 C3.81547465,16.8377967 5.03692026,18.1051865 6.54364977,18.1051865 Z" fill="#000000"></path>
																			</g>
																		</svg>
                                                                        <!--end::Svg Icon-->
                                                                    </span>
                                                </a>
                                                <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm" data-toggle="modal" data-target="#staticBackdrop1">
                                                                    <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/General/Trash.svg-->
                                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<polygon points="0 0 24 0 24 24 0 24"></polygon>
																				<rect fill="#000000" opacity="0.3" x="11" y="5" width="2" height="14" rx="1"></rect>
																				<path d="M6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 C4.90236893,18.3165825 4.90236893,17.6834175 5.29289322,17.2928932 L11.2928932,11.2928932 C11.6714722,10.9143143 12.2810586,10.9010687 12.6757246,11.2628459 L18.6757246,16.7628459 C19.0828436,17.1360383 19.1103465,17.7686056 18.7371541,18.1757246 C18.3639617,18.5828436 17.7313944,18.6103465 17.3242754,18.2371541 L12.0300757,13.3841378 L6.70710678,18.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 14.999999) scale(1, -1) translate(-12.000003, -14.999999)"></path>
																			</g>
																		</svg>
                                                                        <!--end::Svg Icon-->
                                                                    </span>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!--end::Table-->

                            </div>
                            <!--end::Body-->
                        </div>
                    </div>

                </div>
                <div class="row">
                    <!--begin::Advance Table Widget 3-->

                    <div class="col-lg-6">
                        <div class="card card-custom gutter-b ml-auto">
                            <!--begin::Header-->
                            <div class="card-header border-0 py-5">
                                <h3 class="card-title align-items-center">
                                                <span class="card-label font-weight-bolder text-dark">Shipping
                                                    Information</span>
                                </h3>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body pt-0 pb-3">
                                <!--begin::Table-->
                                <div class="table-responsive">
                                    <table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_3">
                                        <tr>
                                            <th class="font_weight">Name</th>
                                            <td class="float_end">{{ucfirst($orderItems->name)}}</td>
                                        </tr>
                                        <tr>
                                            <th class="font_weight">Country</th>
                                            <td class="float_end">{{ucfirst($orderItems->country)}}</td>
                                        </tr>
                                        <tr>
                                            <th class="font_weight">City</th>
                                            <td class="float_end">{{ucfirst($orderItems->city)}}</td>
                                        </tr>

                                        <tr>
                                            <th class="font_weight">Postal Code</th>
                                            <td class="float_end">{{$orderItems->zip_code}}</td>
                                        </tr>
                                        <tr>
                                            <th class="font_weight">Phone</th>
                                            <td class="float_end">{{$orderItems->phone}}</td>
                                        </tr>
                                        <tr>
                                            <th class="font_weight">Address</th>
                                            <td class="float_end">{{$orderItems->address}}</td>
                                        </tr>


                                    </table>
                                </div>
                                <!--end::Table-->

                            </div>
                            <!--end::Body-->
                        </div>
                    </div>
                    @if(Auth::user()->type=='developer' or Auth::user()->type=='super_admin')
                    <div class="col-lg-6">
                        <div class="card card-custom gutter-b ml-auto">
                            <!--begin::Header-->
                            <div class="card-header border-0 py-5">
                                <h3 class="card-title align-items-center">
                                                <span class="card-label font-weight-bolder text-dark">Price
                                                    Information</span>
                                </h3>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body pt-0 pb-3">
                                <!--begin::Table-->
                                <div class="table-responsive">
                                    <table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_3">
                                        <tr>
                                            <th class="font_weight">Paid Amount</th>
                                            <td class="float_end">{{$orderItems->paid_amount}}</td>
                                        </tr>
                                        <tr>
                                            <th class="font_weight">Total Amount</th>
                                            <td class="float_end">{{$orderItems->total_price}}</td>
                                        </tr>

                                    </table>
                                </div>
                                <!--end::Table-->

                            </div>
                            <!--end::Body-->
                        </div>
                    </div>
                    @endif
                </div>
                <!--end::Advance Table Widget 3-->
            </div>
            <!--end::Container-->
            <!--Start::View Modal-->
            <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Vertical Blind (ID # 1023) </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">

                            <!--begin::Table-->
                            <div class="table-responsive">
                                <table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_3">
                                    <thead>
                                    <tr class="text-left text-uppercase">
                                        <th class="px-0">Order Name</th>
                                        <th>Quantity</th>
                                        <th class="text-info">Length</th>
                                        <th class="text-info">Width</th>
                                        <th>Measurement</th>
                                        <th>Fittings</th>
                                        <th style="min-width: 137px">Fittings Type</th>
                                        <th>Add items for Manucfacturing
                                        </th>
                                        <th class="pr-0 text-right" style="min-width: 160px">action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="pl-0">
                                            <a href="#" class="text-dark-75 font-weight-normal text-hover-primary mb-1 ">Blinds</a>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">2</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">10</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">20</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">cm</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">Exact</span>
                                        </td>
                                        <td>
                                                            <span class="text-dark-75 font-weight-normal d-block ">Bracket
                                                                to Bracket</span>
                                        </td>
                                        <td>
                                            <span class="label label-lg label-light-success label-inline">Pending</span>
                                        </td>
                                        <td class="text-right pr-0">

                                            <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Write.svg-->
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         width="24px" height="24px"
                                                                         viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1"
                                                                           fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24"
                                                                                  height="24" />
                                                                            <path
                                                                                d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z"
                                                                                fill="#000000" fill-rule="nonzero"
                                                                                transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)" />
                                                                            <path
                                                                                d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z"
                                                                                fill="#000000" fill-rule="nonzero"
                                                                                opacity="0.3" />
                                                                        </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                            </a>
                                            <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg-->
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                                            <path d="M12.8434797,16 L11.1565203,16 L10.9852159,16.6393167 C10.3352654,19.064965 7.84199997,20.5044524 5.41635172,19.8545019 C2.99070348,19.2045514 1.55121603,16.711286 2.20116652,14.2856378 L3.92086709,7.86762789 C4.57081758,5.44197964 7.06408298,4.00249219 9.48973122,4.65244268 C10.5421727,4.93444352 11.4089671,5.56345262 12,6.38338695 C12.5910329,5.56345262 13.4578273,4.93444352 14.5102688,4.65244268 C16.935917,4.00249219 19.4291824,5.44197964 20.0791329,7.86762789 L21.7988335,14.2856378 C22.448784,16.711286 21.0092965,19.2045514 18.5836483,19.8545019 C16.158,20.5044524 13.6647346,19.064965 13.0147841,16.6393167 L12.8434797,16 Z M17.4563502,18.1051865 C18.9630797,18.1051865 20.1845253,16.8377967 20.1845253,15.2743923 C20.1845253,13.7109878 18.9630797,12.4435981 17.4563502,12.4435981 C15.9496207,12.4435981 14.7281751,13.7109878 14.7281751,15.2743923 C14.7281751,16.8377967 15.9496207,18.1051865 17.4563502,18.1051865 Z M6.54364977,18.1051865 C8.05037928,18.1051865 9.27182488,16.8377967 9.27182488,15.2743923 C9.27182488,13.7109878 8.05037928,12.4435981 6.54364977,12.4435981 C5.03692026,12.4435981 3.81547465,13.7109878 3.81547465,15.2743923 C3.81547465,16.8377967 5.03692026,18.1051865 6.54364977,18.1051865 Z" fill="#000000"></path>
                                                                        </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                            </a>
                                            <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Trash.svg-->
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                                            <rect fill="#000000" opacity="0.3" x="11" y="5" width="2" height="14" rx="1"></rect>
                                                                            <path d="M6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 C4.90236893,18.3165825 4.90236893,17.6834175 5.29289322,17.2928932 L11.2928932,11.2928932 C11.6714722,10.9143143 12.2810586,10.9010687 12.6757246,11.2628459 L18.6757246,16.7628459 C19.0828436,17.1360383 19.1103465,17.7686056 18.7371541,18.1757246 C18.3639617,18.5828436 17.7313944,18.6103465 17.3242754,18.2371541 L12.0300757,13.3841378 L6.70710678,18.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 14.999999) scale(1, -1) translate(-12.000003, -14.999999)"></path>
                                                                        </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!--end::Table-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary font-weight-bold">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::View Modal-->
            <!--Start::View Modal-->
            <div class="modal fade" id="staticBackdrop1" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Vertical Blind (ID # 1023) </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">

                            <!--begin::Table-->
                            <div class="table-responsive">
                                <table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_3">
                                    <thead>
                                    <tr class="text-left text-uppercase">
                                        <th class="px-0">Order Name</th>
                                        <th>Quantity</th>
                                        <th class="text-info">Length</th>
                                        <th class="text-info">Width</th>
                                        <th>Measurement</th>
                                        <th>Fittings</th>
                                        <th style="min-width: 137px">Fittings Type</th>
                                        <th>Add items for Manucfacturing
                                        </th>
                                        <th class="pr-0 text-right" style="min-width: 160px">action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="pl-0">
                                            <a href="#" class="text-dark-75 font-weight-normal text-hover-primary mb-1 ">Blinds</a>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">2</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">10</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">20</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">cm</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">Exact</span>
                                        </td>
                                        <td>
                                                            <span class="text-dark-75 font-weight-normal d-block ">Bracket
                                                                to Bracket</span>
                                        </td>
                                        <td>
                                            <span class="label label-lg label-light-success label-inline">Pending</span>
                                        </td>
                                        <td class="text-right pr-0">

                                            <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Write.svg-->
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         width="24px" height="24px"
                                                                         viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1"
                                                                           fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24"
                                                                                  height="24" />
                                                                            <path
                                                                                d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z"
                                                                                fill="#000000" fill-rule="nonzero"
                                                                                transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)" />
                                                                            <path
                                                                                d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z"
                                                                                fill="#000000" fill-rule="nonzero"
                                                                                opacity="0.3" />
                                                                        </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                            </a>
                                            <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg-->
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                                            <path d="M12.8434797,16 L11.1565203,16 L10.9852159,16.6393167 C10.3352654,19.064965 7.84199997,20.5044524 5.41635172,19.8545019 C2.99070348,19.2045514 1.55121603,16.711286 2.20116652,14.2856378 L3.92086709,7.86762789 C4.57081758,5.44197964 7.06408298,4.00249219 9.48973122,4.65244268 C10.5421727,4.93444352 11.4089671,5.56345262 12,6.38338695 C12.5910329,5.56345262 13.4578273,4.93444352 14.5102688,4.65244268 C16.935917,4.00249219 19.4291824,5.44197964 20.0791329,7.86762789 L21.7988335,14.2856378 C22.448784,16.711286 21.0092965,19.2045514 18.5836483,19.8545019 C16.158,20.5044524 13.6647346,19.064965 13.0147841,16.6393167 L12.8434797,16 Z M17.4563502,18.1051865 C18.9630797,18.1051865 20.1845253,16.8377967 20.1845253,15.2743923 C20.1845253,13.7109878 18.9630797,12.4435981 17.4563502,12.4435981 C15.9496207,12.4435981 14.7281751,13.7109878 14.7281751,15.2743923 C14.7281751,16.8377967 15.9496207,18.1051865 17.4563502,18.1051865 Z M6.54364977,18.1051865 C8.05037928,18.1051865 9.27182488,16.8377967 9.27182488,15.2743923 C9.27182488,13.7109878 8.05037928,12.4435981 6.54364977,12.4435981 C5.03692026,12.4435981 3.81547465,13.7109878 3.81547465,15.2743923 C3.81547465,16.8377967 5.03692026,18.1051865 6.54364977,18.1051865 Z" fill="#000000"></path>
                                                                        </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                            </a>
                                            <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Trash.svg-->
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                                            <rect fill="#000000" opacity="0.3" x="11" y="5" width="2" height="14" rx="1"></rect>
                                                                            <path d="M6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 C4.90236893,18.3165825 4.90236893,17.6834175 5.29289322,17.2928932 L11.2928932,11.2928932 C11.6714722,10.9143143 12.2810586,10.9010687 12.6757246,11.2628459 L18.6757246,16.7628459 C19.0828436,17.1360383 19.1103465,17.7686056 18.7371541,18.1757246 C18.3639617,18.5828436 17.7313944,18.6103465 17.3242754,18.2371541 L12.0300757,13.3841378 L6.70710678,18.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 14.999999) scale(1, -1) translate(-12.000003, -14.999999)"></path>
                                                                        </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pl-0">
                                            <a href="#" class="text-dark-75 font-weight-normal text-hover-primary mb-1 ">Blinds</a>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">2</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">10</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">20</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">cm</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">Exact</span>
                                        </td>
                                        <td>
                                                            <span class="text-dark-75 font-weight-normal d-block ">Bracket
                                                                to Bracket</span>
                                        </td>
                                        <td>
                                            <span class="label label-lg label-light-success label-inline">Pending</span>
                                        </td>
                                        <td class="text-right pr-0">

                                            <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Write.svg-->
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         width="24px" height="24px"
                                                                         viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1"
                                                                           fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24"
                                                                                  height="24" />
                                                                            <path
                                                                                d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z"
                                                                                fill="#000000" fill-rule="nonzero"
                                                                                transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)" />
                                                                            <path
                                                                                d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z"
                                                                                fill="#000000" fill-rule="nonzero"
                                                                                opacity="0.3" />
                                                                        </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                            </a>
                                            <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg-->
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                                            <path d="M12.8434797,16 L11.1565203,16 L10.9852159,16.6393167 C10.3352654,19.064965 7.84199997,20.5044524 5.41635172,19.8545019 C2.99070348,19.2045514 1.55121603,16.711286 2.20116652,14.2856378 L3.92086709,7.86762789 C4.57081758,5.44197964 7.06408298,4.00249219 9.48973122,4.65244268 C10.5421727,4.93444352 11.4089671,5.56345262 12,6.38338695 C12.5910329,5.56345262 13.4578273,4.93444352 14.5102688,4.65244268 C16.935917,4.00249219 19.4291824,5.44197964 20.0791329,7.86762789 L21.7988335,14.2856378 C22.448784,16.711286 21.0092965,19.2045514 18.5836483,19.8545019 C16.158,20.5044524 13.6647346,19.064965 13.0147841,16.6393167 L12.8434797,16 Z M17.4563502,18.1051865 C18.9630797,18.1051865 20.1845253,16.8377967 20.1845253,15.2743923 C20.1845253,13.7109878 18.9630797,12.4435981 17.4563502,12.4435981 C15.9496207,12.4435981 14.7281751,13.7109878 14.7281751,15.2743923 C14.7281751,16.8377967 15.9496207,18.1051865 17.4563502,18.1051865 Z M6.54364977,18.1051865 C8.05037928,18.1051865 9.27182488,16.8377967 9.27182488,15.2743923 C9.27182488,13.7109878 8.05037928,12.4435981 6.54364977,12.4435981 C5.03692026,12.4435981 3.81547465,13.7109878 3.81547465,15.2743923 C3.81547465,16.8377967 5.03692026,18.1051865 6.54364977,18.1051865 Z" fill="#000000"></path>
                                                                        </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                            </a>
                                            <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Trash.svg-->
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                                            <rect fill="#000000" opacity="0.3" x="11" y="5" width="2" height="14" rx="1"></rect>
                                                                            <path d="M6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 C4.90236893,18.3165825 4.90236893,17.6834175 5.29289322,17.2928932 L11.2928932,11.2928932 C11.6714722,10.9143143 12.2810586,10.9010687 12.6757246,11.2628459 L18.6757246,16.7628459 C19.0828436,17.1360383 19.1103465,17.7686056 18.7371541,18.1757246 C18.3639617,18.5828436 17.7313944,18.6103465 17.3242754,18.2371541 L12.0300757,13.3841378 L6.70710678,18.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 14.999999) scale(1, -1) translate(-12.000003, -14.999999)"></path>
                                                                        </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pl-0">
                                            <a href="#" class="text-dark-75 font-weight-normal text-hover-primary mb-1 ">Blinds</a>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">2</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">10</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">20</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">cm</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">Exact</span>
                                        </td>
                                        <td>
                                                            <span class="text-dark-75 font-weight-normal d-block ">Bracket
                                                                to Bracket</span>
                                        </td>
                                        <td>
                                            <span class="label label-lg label-light-success label-inline">Pending</span>
                                        </td>
                                        <td class="text-right pr-0">

                                            <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Write.svg-->
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         width="24px" height="24px"
                                                                         viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1"
                                                                           fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24"
                                                                                  height="24" />
                                                                            <path
                                                                                d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z"
                                                                                fill="#000000" fill-rule="nonzero"
                                                                                transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)" />
                                                                            <path
                                                                                d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z"
                                                                                fill="#000000" fill-rule="nonzero"
                                                                                opacity="0.3" />
                                                                        </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                            </a>
                                            <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg-->
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                                            <path d="M12.8434797,16 L11.1565203,16 L10.9852159,16.6393167 C10.3352654,19.064965 7.84199997,20.5044524 5.41635172,19.8545019 C2.99070348,19.2045514 1.55121603,16.711286 2.20116652,14.2856378 L3.92086709,7.86762789 C4.57081758,5.44197964 7.06408298,4.00249219 9.48973122,4.65244268 C10.5421727,4.93444352 11.4089671,5.56345262 12,6.38338695 C12.5910329,5.56345262 13.4578273,4.93444352 14.5102688,4.65244268 C16.935917,4.00249219 19.4291824,5.44197964 20.0791329,7.86762789 L21.7988335,14.2856378 C22.448784,16.711286 21.0092965,19.2045514 18.5836483,19.8545019 C16.158,20.5044524 13.6647346,19.064965 13.0147841,16.6393167 L12.8434797,16 Z M17.4563502,18.1051865 C18.9630797,18.1051865 20.1845253,16.8377967 20.1845253,15.2743923 C20.1845253,13.7109878 18.9630797,12.4435981 17.4563502,12.4435981 C15.9496207,12.4435981 14.7281751,13.7109878 14.7281751,15.2743923 C14.7281751,16.8377967 15.9496207,18.1051865 17.4563502,18.1051865 Z M6.54364977,18.1051865 C8.05037928,18.1051865 9.27182488,16.8377967 9.27182488,15.2743923 C9.27182488,13.7109878 8.05037928,12.4435981 6.54364977,12.4435981 C5.03692026,12.4435981 3.81547465,13.7109878 3.81547465,15.2743923 C3.81547465,16.8377967 5.03692026,18.1051865 6.54364977,18.1051865 Z" fill="#000000"></path>
                                                                        </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                            </a>
                                            <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Trash.svg-->
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                                            <rect fill="#000000" opacity="0.3" x="11" y="5" width="2" height="14" rx="1"></rect>
                                                                            <path d="M6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 C4.90236893,18.3165825 4.90236893,17.6834175 5.29289322,17.2928932 L11.2928932,11.2928932 C11.6714722,10.9143143 12.2810586,10.9010687 12.6757246,11.2628459 L18.6757246,16.7628459 C19.0828436,17.1360383 19.1103465,17.7686056 18.7371541,18.1757246 C18.3639617,18.5828436 17.7313944,18.6103465 17.3242754,18.2371541 L12.0300757,13.3841378 L6.70710678,18.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 14.999999) scale(1, -1) translate(-12.000003, -14.999999)"></path>
                                                                        </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pl-0">
                                            <a href="#" class="text-dark-75 font-weight-normal text-hover-primary mb-1 ">Blinds</a>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">2</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">10</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">20</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">cm</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-normal d-block ">Exact</span>
                                        </td>
                                        <td>
                                                            <span class="text-dark-75 font-weight-normal d-block ">Bracket
                                                                to Bracket</span>
                                        </td>
                                        <td>
                                            <span class="label label-lg label-light-success label-inline">Pending</span>
                                        </td>
                                        <td class="text-right pr-0">

                                            <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Write.svg-->
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         width="24px" height="24px"
                                                                         viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1"
                                                                           fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24"
                                                                                  height="24" />
                                                                            <path
                                                                                d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z"
                                                                                fill="#000000" fill-rule="nonzero"
                                                                                transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)" />
                                                                            <path
                                                                                d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z"
                                                                                fill="#000000" fill-rule="nonzero"
                                                                                opacity="0.3" />
                                                                        </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                            </a>
                                            <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg-->
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                                            <path d="M12.8434797,16 L11.1565203,16 L10.9852159,16.6393167 C10.3352654,19.064965 7.84199997,20.5044524 5.41635172,19.8545019 C2.99070348,19.2045514 1.55121603,16.711286 2.20116652,14.2856378 L3.92086709,7.86762789 C4.57081758,5.44197964 7.06408298,4.00249219 9.48973122,4.65244268 C10.5421727,4.93444352 11.4089671,5.56345262 12,6.38338695 C12.5910329,5.56345262 13.4578273,4.93444352 14.5102688,4.65244268 C16.935917,4.00249219 19.4291824,5.44197964 20.0791329,7.86762789 L21.7988335,14.2856378 C22.448784,16.711286 21.0092965,19.2045514 18.5836483,19.8545019 C16.158,20.5044524 13.6647346,19.064965 13.0147841,16.6393167 L12.8434797,16 Z M17.4563502,18.1051865 C18.9630797,18.1051865 20.1845253,16.8377967 20.1845253,15.2743923 C20.1845253,13.7109878 18.9630797,12.4435981 17.4563502,12.4435981 C15.9496207,12.4435981 14.7281751,13.7109878 14.7281751,15.2743923 C14.7281751,16.8377967 15.9496207,18.1051865 17.4563502,18.1051865 Z M6.54364977,18.1051865 C8.05037928,18.1051865 9.27182488,16.8377967 9.27182488,15.2743923 C9.27182488,13.7109878 8.05037928,12.4435981 6.54364977,12.4435981 C5.03692026,12.4435981 3.81547465,13.7109878 3.81547465,15.2743923 C3.81547465,16.8377967 5.03692026,18.1051865 6.54364977,18.1051865 Z" fill="#000000"></path>
                                                                        </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                            </a>
                                            <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Trash.svg-->
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                                            <rect fill="#000000" opacity="0.3" x="11" y="5" width="2" height="14" rx="1"></rect>
                                                                            <path d="M6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 C4.90236893,18.3165825 4.90236893,17.6834175 5.29289322,17.2928932 L11.2928932,11.2928932 C11.6714722,10.9143143 12.2810586,10.9010687 12.6757246,11.2628459 L18.6757246,16.7628459 C19.0828436,17.1360383 19.1103465,17.7686056 18.7371541,18.1757246 C18.3639617,18.5828436 17.7313944,18.6103465 17.3242754,18.2371541 L12.0300757,13.3841378 L6.70710678,18.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 14.999999) scale(1, -1) translate(-12.000003, -14.999999)"></path>
                                                                        </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!--end::Table-->
                            <hr>
                            <div class=" row">
                                <div class="col-lg-1 col-1">
                                    <button class="btn btn-primary" onclick="addfield(0)">+</button>
                                </div>
                                <div class=" form-group col-lg-2 col-5">
                                    <select class="form-control">
                                        <option>Department</option>
                                    </select>
                                </div>
                                <div class=" form-group col-lg-2 col-5">
                                    <select class="form-control">
                                        <option>Fabric</option>
                                    </select>
                                </div>
                                <div class=" form-group col-lg-2 col-5 ml-auto">
                                    <select class="form-control">
                                        <option>Varient</option>
                                    </select>
                                </div>
                                <div class=" form-group col-lg-2 col-5 mr-auto">
                                    <select class="form-control">
                                        <option>Qty</option>
                                    </select>
                                </div>
                                <div class="row col-lg-3 col-10 ml-auto mr-auto">
                                    <div><button class="btn btn-primary">+</button></div>
                                    <input type="text " class="form-control datatable-input inc_dec col-lg-4 col-8" data-col-index="1 ">
                                    <div><button class="btn btn-primary">-</button></div>
                                </div>
                                <div id="newfield_0" class="col-lg-12"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary font-weight-bold">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::View Modal-->
        </div>
        <!--end::Entry-->
    </div>
    <!--end::Content-->
@endsection
