@extends('layouts.app')
@section('title', 'Home')
@section('content')
    <div class="container">
        <div class="">
            <div class="pt-8 pb-0">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="card card-custom gutter-b shadow" style="height: 150px">
                            <div class="card-body">
                                <span class="svg-icon svg-icon-3x svg-icon-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <path
                                                d="M4,9.67471899 L10.880262,13.6470401 C10.9543486,13.689814 11.0320333,13.7207107 11.1111111,13.740321 L11.1111111,21.4444444 L4.49070127,17.526473 C4.18655139,17.3464765 4,17.0193034 4,16.6658832 L4,9.67471899 Z M20,9.56911707 L20,16.6658832 C20,17.0193034 19.8134486,17.3464765 19.5092987,17.526473 L12.8888889,21.4444444 L12.8888889,13.6728275 C12.9050191,13.6647696 12.9210067,13.6561758 12.9368301,13.6470401 L20,9.56911707 Z"
                                                fill="#000000"></path>
                                            <path
                                                d="M4.21611835,7.74669402 C4.30015839,7.64056877 4.40623188,7.55087574 4.5299008,7.48500698 L11.5299008,3.75665466 C11.8237589,3.60013944 12.1762411,3.60013944 12.4700992,3.75665466 L19.4700992,7.48500698 C19.5654307,7.53578262 19.6503066,7.60071528 19.7226939,7.67641889 L12.0479413,12.1074394 C11.9974761,12.1365754 11.9509488,12.1699127 11.9085461,12.2067543 C11.8661433,12.1699127 11.819616,12.1365754 11.7691509,12.1074394 L4.21611835,7.74669402 Z"
                                                fill="#000000" opacity="0.3"></path>
                                        </g>
                                    </svg>
                                </span>
                                <div class="text-dark font-weight-bolder font-size-h2 mt-3">{{isset($totalBookings) && !empty($totalBookings) && $totalBookings > 9 ? $totalBookings : '0'.$totalBookings  }}</div>
                                <p class="text-primary font-weight-bolder font-size-lg mt-1">Total Bookings</p>
                            </div>
                        </div>
                    </div>
                    @if(hasPermission('viewUser'))
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="card card-custom gutter-b shadow" style="height: 150px">
                            <div class="card-body">
                                <span class="svg-icon svg-icon-3x svg-icon-success">
                                     <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                            <path
                                                d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                                fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                            <path
                                                d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                                fill="#000000" fill-rule="nonzero"></path>
                                        </g>
                                    </svg>
                                </span>
                                <div class="text-dark font-weight-bolder font-size-h2 mt-3">{{isset($totalUsers) && !empty($totalUsers) && $totalUsers > 9 ? $totalUsers : '0'.$totalUsers  }}</div>
                                <p class="text-primary font-weight-bolder font-size-lg mt-1">Total Users</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if(hasPermission('orderList'))
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="card card-custom gutter-b shadow" style="height: 150px">
                            <div class="card-body">
                                <span class="svg-icon svg-icon-3x svg-icon-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <path
                                            d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z"
                                            fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                        <path
                                            d="M3.28077641,9 L20.7192236,9 C21.2715083,9 21.7192236,9.44771525 21.7192236,10 C21.7192236,10.0817618 21.7091962,10.163215 21.6893661,10.2425356 L19.5680983,18.7276069 C19.234223,20.0631079 18.0342737,21 16.6576708,21 L7.34232922,21 C5.96572629,21 4.76577697,20.0631079 4.43190172,18.7276069 L2.31063391,10.2425356 C2.17668518,9.70674072 2.50244587,9.16380623 3.03824078,9.0298575 C3.11756139,9.01002735 3.1990146,9 3.28077641,9 Z M12,12 C11.4477153,12 11,12.4477153 11,13 L11,17 C11,17.5522847 11.4477153,18 12,18 C12.5522847,18 13,17.5522847 13,17 L13,13 C13,12.4477153 12.5522847,12 12,12 Z M6.96472382,12.1362967 C6.43125772,12.2792385 6.11467523,12.8275755 6.25761704,13.3610416 L7.29289322,17.2247449 C7.43583503,17.758211 7.98417199,18.0747935 8.51763809,17.9318517 C9.05110419,17.7889098 9.36768668,17.2405729 9.22474487,16.7071068 L8.18946869,12.8434035 C8.04652688,12.3099374 7.49818992,11.9933549 6.96472382,12.1362967 Z M17.0352762,12.1362967 C16.5018101,11.9933549 15.9534731,12.3099374 15.8105313,12.8434035 L14.7752551,16.7071068 C14.6323133,17.2405729 14.9488958,17.7889098 15.4823619,17.9318517 C16.015828,18.0747935 16.564165,17.758211 16.7071068,17.2247449 L17.742383,13.3610416 C17.8853248,12.8275755 17.5687423,12.2792385 17.0352762,12.1362967 Z"
                                            fill="#000000"></path>
                                    </g>
                                </svg>
                                </span>
                                <div class="text-dark font-weight-bolder font-size-h2 mt-3">{{isset($totalOrders) && !empty($totalOrders) && $totalOrders > 9 ? $totalOrders : '0'.$totalOrders  }}</div>
                                <p class="text-primary font-weight-bolder font-size-lg mt-1">Total Orders</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if(hasPermission('viewDepartment'))
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="card card-custom gutter-b shadow" style="height: 150px">
                            <div class="card-body">
                                <span class="svg-icon svg-icon-3x svg-icon-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <rect fill="#000000" opacity="0.3" x="3" y="3" width="18" height="18" rx="1" />
                                            <path
                                                d="M11,11 L11,13 L13,13 L13,11 L11,11 Z M10,9 L14,9 C14.5522847,9 15,9.44771525 15,10 L15,14 C15,14.5522847 14.5522847,15 14,15 L10,15 C9.44771525,15 9,14.5522847 9,14 L9,10 C9,9.44771525 9.44771525,9 10,9 Z"
                                                fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                            <rect fill="#000000" opacity="0.3" x="5" y="5" width="2" height="2" rx="0.5" />
                                            <rect fill="#000000" opacity="0.3" x="5" y="9" width="2" height="2" rx="0.5" />
                                            <rect fill="#000000" opacity="0.3" x="5" y="13" width="2" height="2" rx="0.5" />
                                            <rect fill="#000000" opacity="0.3" x="9" y="5" width="2" height="2" rx="0.5" />
                                            <rect fill="#000000" opacity="0.3" x="13" y="5" width="2" height="2" rx="0.5" />
                                            <rect fill="#000000" opacity="0.3" x="17" y="5" width="2" height="2" rx="0.5" />
                                            <rect fill="#000000" opacity="0.3" x="17" y="9" width="2" height="2" rx="0.5" />
                                            <rect fill="#000000" opacity="0.3" x="17" y="13" width="2" height="2"
                                                rx="0.5" />
                                            <rect fill="#000000" opacity="0.3" x="5" y="17" width="2" height="2" rx="0.5" />
                                            <rect fill="#000000" opacity="0.3" x="9" y="17" width="2" height="2" rx="0.5" />
                                            <rect fill="#000000" opacity="0.3" x="13" y="17" width="2" height="2"
                                                rx="0.5" />
                                            <rect fill="#000000" opacity="0.3" x="17" y="17" width="2" height="2"
                                                rx="0.5" />
                                        </g>
                                    </svg>
                                </span>
                                <div class="text-dark font-weight-bolder font-size-h2 mt-3">{{isset($totalDepartments) && !empty($totalDepartments) && $totalDepartments > 9 ? $totalDepartments : '0'.$totalDepartments  }}</div>
                                <p class="text-primary font-weight-bolder font-size-lg mt-1">Total Departments
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
