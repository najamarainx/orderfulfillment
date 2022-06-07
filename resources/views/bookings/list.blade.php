@extends('layouts.app')
@section('title', 'Booking')
@section('page_level_css_plugin')
    <link rel="stylesheet" href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css">
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page_level_css')
    <style>
         body{
        background-color: white;font-family: 'Poppins';
    }.dataTables_wrapper .dataTable tfoot th, .dataTables_wrapper .dataTable thead th {
    color:#9b9da2;
}
.dataTables_wrapper .dataTable td{
    color: #181C32;
}
.btn.btn-light {
    background-color: #FFE2E5;
    border-color: transparent;
}
.card.card-custom{
    box-shadow: 0px 0px 30px 0px rgb(38 32 45 / 64%);
}
        .error {
            color: red !important;
        }
        span.select2.select2-container.select2-container--default {
            width:100% !important;
        }
        #msform {
            text-align: center;
            position: relative;
            margin-top: 20px
        }
        #msform fieldset:not(:first-of-type) {
            display: none
        }
        #msform fieldset .form-card {
            text-align: left;
            color: #9E9E9E
        }
        #msform .action-button {
            width: 100px;
            background: #FF3414;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 0px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px
        }
        #msform .action-button:hover,
        #msform .action-button:focus {
            box-shadow: 0 0 0 2px white, 0 0 0 3px #FF3414;
        }
        #msform .action-button-previous {
            width: 100px;
            background: #616161;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 0px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px
        }
        #msform .action-button-previous:hover,
        #msform .action-button-previous:focus {
            box-shadow: 0 0 0 2px white, 0 0 0 3px #616161
        }
        select.list-dt {
            border: none;
            outline: 0;
            border-bottom: 1px solid #ccc;
            padding: 2px 5px 3px 5px;
            margin: 2px
        }
        select.list-dt:focus {
            border-bottom: 2px solid skyblue
        }
        .card {
            z-index: 0;
            border: none;
            border-radius: 0.5rem;
            position: relative
        }
        .fs-title {
            font-size: 25px;
            color: #2C3E50;
            margin-bottom: 10px;
            font-weight: bold;
            text-align: left
        }
        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
            color: lightgrey
        }
        #progressbar .active {
            color: #000000
        }
        #progressbar li {
            list-style-type: none;
            font-size: 12px;
            width: 25%;
            float: left;
            position: relative
        }
        #progressbar #category:before {
            font-family: FontAwesome;
            content: "\f023"
        }
        #progressbar #date_and_time:before {
            font-family: FontAwesome;
            content: "\f007"
        }
        #progressbar #client_detail:before {
            font-family: FontAwesome;
            content: "\f09d"
        }
        #progressbar #confirm:before {
            font-family: FontAwesome;
            content: "\f00c"
        }
        #progressbar li:before {
            width: 50px;
            height: 50px;
            line-height: 45px;
            display: block;
            font-size: 18px;
            color: #ffffff;
            background: lightgray;
            border-radius: 50%;
            margin: 0 auto 10px auto;
            padding: 2px
        }
        #progressbar li:after {
            content: '';
            width: 100%;
            height: 2px;
            background: lightgray;
            position: absolute;
            left: 0;
            top: 25px;
            z-index: -1
        }
        #progressbar li.active:before,
        #progressbar li.active:after {
            background: #FF3414;
        }
        .radio-group {
            position: relative;
            margin-bottom: 25px
        }
        .radio {
            display: inline-block;
            width: 20;
            height: 30;
            border-radius: 0;
            background: lightblue;
            box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
            box-sizing: border-box;
            cursor: pointer;
            margin: 8px 2px
        }
        .radio:hover {
            box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.3)
        }
        .radio.selected {
            box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.1)
        }
        .fit-image {
            width: 100%;
            object-fit: cover
        }
        fieldset {
            padding: 0px 30px;
        }
        .form-control:focus {
            border-color: #FF3414;
            box-shadow: 0 0 0 0.2rem rgb(255 52 20 / 25%);
        }
        /* check the balance */
        .slot_radio input.radio:empty {
            display: none;
        }
        .slot_radio input.radio:empty ~ label {
            position: relative;
            float: left;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            width: 100%;
            border: 1px solid #B21F24;
            background-color: #B21F24;
            color: #fff;
            padding: 10px 10px 10px 10px;
            padding-right : 5px;
            text-align: center;
            border-radius: 8px;
        }
        .time_slot_html.row .col-md-6 {
            padding: 2px;
        }
        .slot_radio input.radio:empty ~ label:before {
            position: absolute;
            display: block;
            top: 0;
            bottom: 0;
            left: 0;
            content: '';
            width: 2.5em;
            background: #B21F24;
            border-radius: 8px 0 0 8px;
        }
        .slot_radio input.radio:hover:not(:checked) ~ label:before {
            /* content:'\2714'; */
            text-indent: .9em;
            line-height: 2.5em;
            color: #C2C2C2;
        }
        .slot_radio input.radio:hover:not(:checked) ~ label {
            color: #888;
        }
        .slot_radio input.radio:checked ~ label:before {
            content:'\2714';
            text-indent: .9em;
            color: #fff;
            background-color: #B21F24;
            padding-top: 14px;
        }
        .slot_radio input.radio:checked ~ label {
            color: #fff;
            background-color: #B21F24;
        }
        .slot_radio input.radio:focus ~ label:before {
            box-shadow: 0 0 0 3px #999;
        }
        .slot_radio label{
            color: #fff !important;
        }
        .disabled input.radio:empty ~ label, .disabled input.radio:empty ~ label:before {
            background-color: lightgray !important;
        }
        .disabled input.radio:hover:not(:checked) ~ label:before {
            content:'';
            text-indent: .9em;
            color: #fff !important;
        }
        .cat_box {
            box-shadow: 0 4px 8px 0 rgb(0 0 0 / 20%);
            text-align: center;
            padding-top: 15px;
        }
        .cat_box label {
            display: block;
        }
        h6 {
            font-size: 1rem;
            font-weight: 700;
            font-family: 'Roboto', sans-serif;
            text-transform: capitalize;
            color: #333;
            letter-spacing: 0px;
        }
        .confirmation_table td, .confirmation_table th, .confirmation_table, th, tr, td{
            border: none;
        }
        .confirmation_table:first-child tr th {
            padding-bottom: 0px;
        }
        .confirmation_table {
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
            border-style: hidden;
            box-shadow: 0 0 0 1px #ddd;
        }
        @media only screen
        and (device-width : 375px){
            .flatpickr-calendar {
                width: 307.875px;
                margin-left: -34px;
                margin-bottom: 20px;
            }
        }
    </style>
