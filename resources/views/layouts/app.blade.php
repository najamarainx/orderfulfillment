<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->

<head>
    <base href="">
    <meta charset="utf-8" />
    <title>{{ config('app.name', 'PremiumBlindsUk') }} | @yield('title')</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <!--end::Page Vendors Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{ asset('assets/css/themes/layout/header/base/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/themes/layout/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/themes/layout/brand/dark.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/themes/layout/aside/dark.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="{{ asset('assets/media/favicon/favicon.ico') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('page_level_css')
    @yield('page_level_css_plugin')
    @php $statusArray = ['not called', 'confirmed', 'rescheduled', 'not respond', 'cancelled'];
    @endphp
</head>

<body id="kt_body"
    class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
        <!--begin::Logo-->
        <a href="index.html">
            <img alt="Logo" src="assets/media/logos/logo-light.png" />
        </a>
        <!--end::Logo-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <!--begin::Aside Mobile Toggle-->
            <button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
                <span></span>
            </button>
            <!--end::Aside Mobile Toggle-->
            <!--begin::Header Menu Mobile Toggle-->
            <button class="btn p-0 burger-icon ml-4" id="kt_header_mobile_toggle">
                <span></span>
            </button>
            <!--end::Header Menu Mobile Toggle-->
            <!--begin::Topbar Mobile Toggle-->
            <button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
                <span class="svg-icon svg-icon-xl">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24" />
                            <path
                                d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                fill="#000000" fill-rule="nonzero" opacity="0.3" />
                            <path
                                d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                fill="#000000" fill-rule="nonzero" />
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
            </button>
            <!--end::Topbar Mobile Toggle-->
        </div>
        <!--end::Toolbar-->
    </div>
    @include('layouts.sidebar');

    <!--begin::Page-->
    <div class="d-flex flex-row flex-column-fluid page">
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
            @include('layouts.header')
            @include('layouts.subheader')
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <div class="d-flex flex-column-fluid">
                    <!--begin::Container-->
                    <div class="container">

                        <!--begin::Entry-->
                        @yield('content')
                        <!--end::Entry-->


                    </div>
                    <!--end::Container-->
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>

    @include('layouts.common.quick_panel')
    @include('layouts.common.quick_user_panel')
    <div class="modal fade show" id="statusModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-modal="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form onsubmit="return false" id="updateStatusForm">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <p class="status_text"></p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="hidden" name="booking_id" id="booking_id">
                                    <label for="">Select Status:</label>
                                    <select name="booking_status" id="booking_status" class="form-control">
                                        @foreach ($statusArray as $status)
                                            <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6 col-sm-12 pl-lg-6 pl-md-6 resceduled_html"
                                style="display: none">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-4">
                                            <label class="mb-0">Select Category</label>
                                            @if (isset($categories) && !$categories->isEmpty())
                                                <select
                                                    class="form-control form-control-lg  kt_select2_1 w-100 category_id"
                                                    data-live-search="true" name="category_id" id="cat_id">
                                                    <option value=""></option>
                                                    @foreach ($categories as $catObj)
                                                        <option value="{{ $catObj->id }}">{{ $catObj->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group mb-4">
                                            <label>Select Date: </label>
                                            <input class="form-group mb-4 date selected_date" id="datepickers"
                                                name="date" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-4">
                                            <label>Zip Code: </label>
                                            <select class="form-control form-control-lg  kt_select2_1 w-100 zip_code"
                                                data-live-search="true" name="zip_code" id="zip_code_id">
                                                @if (!empty($zipCode))
                                                    <option value=""></option>
                                                    @foreach ($zipCode as $zipObj)
                                                        <option value="{{ $zipObj->id }}">{{ $zipObj->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <p class="text-danger slot_error"></p>
                                        <div class="selected_zip_code_time_slot_html time_slot_html">
                                            @if (isset($timeSlotHtml))
                                                {!! $timeSlotHtml !!}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-light-primary font-weight-bold"
                                data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary font-weight-bold btn_save"
                                id="update_stauts_btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>


<!--begin::Global Config(global config for global JS scripts)-->
<script>
    var KTAppSettings = {
        "breakpoints": {
            "sm": 576,
            "md": 768,
            "lg": 992,
            "xl": 1200,
            "xxl": 1400
        },
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#3699FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#E4E6EF",
                    "dark": "#181C32"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1F0FF",
                    "secondary": "#EBEDF3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#3F4254",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#EBEDF3",
                "gray-300": "#E4E6EF",
                "gray-400": "#D1D3E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#7E8299",
                "gray-700": "#5E6278",
                "gray-800": "#3F4254",
                "gray-900": "#181C32"
            }
        },
        "font-family": "Poppins"
    };
</script>
<!--end::Global Config-->
<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<!--end::Global Theme Bundle-->
<!--begin::Page Scripts(used by this page)-->
<script src="{{ asset('assets/js/pages/widgets.js') }}"></script>
<script src="{{ asset('assets/js/pages/crud/forms/widgets/select2.js') }}"></script>
<!--end::Page Scripts-->

@yield('page_level_js_plugin')
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
@yield('page_level_js')
</body>
<!--end::Body-->
<script>
    var today, datepicker;
    today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    datepicker = $('#datepickers').datepicker({
        minDate: today,
        format: 'yyyy-mm-dd'
    });
    $(document).on('click', '.booking_status', function() {
        booking_id = $(this).attr('data-id');
        booking_status = $(this).text();
        $('.status_text').text('')
        $('.status_text').text(booking_status.toUpperCase())
        $('#booking_id').val('');
        $('#booking_id').val(booking_id);
        $('#booking_status').val(booking_status);
        if (booking_status == 'rescheduled') {
            // $('.resceduled_html').show();

            var form_data = new FormData();
            form_data.append('id', booking_id);
            form_data.append('zip_code', zip_code);
            // var element = document.getElementById('test');
            // element.classList.add('col-lg-12');
            // element.classList.remove('col-lg-6');
            // $('#set_ctg').hide();
            $.ajax({
                type: "POST",
                url: "{{ route('getBookingById') }}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status == 'success') {
                        $('.time_slot_html').html(data.timeSlotHtml);
                        $('.selected_zip_code_time_slot_html').html();
                         $('.selected_zip_code_time_slot_html').html(data.timeSlotHtml);
                        var rec = data.data;
                        var id = rec.id;
                        var first_name = rec.first_name;
                        var last_name = rec.last_name;
                        name = first_name + ' ' + last_name;
                        var date = rec.date;
                        var category_id = rec.category_id;
                        var time_slot_id = rec.zip_code_id;
                        var email = rec.email;
                        var phone_number = rec.phone_number;
                        var post_code = rec.post_code;
                        var address = rec.address;
                        $('#id').val(id);
                        $('#customer_name').val(name);
                        $('#customer_no').val(phone_number);
                        $('#customer_email').val(email);
                        $('#customer_address').text(address);
                        $('#customer_post_code').val(post_code);
                        $('.selected_date').val(date);
                        $('#cat_id').val(category_id).trigger('change.select2');
                        $('#zip_code_id').val(time_slot_id).trigger('change.select2');
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    } else {
                        Swal.fire("Sorry!", data.message, "error");
                    }
                },
                error: function(errorString) {
                    Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                }
            });
            $('.resceduled_html').show();
        } else {
            $('.resceduled_html').hide();
        }
        $('#statusModal').modal('show');
    });

    $(document).on('change', '#booking_status', function() {
        booking_status = $(this).val();
        if (booking_status == 'rescheduled') {
            $('.resceduled_html').show();
            zip_code  =  $('#zip_code_id').val();
            var form_data = new FormData();
            form_data.append('id', booking_id);
            form_data.append('zip_code', zip_code);
            // var element = document.getElementById('test');
            // element.classList.add('col-lg-12');
            // element.classList.remove('col-lg-6');
            // $('#set_ctg').hide();
            $.ajax({
                type: "POST",
                url: "{{ route('getBookingById') }}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status == 'success') {
                        $('.time_slot_html').html('');
                        $('.selected_zip_code_time_slot_html').html('');
                         $('.selected_zip_code_time_slot_html').html(data.timeSlotHtml);
                        var rec = data.data;
                        var id = rec.id;
                        var first_name = rec.first_name;
                        var last_name = rec.last_name;
                        name = first_name + ' ' + last_name;
                        var date = rec.date;
                        var category_id = rec.category_id;
                        var time_slot_id = rec.zip_code_id;
                        var email = rec.email;
                        var phone_number = rec.phone_number;
                        var post_code = rec.post_code;
                        var address = rec.address;
                        $('#id').val(id);
                        $('#customer_name').val(name);
                        $('#customer_no').val(phone_number);
                        $('#customer_email').val(email);
                        $('#customer_address').text(address);
                        $('#customer_post_code').val(post_code);
                        $('.selected_date').val(date);
                        $('#cat_id').val(category_id).trigger('change.select2');
                        $('#zip_code_id').val(time_slot_id).trigger('change.select2');
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    } else {
                        Swal.fire("Sorry!", data.message, "error");
                    }
                },
                error: function(errorString) {
                    Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                }
            });
        } else {
            $('.resceduled_html').hide();
        }
    });
    $(document).on('click', '#update_stauts_btn', function() {
        status = $('#booking_status').val();
        booking_id = $('#booking_id').val();
        var form = $('#updateStatusForm')[0];
        var form_data = new FormData(form);
        form_data.append('status', status);
        form_data.append('booking_id', booking_id);
        $.ajax({
            type: "POST",
            url: "{{ route('updateBookingStatus') }}", // your php file name
            data: form_data,
            dataType: "json",
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.status == 'success') {
                    $('#statusModal').modal('hide');
                    Swal.fire("Success!", data.message, "success");
                    bookingListTable.ajax.reload();
                } else {
                    Swal.fire("Sorry!", data.message, "error");
                }
            },
            error: function(errorString) {
                Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
            }
        });

    })
    $(document).on('click','.selected_date',function(){
          $('.zip_code').val('').trigger('change.select2');
          $('.selected_zip_code_time_slot_html').html('');
    });
</script>

</html>
