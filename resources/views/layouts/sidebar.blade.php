<!--begin::Aside-->
<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
    <!--begin::Brand-->
    <div class="brand flex-column-auto" id="kt_brand">
        <!--begin::Logo-->
        <a href="{{ route('home') }}" class="brand-logo">
            <img alt="Logo" src="{{ asset('assets/media/logos/logo-light.png') }}" />
        </a>
        <!--end::Logo-->
        <!--begin::Toggle-->
        <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
            <span class="svg-icon svg-icon svg-icon-xl">
                <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                    height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <path
                            d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z"
                            fill="#000000" fill-rule="nonzero"
                            transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
                        <path
                            d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z"
                            fill="#000000" fill-rule="nonzero" opacity="0.3"
                            transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>
        </button>
        <!--end::Toolbar-->
    </div>
    <!--end::Brand-->
    <!--begin::Aside Menu-->
    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
        <!--begin::Menu Container-->
        <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
            data-menu-dropdown-timeout="500">
            <!--begin::Menu Nav-->
            <ul class="menu-nav">
                <li class="menu-item  {{ Route::currentRouteName() == 'home' ? 'menu-item-active' : '' }}"
                    aria-haspopup="true">
                    <a href="{{ route('home') }}" class="menu-link">
                        <span class="svg-icon menu-icon">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24" />
                                    <path
                                        d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                        fill="#000000" fill-rule="nonzero" />
                                    <path
                                        d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                        fill="#000000" opacity="0.3" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
                @if (hasPermission('viewBooking'))
                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'slotList' || Route::currentRouteName() == 'bookingList' || Route::currentRouteName() == 'confirmedList' ? 'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                <span class="svg-icon svg-icon-primary svg-icon-2x">
                                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Shopping/Box2.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path
                                                d="M4,9.67471899 L10.880262,13.6470401 C10.9543486,13.689814 11.0320333,13.7207107 11.1111111,13.740321 L11.1111111,21.4444444 L4.49070127,17.526473 C4.18655139,17.3464765 4,17.0193034 4,16.6658832 L4,9.67471899 Z M20,9.56911707 L20,16.6658832 C20,17.0193034 19.8134486,17.3464765 19.5092987,17.526473 L12.8888889,21.4444444 L12.8888889,13.6728275 C12.9050191,13.6647696 12.9210067,13.6561758 12.9368301,13.6470401 L20,9.56911707 Z"
                                                fill="#000000" />
                                            <path
                                                d="M4.21611835,7.74669402 C4.30015839,7.64056877 4.40623188,7.55087574 4.5299008,7.48500698 L11.5299008,3.75665466 C11.8237589,3.60013944 12.1762411,3.60013944 12.4700992,3.75665466 L19.4700992,7.48500698 C19.5654307,7.53578262 19.6503066,7.60071528 19.7226939,7.67641889 L12.0479413,12.1074394 C11.9974761,12.1365754 11.9509488,12.1699127 11.9085461,12.2067543 C11.8661433,12.1699127 11.819616,12.1365754 11.7691509,12.1074394 L4.21611835,7.74669402 Z"
                                                fill="#000000" opacity="0.3" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-text">Bookings</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">Bookings</span>
                                    </span>
                                </li>
                                @if (hasPermission('viewTimeSlot'))

                                    <li class="menu-item {{ Route::currentRouteName() == 'slotList'  ? 'menu-item-active' : '' }} menu-item-submenu" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="{{ route('slotList') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Time Slot List</span>
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('viewBooking'))

                                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'bookingList'  ? 'menu-item-active' : '' }}" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="{{ route('bookingList') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Bookings List</span>
                                        </a>
                                    </li>
                                @endif
                                {{-- <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                <a href="{{route('bookingTaskList')}}" class="menu-link menu-toggle">
                                    <i class="menu-bullet menu-bullet-line">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Tasks List</span>
                                </a>
                            </li> --}}
                                @if (hasPermission('confirmedBooking'))

                                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'confirmedList'  ? 'menu-item-active' : '' }}" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="{{ route('confirmedList') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Rescheduled & Confirmed Booking</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
                @if (hasPermission('bookingtaskList'))

                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'bookingTaskList'  ? 'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="{{ route('bookingTaskList') }}" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                <span class="svg-icon svg-icon-primary svg-icon-2x">
                                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Shopping/Box2.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path d="M15,7 L15,8 C15,8.55228475 15.4477153,9 16,9 C16.5522847,9 17,8.55228475 17,8 L17,7 L19,7 L19,10 C19,10.5522847 19.4477153,11 20,11 C20.5522847,11 21,10.5522847 21,10 L21,7 C22.1045695,7 23,7.8954305 23,9 L23,15 C23,16.1045695 22.1045695,17 21,17 L3,17 C1.8954305,17 1,16.1045695 1,15 L1,9 C1,7.8954305 1.8954305,7 3,7 L3,10 C3,10.5522847 3.44771525,11 4,11 C4.55228475,11 5,10.5522847 5,10 L5,7 L7,7 L7,8 C7,8.55228475 7.44771525,9 8,9 C8.55228475,9 9,8.55228475 9,8 L9,7 L11,7 L11,10 C11,10.5522847 11.4477153,11 12,11 C12.5522847,11 13,10.5522847 13,10 L13,7 L15,7 Z" fill="#000000" transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) "/>
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-text">Measurement</span>
                            {{-- <i class="menu-arrow"></i> --}}
                        </a>
                        {{-- <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">Measurement</span>
                                    </span>
                                </li>

                                <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'bookingTaskList'  ? 'menu-item-active' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{ route('bookingTaskList') }}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Tasks List</span>
                                    </a>
                                </li>

                            </ul>
                        </div> --}}
                    </li>

                @endif

                @if (hasPermission('adminOrderList') || hasPermission('adminOrderList'))

                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'adminOrderList'  ? 'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="{{ route('adminOrderList') }}" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <path
                                            d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z"
                                            fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                        <path
                                            d="M3.28077641,9 L20.7192236,9 C21.2715083,9 21.7192236,9.44771525 21.7192236,10 C21.7192236,10.0817618 21.7091962,10.163215 21.6893661,10.2425356 L19.5680983,18.7276069 C19.234223,20.0631079 18.0342737,21 16.6576708,21 L7.34232922,21 C5.96572629,21 4.76577697,20.0631079 4.43190172,18.7276069 L2.31063391,10.2425356 C2.17668518,9.70674072 2.50244587,9.16380623 3.03824078,9.0298575 C3.11756139,9.01002735 3.1990146,9 3.28077641,9 Z M12,12 C11.4477153,12 11,12.4477153 11,13 L11,17 C11,17.5522847 11.4477153,18 12,18 C12.5522847,18 13,17.5522847 13,17 L13,13 C13,12.4477153 12.5522847,12 12,12 Z M6.96472382,12.1362967 C6.43125772,12.2792385 6.11467523,12.8275755 6.25761704,13.3610416 L7.29289322,17.2247449 C7.43583503,17.758211 7.98417199,18.0747935 8.51763809,17.9318517 C9.05110419,17.7889098 9.36768668,17.2405729 9.22474487,16.7071068 L8.18946869,12.8434035 C8.04652688,12.3099374 7.49818992,11.9933549 6.96472382,12.1362967 Z M17.0352762,12.1362967 C16.5018101,11.9933549 15.9534731,12.3099374 15.8105313,12.8434035 L14.7752551,16.7071068 C14.6323133,17.2405729 14.9488958,17.7889098 15.4823619,17.9318517 C16.015828,18.0747935 16.564165,17.758211 16.7071068,17.2247449 L17.742383,13.3610416 C17.8853248,12.8275755 17.5687423,12.2792385 17.0352762,12.1362967 Z"
                                            fill="#000000" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-text">Orders</span>
                            {{-- <i class="menu-arrow"></i> --}}
                        </a>
                        {{-- <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">Orders</span>
                                    </span>
                                </li>
                                @if (hasPermission('adminOrderList'))
                                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'adminOrderList'  ? 'menu-item-active' : '' }}" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="{{ route('adminOrderList') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">List</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div> --}}
                    </li>
                @endif
                @if (hasPermission('orderList'))

                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'orderList' || Route::currentRouteName() == 'confirmedOrderList' ? 'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path d="M14.8890873,14.1109127 C11.8515212,14.1109127 9.3890873,11.6484788 9.3890873,8.6109127 C9.3890873,5.57334658 11.8515212,3.1109127 14.8890873,3.1109127 C17.9266534,3.1109127 20.3890873,5.57334658 20.3890873,8.6109127 C20.3890873,11.6484788 17.9266534,14.1109127 14.8890873,14.1109127 Z M14.8890873,10.6109127 C15.9936568,10.6109127 16.8890873,9.7154822 16.8890873,8.6109127 C16.8890873,7.5063432 15.9936568,6.6109127 14.8890873,6.6109127 C13.7845178,6.6109127 12.8890873,7.5063432 12.8890873,8.6109127 C12.8890873,9.7154822 13.7845178,10.6109127 14.8890873,10.6109127 Z M14.8890873,9.6109127 C15.441372,9.6109127 15.8890873,9.16319745 15.8890873,8.6109127 C15.8890873,8.05862795 15.441372,7.6109127 14.8890873,7.6109127 C14.3368025,7.6109127 13.8890873,8.05862795 13.8890873,8.6109127 C13.8890873,9.16319745 14.3368025,9.6109127 14.8890873,9.6109127 Z" fill="#000000" opacity="0.3" transform="translate(14.889087, 8.610913) rotate(-405.000000) translate(-14.889087, -8.610913) "/>
                                        <rect fill="#000000" opacity="0.3" transform="translate(9.232233, 14.974874) rotate(-45.000000) translate(-9.232233, -14.974874) " x="1.23223305" y="11.9748737" width="16" height="6" rx="3"/>
                                        <path d="M16.267767,18.0822059 C12.2738464,17.3873004 9.26776695,14.3606699 9.26776695,10.732233 C9.26776695,7.10379618 12.2738464,4.07716572 16.267767,3.38226022 L16.267767,18.0822059 Z" fill="#000000" transform="translate(12.767767, 10.732233) rotate(-405.000000) translate(-12.767767, -10.732233) "/>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-text">Production Orders</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">Production Orders</span>
                                    </span>
                                </li>
                                @if (hasPermission('pendingOrder'))
                                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'orderList'  ? 'menu-item-active' : '' }}" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="{{ route('orderList') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Pending List</span>
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('confirmedOrder'))
                                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'confirmedOrderList'  ? 'menu-item-active' : '' }}" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="{{ route('confirmedOrderList') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Confirmed List</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
                @if (hasPermission('assemblerOrderList'))
                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'assembledOrderList' || Route::currentRouteName() == 'assembledOrderAssigned' ? 'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path d="M20.4061385,6.73606154 C20.7672665,6.89656288 21,7.25468437 21,7.64987309 L21,16.4115967 C21,16.7747638 20.8031081,17.1093844 20.4856429,17.2857539 L12.4856429,21.7301984 C12.1836204,21.8979887 11.8163796,21.8979887 11.5143571,21.7301984 L3.51435707,17.2857539 C3.19689188,17.1093844 3,16.7747638 3,16.4115967 L3,7.64987309 C3,7.25468437 3.23273352,6.89656288 3.59386153,6.73606154 L11.5938615,3.18050598 C11.8524269,3.06558805 12.1475731,3.06558805 12.4061385,3.18050598 L20.4061385,6.73606154 Z" fill="#000000" opacity="0.3"/>
                                        <polygon fill="#000000" points="14.9671522 4.22441676 7.5999999 8.31727912 7.5999999 12.9056825 9.5999999 13.9056825 9.5999999 9.49408582 17.25507 5.24126912"/>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-text">Assembeld Order</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">Assembeld Order</span>
                                    </span>
                                </li>
                                @if (hasPermission('assemblerOrderDetail'))
                                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'assembledOrderList'  ? 'menu-item-active' : '' }}" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="{{ route('assembledOrderList') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Order List</span>
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('assemblerUsers'))
                                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'assembledOrderAssigned'  ? 'menu-item-active' : '' }}" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="{{ route('assembledOrderAssigned') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Assigned User List</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
                @if (hasPermission('packagingOrderList'))

                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'packagedOrderList' || Route::currentRouteName() == 'packagedOrderAssigned' ? 'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path d="M5.84026576,8 L18.1597342,8 C19.1999115,8 20.0664437,8.79732479 20.1528258,9.83390904 L20.8194924,17.833909 C20.9112219,18.9346631 20.0932459,19.901362 18.9924919,19.9930915 C18.9372479,19.9976952 18.8818364,20 18.8264009,20 L5.1735991,20 C4.0690296,20 3.1735991,19.1045695 3.1735991,18 C3.1735991,17.9445645 3.17590391,17.889153 3.18050758,17.833909 L3.84717425,9.83390904 C3.93355627,8.79732479 4.80008849,8 5.84026576,8 Z M10.5,10 C10.2238576,10 10,10.2238576 10,10.5 L10,11.5 C10,11.7761424 10.2238576,12 10.5,12 L13.5,12 C13.7761424,12 14,11.7761424 14,11.5 L14,10.5 C14,10.2238576 13.7761424,10 13.5,10 L10.5,10 Z" fill="#000000"/>
                                        <path d="M10,8 L8,8 L8,7 C8,5.34314575 9.34314575,4 11,4 L13,4 C14.6568542,4 16,5.34314575 16,7 L16,8 L14,8 L14,7 C14,6.44771525 13.5522847,6 13,6 L11,6 C10.4477153,6 10,6.44771525 10,7 L10,8 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-text">Packaged Order</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">

                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">Packaged Order</span>
                                    </span>
                                </li>
                                @if (hasPermission('packagingOrderDetail'))
                                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'packagedOrderList'  ? 'menu-item-active' : '' }}" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="{{ route('packagedOrderList') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Order List</span>
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('packagingUsers'))
                                    <li class="menu-item menu-item-submenu" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="{{ route('packagedOrderAssigned') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Assigned User List</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
                @if (hasPermission('installationOrderList'))
                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'installationOrderList' || Route::currentRouteName() == 'installationOrderAssigned' ? 'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path d="M15.9497475,3.80761184 L13.0246125,6.73274681 C12.2435639,7.51379539 12.2435639,8.78012535 13.0246125,9.56117394 L14.4388261,10.9753875 C15.2198746,11.7564361 16.4862046,11.7564361 17.2672532,10.9753875 L20.1923882,8.05025253 C20.7341101,10.0447871 20.2295941,12.2556873 18.674559,13.8107223 C16.8453326,15.6399488 14.1085592,16.0155296 11.8839934,14.9444337 L6.75735931,20.0710678 C5.97631073,20.8521164 4.70998077,20.8521164 3.92893219,20.0710678 C3.1478836,19.2900192 3.1478836,18.0236893 3.92893219,17.2426407 L9.05556629,12.1160066 C7.98447038,9.89144078 8.36005124,7.15466739 10.1892777,5.32544095 C11.7443127,3.77040588 13.9552129,3.26588995 15.9497475,3.80761184 Z" fill="#000000"/>
                                        <path d="M16.6568542,5.92893219 L18.0710678,7.34314575 C18.4615921,7.73367004 18.4615921,8.36683502 18.0710678,8.75735931 L16.6913928,10.1370344 C16.3008685,10.5275587 15.6677035,10.5275587 15.2771792,10.1370344 L13.8629656,8.7228208 C13.4724413,8.33229651 13.4724413,7.69913153 13.8629656,7.30860724 L15.2426407,5.92893219 C15.633165,5.5384079 16.26633,5.5384079 16.6568542,5.92893219 Z" fill="#000000" opacity="0.3"/>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-text">Installation Order</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">Installation Order</span>
                                    </span>
                                </li>
                                @if (hasPermission('installationOrderList'))

                                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'installationOrderList'  ? 'menu-item-active' : '' }}" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="{{ route('installationOrderList') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Order List</span>
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('installationUsers'))

                                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'installationOrderAssigned'  ? 'menu-item-active' : '' }}" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="{{ route('installationOrderAssigned') }}"
                                            class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Assigned User List</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
                @if (hasPermission('accountantOrderList'))

                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'accountantOrderList' ? 'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <path
                                            d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z"
                                            fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                        <path
                                            d="M3.28077641,9 L20.7192236,9 C21.2715083,9 21.7192236,9.44771525 21.7192236,10 C21.7192236,10.0817618 21.7091962,10.163215 21.6893661,10.2425356 L19.5680983,18.7276069 C19.234223,20.0631079 18.0342737,21 16.6576708,21 L7.34232922,21 C5.96572629,21 4.76577697,20.0631079 4.43190172,18.7276069 L2.31063391,10.2425356 C2.17668518,9.70674072 2.50244587,9.16380623 3.03824078,9.0298575 C3.11756139,9.01002735 3.1990146,9 3.28077641,9 Z M12,12 C11.4477153,12 11,12.4477153 11,13 L11,17 C11,17.5522847 11.4477153,18 12,18 C12.5522847,18 13,17.5522847 13,17 L13,13 C13,12.4477153 12.5522847,12 12,12 Z M6.96472382,12.1362967 C6.43125772,12.2792385 6.11467523,12.8275755 6.25761704,13.3610416 L7.29289322,17.2247449 C7.43583503,17.758211 7.98417199,18.0747935 8.51763809,17.9318517 C9.05110419,17.7889098 9.36768668,17.2405729 9.22474487,16.7071068 L8.18946869,12.8434035 C8.04652688,12.3099374 7.49818992,11.9933549 6.96472382,12.1362967 Z M17.0352762,12.1362967 C16.5018101,11.9933549 15.9534731,12.3099374 15.8105313,12.8434035 L14.7752551,16.7071068 C14.6323133,17.2405729 14.9488958,17.7889098 15.4823619,17.9318517 C16.015828,18.0747935 16.564165,17.758211 16.7071068,17.2247449 L17.742383,13.3610416 C17.8853248,12.8275755 17.5687423,12.2792385 17.0352762,12.1362967 Z"
                                            fill="#000000" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-text">Accountant Order</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">Accountant Order</span>
                                    </span>
                                </li>
                                @if (hasPermission('accountantOrderList'))
                                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'accountantOrderList'  ? 'menu-item-active' : '' }}" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="{{ route('accountantOrderList') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Order List</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
                @if (hasPermission('viewZip'))
                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'zipList' ? 'menu-item-open' : '' }}"
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="{{ route('zipList') }}" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path d="M9.82829464,16.6565893 C7.02541569,15.7427556 5,13.1079084 5,10 C5,6.13400675 8.13400675,3 12,3 C15.8659932,3 19,6.13400675 19,10 C19,13.1079084 16.9745843,15.7427556 14.1717054,16.6565893 L12,21 L9.82829464,16.6565893 Z M12,12 C13.1045695,12 14,11.1045695 14,10 C14,8.8954305 13.1045695,8 12,8 C10.8954305,8 10,8.8954305 10,10 C10,11.1045695 10.8954305,12 12,12 Z" fill="#000000"/>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-text">Post Code</span>
                            {{-- <i class="menu-arrow"></i> --}}
                        </a>
                        {{-- <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent " aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">List</span>
                                    </span>
                                </li>
                                <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'zipList'  ? 'menu-item-active' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{ route('zipList') }}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">List</span>
                                    </a>
                                </li>

                            </ul>
                        </div> --}}
                    </li>
                @endif
                @if (hasPermission('viewUser') || hasPermission('viewCategory') || hasPermission('viewPermission') || hasPermission('viewRole'))
                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'userList' || Route::currentRouteName() == 'categoryList' || Route::currentRouteName() == 'permissionList' || Route::currentRouteName() == 'roleList' ? 'menu-item-open' : '' }}"
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <path
                                            d="M9,15 L7.5,15 C6.67157288,15 6,15.6715729 6,16.5 C6,17.3284271 6.67157288,18 7.5,18 C8.32842712,18 9,17.3284271 9,16.5 L9,15 Z M9,15 L9,9 L15,9 L15,15 L9,15 Z M15,16.5 C15,17.3284271 15.6715729,18 16.5,18 C17.3284271,18 18,17.3284271 18,16.5 C18,15.6715729 17.3284271,15 16.5,15 L15,15 L15,16.5 Z M16.5,9 C17.3284271,9 18,8.32842712 18,7.5 C18,6.67157288 17.3284271,6 16.5,6 C15.6715729,6 15,6.67157288 15,7.5 L15,9 L16.5,9 Z M9,7.5 C9,6.67157288 8.32842712,6 7.5,6 C6.67157288,6 6,6.67157288 6,7.5 C6,8.32842712 6.67157288,9 7.5,9 L9,9 L9,7.5 Z M11,13 L13,13 L13,11 L11,11 L11,13 Z M13,11 L13,7.5 C13,5.56700338 14.5670034,4 16.5,4 C18.4329966,4 20,5.56700338 20,7.5 C20,9.43299662 18.4329966,11 16.5,11 L13,11 Z M16.5,13 C18.4329966,13 20,14.5670034 20,16.5 C20,18.4329966 18.4329966,20 16.5,20 C14.5670034,20 13,18.4329966 13,16.5 L13,13 L16.5,13 Z M11,16.5 C11,18.4329966 9.43299662,20 7.5,20 C5.56700338,20 4,18.4329966 4,16.5 C4,14.5670034 5.56700338,13 7.5,13 L11,13 L11,16.5 Z M7.5,11 C5.56700338,11 4,9.43299662 4,7.5 C4,5.56700338 5.56700338,4 7.5,4 C9.43299662,4 11,5.56700338 11,7.5 L11,11 L7.5,11 Z"
                                            fill="#000000" fill-rule="nonzero" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-text">Users Role & Permission</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">Users Role & Permission</span>
                                    </span>
                                </li>
                                <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'userList'  ? 'menu-item-active' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{ route('userList') }}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Users List</span>
                                    </a>
                                </li>
                                @if (haspermission('viewCategory'))
                                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'categoryList'  ? 'menu-item-active' : '' }}" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="{{ route('categoryList') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Category</span>
                                        </a>
                                    </li>
                                @endif
                                @if (haspermission('viewPermission'))
                                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'permissionList'  ? 'menu-item-active' : '' }}" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="{{ route('permissionList') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Permissions</span>
                                        </a>
                                    </li>
                                @endif
                                @if (haspermission('viewRole'))
                                    <li class="menu-item menu-item-submenu" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="{{ route('roleList') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Role List</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
                @if (hasPermission('viewDepartment') || hasPermission('departmentTaskList'))
                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'departmentList' || Route::currentRouteName()  == 'tasksList' ? 'menu-item-open' : '' }}"
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                <span class="svg-icon svg-icon-primary svg-icon-2x">
                                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Shopping/Box2.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <rect fill="#000000" opacity="0.3" x="3" y="3" width="18" height="18" rx="1"/>
                                            <path d="M11,11 L11,13 L13,13 L13,11 L11,11 Z M10,9 L14,9 C14.5522847,9 15,9.44771525 15,10 L15,14 C15,14.5522847 14.5522847,15 14,15 L10,15 C9.44771525,15 9,14.5522847 9,14 L9,10 C9,9.44771525 9.44771525,9 10,9 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                            <rect fill="#000000" opacity="0.3" x="5" y="5" width="2" height="2" rx="0.5"/>
                                            <rect fill="#000000" opacity="0.3" x="5" y="9" width="2" height="2" rx="0.5"/>
                                            <rect fill="#000000" opacity="0.3" x="5" y="13" width="2" height="2" rx="0.5"/>
                                            <rect fill="#000000" opacity="0.3" x="9" y="5" width="2" height="2" rx="0.5"/>
                                            <rect fill="#000000" opacity="0.3" x="13" y="5" width="2" height="2" rx="0.5"/>
                                            <rect fill="#000000" opacity="0.3" x="17" y="5" width="2" height="2" rx="0.5"/>
                                            <rect fill="#000000" opacity="0.3" x="17" y="9" width="2" height="2" rx="0.5"/>
                                            <rect fill="#000000" opacity="0.3" x="17" y="13" width="2" height="2" rx="0.5"/>
                                            <rect fill="#000000" opacity="0.3" x="5" y="17" width="2" height="2" rx="0.5"/>
                                            <rect fill="#000000" opacity="0.3" x="9" y="17" width="2" height="2" rx="0.5"/>
                                            <rect fill="#000000" opacity="0.3" x="13" y="17" width="2" height="2" rx="0.5"/>
                                            <rect fill="#000000" opacity="0.3" x="17" y="17" width="2" height="2" rx="0.5"/>
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-text">Departments</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">Departments</span>
                                    </span>
                                </li>
                                @if (hasPermission('viewDepartment'))

                                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'departmentList'  ? 'menu-item-active' : '' }}" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="{{ route('departmentList') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Department List</span>
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('departmentTaskList'))
                                    <li class="menu-item menu-item-submenu" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="{{ route('tasksList') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Task List</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
                @if (hasPermission('viewItem') || hasPermission('viewVariant') || hasPermission('viewSupplier') || hasPermission('viewStockPurchase'))
                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'itemList' || Route::currentRouteName() == 'variantList' || Route::currentRouteName() == 'supplierList' || Route::currentRouteName() == 'stockList' ? 'menu-item-open' : '' }}"
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <path
                                            d="M4,7 L20,7 L20,19.5 C20,20.3284271 19.3284271,21 18.5,21 L5.5,21 C4.67157288,21 4,20.3284271 4,19.5 L4,7 Z M10,10 C9.44771525,10 9,10.4477153 9,11 C9,11.5522847 9.44771525,12 10,12 L14,12 C14.5522847,12 15,11.5522847 15,11 C15,10.4477153 14.5522847,10 14,10 L10,10 Z"
                                            fill="#000000" />
                                        <rect fill="#000000" opacity="0.3" x="2" y="3" width="20" height="4" rx="1" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-text">Stock</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'itemList'  ? 'menu-item-active' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{ route('itemList') }}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Item List</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'variantList'  ? 'menu-item-active' : '' }}" aria-haspopup="true" data-menu-toggle="hover">

                                    <a href="{{ route('variantList') }} " class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Variant List</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'supplierList'  ? 'menu-item-active' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{ route('supplierList') }}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Supplier List</span>

                                    </a>
                                </li>
                                <li class="menu-item menu-item-parent " aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">Stock</span>
                                    </span>
                                </li>
                                <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'stockList'  ? 'menu-item-active' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{ route('stockList') }}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Stock List</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif
                @if (hasPermission('inventoryList') || hasPermission('ProductInventoryList'))
                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'inventoryList'  ? 'menu-item-open' : '' }}"  aria-haspopup="true" data-menu-toggle="hover">
                        <a href="{{ route('inventoryList') }}" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                <span class="svg-icon svg-icon-primary svg-icon-2x">
                                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Shopping/Box2.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <rect fill="#000000" opacity="0.3" x="4" y="4" width="4" height="4" rx="2"/>
                                            <rect fill="#000000" x="4" y="10" width="4" height="4" rx="2"/>
                                            <rect fill="#000000" x="10" y="4" width="4" height="4" rx="2"/>
                                            <rect fill="#000000" x="10" y="10" width="4" height="4" rx="2"/>
                                            <rect fill="#000000" x="16" y="4" width="4" height="4" rx="2"/>
                                            <rect fill="#000000" x="16" y="10" width="4" height="4" rx="2"/>
                                            <rect fill="#000000" x="4" y="16" width="4" height="4" rx="2"/>
                                            <rect fill="#000000" x="10" y="16" width="4" height="4" rx="2"/>
                                            <rect fill="#000000" x="16" y="16" width="4" height="4" rx="2"/>
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-text">Inventory</span>
                            {{-- <i class="menu-arrow"></i> --}}
                        </a>
                        {{-- <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">Inventory</span>
                                    </span>
                                </li>
                                @if (hasPermission('ProductInventoryList'))
                                    <li class="menu-item menu-item-submenu {{ Route::currentRouteName() == 'inventoryList'  ? 'menu-item-open' : '' }}" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="{{ route('inventoryList') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Inventory List</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div> --}}
                    </li>
                @endif
            </ul>
            <!--end::Menu Nav-->
        </div>
        <!--end::Menu Container-->
    </div>
    <!--end::Aside Menu-->
</div>
<!--end::Aside-->
<!--begin::Wrapper-->

<!--end::Wrapper-->
