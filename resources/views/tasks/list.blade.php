@extends('layouts.app')
@section('title', 'Tasks')

@section('page_level_css_plugin')
    <link rel="stylesheet" href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css">
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page_level_css')
    <style>
        body {
            background-color: white;
            font-family: 'Poppins';
        }

        .btn.btn-light {
            background-color: #FFE2E5;
            border-color: transparent;
        }

        .card.card-custom {
            box-shadow: 0px 0px 30px 0px rgb(38 32 45 / 64%);
        }

        .dataTables_wrapper .dataTable tfoot th,
        .dataTables_wrapper .dataTable thead th {
            color: #9b9da2;
        }

        .dataTables_wrapper .dataTable td {
            color: #181C32;
        }

        .error {
            color: red !important;
        }

        span.select2.select2-container.select2-container--default {
            width: 100% !important;
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

        .slot_radio input.radio:empty~label {
            position: relative;
            float: left;
            line-height: 1.5em;
            text-indent: 3.25em;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            width: 100%;
            border: 1px solid #B21F24;
            background-color: #B21F24;
            color: #fff;
            padding-top: 15px;
        }

        .slot_radio input.radio:empty~label:before {
            position: absolute;
            display: block;
            top: 0;
            bottom: 0;
            left: 0;
            content: '';
            width: 2.5em;
            background: #B21F24;
            border-radius: 3px 0 0 3px;
        }

        .slot_radio input.radio:hover:not(:checked)~label:before {
            content: '\2714';
            text-indent: .9em;
            line-height: 2.5em;
            color: #C2C2C2;
        }

        .slot_radio input.radio:hover:not(:checked)~label {
            color: #888;
        }

        .slot_radio input.radio:checked~label:before {
            content: '\2714';
            text-indent: .9em;
            color: #fff;
            background-color: #B21F24;
            padding-top: 14px;
        }

        .slot_radio input.radio:checked~label {
            color: #fff;
            background-color: #B21F24;
        }

        .slot_radio input.radio:focus~label:before {
            box-shadow: 0 0 0 3px #999;
        }

        .disabled input.radio:empty~label,
        .disabled input.radio:empty~label:before {
            background-color: lightgray !important;
        }

        .disabled input.radio:hover:not(:checked)~label:before {
            content: '';
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

        .confirmation_table td,
        .confirmation_table th,
        .confirmation_table,
        th,
        tr,
        td {
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

        @media only screen and (device-width : 375px) {

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
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Departments</h5>
                    <!--end::Page Title-->
                    <!--begin::Actions-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                    <span class="text-muted font-weight-bold mr-4">Task List</span>
                    <!--end::Actions-->
                </div>
                <!--end::Info-->
            </div>
        </div>
        <!--begin::Container-->
        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Tasks List
                            {{ isset($totalItems) && !empty($totalItems) ? '(' . $totalItems . ')' : ' ' }}
                        </h3>
                    </div>

                </div>
                <div class="card-body">
                    <form class="kt-form kt-form--fit">

                        <div class="row mb-6">
                            <div class="col-lg-3 mb-lg-2 mb-2">
                                <label>Date:</label>
                                <input type="text" class="form-control datatable-input " id="kt_datepicker"
                                    autocomplete="off" data-col-index="7">
                            </div>
                            @if (Auth::user()->type != 'team_lead')
                                <div class="col-lg-3 mb-lg-2 mb-2">
                                    <label>Department:</label>
                                    @if (!$departments->isEmpty())
                                        <select class="form-control form-control-lg  kt_select2_1 w-100 datatable-input"
                                            data-live-search="true" data-col-index="1">
                                            <option value=""></option>
                                            @foreach ($departments as $departmentObj)
                                                <option value="{{ $departmentObj->id }}">{{ $departmentObj->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            @endif

                            <div class="col-lg-3 mb-lg-2 mb-2">
                                <label>Status:</label>
                                <select class="form-control datatable-input" data-col-index="6">
                                    <option value="">Select a status</option>
                                    @foreach ($AssignTaskArray as $status)
                                        <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3 mb-lg-2 mb-2">
                                <label>&nbsp;</label><br />

                                <button class="btn btn-primary btn-primary--icon" id="kt_search">
                                    <span>
                                        <i class="la la-search"></i>
                                        <span>Search</span>
                                    </span>
                                </button>&#160;&#160;
                                <button class="btn btn-secondary btn-secondary--icon" id="kt_reset">
                                    <span>
                                        <i class="la la-close"></i>
                                        <span>Reset</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                    <!--begin: Datatable-->
                    <table class="table table-bordered table-checkable" id="itemTableList">
                        <thead>
                            <tr>
                                <th>Sr</th>
                                <th>Department</th>
                                <th>Dimension</th>
                                <th>Item</th>
                                <th>Variant</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Assigned To</th>
                                @if (Auth::user()->type == 'production_manager' || Auth::user()->type == 'team_lead')
                                    <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!--end: Datatable-->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade show" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-modal="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Assign User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form onsubmit="return false" id="addForm">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <p class="status_text"></p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="hidden" name="task_id" id="task_id">
                                    <label for="">Select User:</label>
                                    <select name="user_id" id="user_id" class="form-control kt_select2_1">

                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-light-primary font-weight-bold"
                                data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary font-weight-bold btn_save"
                                id="btn_save">Save</button>
                        </div>
                    </form>
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
    <script type="text/javascript">
        jQuery(document).ready(function() {
            datatable.init();
        });
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
                table = $('#itemTableList').DataTable({
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
                        url: "{{ route('getTasksList') }}",
                        type: 'POST',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'id', 'department_id', 'dimension', 'item_id', 'variant_id', 'qty',
                                'status', 'date', 'assigned'
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
                            data: 'department_id'
                        },
                        {
                            data: 'dimension'
                        },
                        {
                            data: 'item_id'
                        },
                        {
                            data: 'variant_id'
                        },
                        {
                            data: 'qty'
                        },
                        {
                            data: 'status'
                        },
                        {
                            data: 'date'
                        },
                        {
                            data: 'assigned',
                            responsivePriority: -1,
                            bSortable: false
                        },
                        @if(Auth::user()->type == 'production_manager' || Auth::user()->type == 'team_lead')
                        {
                            data: 'action',
                            responsivePriority: -1,
                            bSortable: false
                        },
                        @endif
                    ],
                    order: [
                        [0, "desc"]
                    ]
                });

                var filter = function() {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                    table.column($(this).data('col-index')).search(val ? val : '', false, false).draw();
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
                        table.column(i).search(val ? val : '', false, false);
                    });
                    table.table().draw();
                });

                $('#kt_reset').on('click', function(e) {
                    e.preventDefault();
                    $('.datatable-input').each(function() {
                        $(this).val('');
                        table.column($(this).data('col-index')).search('', false, false);
                    });
                    table.table().draw();
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





        $(document).on('click', '.assign_task', function() {
            var id = $(this).data('id');
            var form_data = new FormData();
            form_data.append('id', id);
            $.ajax({
                type: "POST",
                url: "{{ route('getTaskInfo') }}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status == 'success') {
                        $('#staticBackdrop').modal({
                            backdrop: 'static',
                            keyboard: false
                        }).on('hide.bs.modal', function() {
                            $("#addForm").validate().resetForm();
                        });
                        var datas = data.data;
                        $('#user_id').empty();
                        $('#user_id').append(new Option("Select User", " ")).trigger("updated");
                        $.each(datas, function(i, data) {
                            // console.log(data.id);
                            $('#user_id').append($('<option>', {
                                value: data.id,
                                text: data.name
                            })).trigger("updated");
                        });
                        $('#task_id').val(data.id);
                        if (data.user_id != null) {
                            $('#user_id').val(data.user_id).trigger("change.select2");
                        }


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


        jQuery(document).ready(function() {
            //datatable.init();

            var validator = $("#addForm").validate({
                ignore: ":hidden:not(.selectpicker)",
                rules: {
                    user_id: {
                        required: true
                    },


                },
                errorPlacement: function(error, element) {
                    var elem = $(element);
                    if (elem.hasClass("user_id")) {

                        error.appendTo(element.parent().after());
                        //error.insertAfter(element);
                    } else {
                        error.insertAfter(element);
                    }
                }
            });






            $(document).on('click', '#btn_save', function() {

                var validate = $("#addForm").valid();
                if (validate) {
                    var form_data = $("#addForm").serializeArray();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('assignuserTask') }}", // your php file name
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
                                $('#staticBackdrop').modal('hide');
                                table.ajax.reload();
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



            var input = document.getElementById("addForm");
            input.addEventListener("keyup", function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    document.getElementById("btn_save").click();
                }
            });



        });
    </script>
@endsection