@endsection
@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Booking</h5>
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                    <span class="text-muted font-weight-bold mr-4">Booking List </span>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Booking List {{ isset($totalBookings) && !empty($totalBookings) ? '('.$totalBookings.')' : '' }}
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <a class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#addBookingModal"
                            id="btn_add_new">
                            <span class="svg-icon svg-icon-md">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <circle fill="#000000" cx="9" cy="15" r="6" />
                                        <path
                                            d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                            fill="#000000" opacity="0.3" />
                                    </g>
                                </svg>
                            </span>Add Booking</a>
                    </div>
                </div>
                <div class="card-body">
                    <form class="kt-form kt-form--fit">
                        <div class="row mb-6">
                            <div class="col-lg-2 mb-lg-2 mb-2">
                                <label>Date:</label>
                                   <input type="text"  class="form-control datatable-input "  id="kt_datepicker" autocomplete="off" data-col-index="3">
                            </div>
                            <div class="col-lg-2 mb-lg-2 mb-2">
                                <label>Name:</label>
                                <input type="text" class="form-control datatable-input" placeholder="E.g: test"
                                    data-col-index="1" />
                            </div>
                            {{-- <div class="col-lg-2 mb-lg-2 mb-2">
                                <label>Phone No:</label>
                                <input type="text" class="form-control datatable-input" placeholder="Phone No(UK)"
                                    data-col-index="2" />
                            </div> --}}
                            <div class="col-lg-2 mb-lg-2 mb-2">
                                <label>Cateogry:</label>
                                @if (!$categories->isEmpty())
                                            <select class="form-control form-control-lg  datatable-input kt_select2_1 w-100 category_id"
                                                data-live-search="true" data-col-index="5">
                                                <option value=""></option>
                                                @foreach ($categories as $catObj)
                                                    <option value="{{ $catObj->id }}">{{ $catObj->name }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                            </div>
                            <div class="col-lg-2 mb-lg-2 mb-2">
                                <label>Status:</label>
                                <select name="" id="" class="form-control datatable-input" data-col-index="6">
                                   <option value="">Select Status</option>
                                    @foreach ($statusArray as $status)
                                       <option value="{{$status}}">{{ucfirst($status)}}</option>
                                   @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4 mb-lg-2 mb-2 d-flex justify-content-start px-2">
                                <label>&nbsp;</label><br /><button class="btn btn-primary btn-primary--icon cut_btn_filters w-100 mr-2" id="kt_search">
                                    <span class="d-flex text-center justify-content-center">
                                        <i class="la la-search"></i>
                                        <span>Search</span>
                                    </span>
                                </button>&#160;&#160;
                                <button class="btn btn-secondary btn-secondary--icon cut_btn_filters w-100 ml-2" id="kt_reset">
                                    <span class="d-flex text-center justify-content-center">
                                        <i class="la la-close"></i>
                                        <span>Reset</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                    <table class="table table-bordered table-checkable" id="itemTableList">
                        <thead>
                            <tr>
                                <th>Sr</th>
                                <th>Name</th>
                                <th>Phone No</th>
                                <th>Date</th>
                                <th>Time Slot</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th class="cust_th_table">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addBookingModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Booking</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                 <form id="addForm">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 pr-lg-6 pr-md-6 border-right-lg border-right-md " id="test">
                            <div class="row">
                                <div class="col-12">
                                    <input type="hidden" name="id" id="id">
                                    <div class="form-group mb-4">
                                        <label class="mb-0">Customer Name</label>
                                        <input type="text" class="form-control" name="customer_name" id="customer_name" placeholder="Customer Name">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-4">
                                        <label class="mb-0">Customer Phone.No</label>
                                        <input type="number" class="form-control" name="customer_no" id="customer_no" placeholder="Customer Phone.No">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-4">
                                        <label class="mb-0">Customer Email</label>
                                        <input type="email" class="form-control" name="customer_email" id="customer_email" placeholder="Customer Email">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group mb-4">
                                        <label class="mb-0">Country</label>
                                        <input type="text" class="form-control" name="country" id="country" placeholder="Country">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-4">
                                        <label class="mb-0">City</label>
                                        <input type="text" class="form-control" name="city" id="city" placeholder="City">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 pl-lg-6 pl-md-6" id="classes_wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-4">
                                        <label class="mb-0">Customer Address</label>
                                        <textarea type="text" class="form-control"
                                            placeholder="Customer Address" name="customer_address" id="customer_address"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-4">
                                        <label class="mb-0">Customer postal Code</label>
                                        <input type="text" class="form-control" name="customer_post_code" id="customer_post_code" placeholder="Customer postal Code">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-4">
                                    <label class="mb-0">State</label>
                                    <input type="text" class="form-control" name="state" id="state" placeholder="State">
                                </div>
                            </div>
                            <div class="row" id="set_ctg">
                                <div class="col-12">
                                    <div class="form-group mb-4">
                                        <label class="mb-0">Select Category</label>
                                        @if (!$categories->isEmpty())
                                            <select class="form-control form-control-lg  kt_select2_1 w-100 category_id"
                                                data-live-search="true" name="category_id" id="category_id">
                                                <option value=""></option>
                                                @foreach ($categories as $catObj)
                                                    <option value="{{ $catObj->id }}">{{ $catObj->name }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-4">
                                        <label>Select Date: </label>
                                        <input class="form-group mb-4 date selected_date" id="datepicker" name="date" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-4">
                                        <label>Post Code: </label>
                                        <select class="form-control form-control-lg  kt_select2_1 w-100 zip_code"   data-live-search="true" name="zip_code" id="zip_code">
                                        @if(!empty($zipCode))
                                        <option value=""></option>
                                         @foreach ($zipCode as $zipObj)
                                                 <option value="{{$zipObj->id}}">{{$zipObj->name}}</option>
                                         @endforeach
                                        @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <p class="text-danger slot_error"></p>
                                    <div class="time_slot_html row">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold"
                        data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary font-weight-bold" id="btn_save">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page_level_js_plugin')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/jqvalidation/jquery.validate.min.js?v=7.0.4') }}"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
@endsection
@section('page_level_js')
    <script>
        $(document).ajaxStart(function() {
            KTApp.blockPage({
                overlayColor: 'red',
                opacity: 0.1,
                state: 'primary' // a bootstrap color
            });
        }).ajaxStop(function() {
            KTApp.unblockPage();
        });
        var table = "";
        var datatable = function() {
            var initTable = function() {
                // begin first table
                bookingListTable = $('#itemTableList').DataTable({
                    responsive: true,
                    // Pagination settings
                    dom: `<'row'<'col-sm-12'tr>> <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
                    // read more: https://datatables.net/examples/basic_init/dom.html
                    lengthMenu: [5, 10, 25, 50],
                    pageLength: 10,
                    language: {
                        'lengthMenu': 'Display _MENU_',
                    },
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('getBookingList') }}",
                        type: 'POST',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'id', 'date', 'time_slot', 'category_id', 'first_name','phone_number', 'booking_status'
                            ],
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    columns: [{
                            data: 'id'
                        },
                        {
                            data: 'first_name'
                        },
                        {
                            data: 'phone_number'
                        },

                        {
                            data: 'date'
                        },
                        {
                            data: 'time_slot'
                        },
                        {
                            data: 'category_id'
                        },
                        {
                            data: 'booking_status'
                        },
                        {
                            data: 'action',
                            responsivePriority: -1,
                            bSortable: false
                        },
                    ],
                    order: [
                        [0, "desc"]
                    ]
                });
                var filter = function() {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                    bookingListTable.column($(this).data('col-index')).search(val ? val : '', false, false).draw();
                };
                $('#kt_search').on('click', function(e) {
                    e.preventDefault();
                    var params = {};
                    $('.datatable-input').each(function() {
                        var i = $(this).data('col-index');
                        if (params[i]) {
                            params[i] += '|' + $(this).val();
                        } else {
                            params[i] = $(this).val();
                        }
                    });
                    $.each(params, function(i, val) {
                        // apply search params to datatable
                        bookingListTable.column(i).search(val ? val : '', false, false);
                    });
                    bookingListTable.table().draw();
                });
                $('#kt_reset').on('click', function(e) {
                     $('.category_id').val('').trigger('change.select2');
                    e.preventDefault();
                    $('.category_id').val('').trigger('change.slect2');
                    $('.datatable-input').each(function() {
                        $(this).val('');
                        bookingListTable.column($(this).data('col-index')).search('', false, false);
                    });
                    bookingListTable.table().draw();
                });
                $('#kt_datepicker').datepicker({
                    todayHighlight: true,
                    format: 'yyyy-mm-dd',
                    templates: {
                        leftArrow: '<i class="la la-angle-left"></i>',
                        rightArrow: '<i class="la la-angle-right"></i>',
                    },
                });
            };
            return {
                //main function to initiate the module
                init: function() {
                    initTable();
                },
            };
        }();
        jQuery(document).ready(function() {
            var today, datepicker;
            today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
            datepicker = $('#datepicker').datepicker({
                minDate: today,
                format: 'yyyy-mm-dd'
            });
            datatable.init();
            var validator = $("#addForm").validate({
                rules: {
                    customer_name: {
                        required: true
                    },
                    customer_no: {
                        required: true,
                        'check_phone_no':true
                    },
                    customer_email: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    state: {
                        required: true
                    },
                    country: {
                        required: true
                    },
                    customer_address: {
                        required: true
                    },
                    customer_post_code: {
                        required: true
                    }
                },
                errorPlacement: function(error, element) {
                    var elem = $(element);
                    if (elem.hasClass("category_id") || elem.hasClass("zip_code")) {
                        error.appendTo(element.parent().after());
                        //error.insertAfter(element);
                        } else {
                        error.insertAfter(element);
                    }
                }
            });
            var input = document.getElementById("addForm");
            input.addEventListener("keyup", function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    document.getElementById("btn_save").click();
                }
            });
        })
        $(document).on('click', '#btn_add_new', function() {
            var element = document.getElementById('test');
            // element.classList.add('col-lg-6');
            // element.classList.remove('col-lg-12');
            $('#set_ctg').show();
            $('#addBookingModal').modal({
                backdrop: 'static',
                keyboard: false
            }).on('hide.bs.modal', function() {
                $('.slot_error').text('');
                $("#addForm").validate().resetForm();
            });
            var form = $("#addForm");
            form[0].reset();
            $('#id').val('');
            $('.slot_error').text('');
            $('#category_id').val('').trigger('change.select2');
            $('#zip_code').val('').trigger('change.select2');
            $('.time_slot_html').html('');
        });
        $(document).on('click', '#btn_save', function() {
            var validate = $("#addForm").valid();
            var upid=$('#id').val();
            if(upid==''){
                if(!$("input:radio[name='time_slot']").is(":checked")) {
                    $('.slot_error').text('Please select a slot');
                    validate = false;
                }
            }
            if (validate) {
                var form_data = $("#addForm").serializeArray();
                $.ajax({
                    type: "POST",
                    url: "{{ route('bookingSubmit') }}", // your php file name
                    data: form_data,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            toastr.options = {
                                "closeButton": true,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": true,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            };
                            toastr.success(data.message);
                            var form = $("#addForm");
                            form[0].reset();
                            $('#addBookingModal').modal('hide');
                            bookingListTable.ajax.reload();
                        } else {
                            Swal.fire("Sorry!", data.message, "error");
                        }
                    },
                    error: function(errorString) {
                        Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                    }
                });
            }
        });
        jQuery.validator.addMethod('check_phone_no', function(phone_number, element) {
        return phone_number.length > 9 &&
            phone_number.match(/^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$/);
    }, 'Please enter a correct UK number.');
        $(document).on('click', '.edit', function() {
            var id = $(this).data('id');
            var form_data = new FormData();
            form_data.append('id', id);
            var element = document.getElementById('test');
            // element.classList.add('col-lg-12');
            // element.classList.remove('col-lg-6');
            $('#set_ctg').hide();
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
                        $('#addBookingModal').modal({
                            backdrop: 'static',
                            keyboard: false
                        }).on('hide.bs.modal', function() {
                            $("#addForm").validate().resetForm();
                        });
                        var rec = data.data;
                        var id = rec.id;
                        var first_name = rec.first_name;
                        var last_name = rec.last_name;
                        var name = first_name+' '+ (last_name ? last_name  : '');
                        var date = rec.date;
                        var category_id  = rec.category_id ;
                        var time_slot_id = rec.time_slot_id;
                        var email = rec.email;
                        var phone_number = rec.phone_number;
                        var post_code = rec.post_code;
                        var address = rec.address;
                        var city = rec.city;
                        var state = rec.state;
                        var country = rec.country;
                        $('#id').val(id);
                        $('#customer_name').val(name);
                        $('#customer_no').val(phone_number);
                        $('#customer_email').val(email);
                        $('#customer_address').text(address);
                        $('#customer_post_code').val(post_code);
                        $('#city').val(city ? city : '');
                        $('#state').val(state ? state : '');
                        $('#country').val(country ? country : '');
                        $('.selected_date').val(date);
                        // $('#category_id').val(category_id).trigger('change.select2');
                        // $('#zip_code').val(time_slot_id).trigger('change.select2');
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
        });
        $(document).on('click', '.delete', function() {
            var id = $(this).data('id');
            var form_data = new FormData();
            form_data.append('id', id);
            Swal.fire({
                title: "Are you sure?",
                text: "You wont be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('bookingDelete') }}", // your php file name
                        data: form_data,
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                Swal.fire("Success!", data.message, "success");
                                bookingListTable.ajax.reload();
                            } else {
                                Swal.fire("Sorry!", data.message, "error");
                            }
                        },
                        error: function(errorString) {
                            Swal.fire("Sorry!", "Something went wrong please contact to admin",
                                "error");
                        }
                    });
                }
            });
        });
        $(document).on('click','.selected_date',function(){
           console.log('yes');
        //    $('.zip_code').selectpicker("refresh");
        });
        $(document).on('change','.zip_code',function(){
          zipCode  =  $(this).val();
          date = $('.date').val();
          var form_data = new FormData();
            form_data.append('zipCode', zipCode);
            form_data.append('date', date);
            $.ajax({
                type: "POST",
                url: "{{ route('getTimeSlotByZipCode') }}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status == 'success') {
                            $('.time_slot_html').html();
                            $('.time_slot_html').html(data.timeSlotHtml);
                    } else {
                        Swal.fire("Sorry!", data.message, "error");
                    }
                },
                error: function(errorString) {
                    Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                }
            });
        })
    </script>
@endsection
