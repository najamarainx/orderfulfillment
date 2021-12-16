<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Worker Tasks Screen</title>
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
    <link rel="stylesheet" href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css">
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap py-3">
                        <div class="card-title">
                            <h3 class="card-label">Worker Task List
                            </h3>
                        </div>

                    </div>
                    <div class="card-body">
                        <form class="kt-form kt-form--fit">
                            @php $type = Auth::user()->type; @endphp
                            <div class="row mb-6">
                                <div class="col-lg-3 mb-lg-2 mb-2">
                                    <label>Date:</label>
                                       <input type="text"  class="form-control datatable-input "  id="kt_datepicker" autocomplete="off" data-col-index="5">
                                </div>
                                @if($type != 'team_lead')
                                <div class="col-lg-3 mb-lg-2 mb-2">
                                    <label>Department:</label>
                                    @if (!$workers->isEmpty())
                                    <select class="form-control form-control-lg  kt_select2_1 w-100 datatable-input"
                                        data-live-search="true"  data-col-index="1">
                                        <option value=""></option>
                                        @foreach ($workers as $departmentObj)
                                            <option value="{{ $workers->id }}">{{ $workers->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                                </div>
                                @endif
                                @if($type == 'team_lead')
                                <div class="col-lg-3 mb-lg-2 mb-2">
                                    <label>Status:</label>
                                    <select  class="form-control datatable-input" data-col-index="6">
                                        <option value="">Select a status</option>
                                       @foreach ($AssignTaskArray as $status)
                                           <option value="{{$status}}">{{ucfirst($status)}}</option>
                                       @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="col-lg-3 mb-lg-2 mb-2">
                                    <label>&nbsp;</label><br />
                                    <button class="btn btn-secondary btn-secondary--icon" id="kt_reset">
                                        <span>
                                            <i class="la la-close"></i>
                                            <span>Reset</span>
                                        </span>
                                    </button>
                                    <button class="btn btn-primary btn-primary--icon" id="kt_search">
                                        <span>
                                            <i class="la la-search"></i>
                                            <span>Search</span>
                                        </span>
                                    </button>&#160;&#160;
                                </div>
                            </div>
                        </form>
                        <!--begin: Datatable-->
                        <table class="table table-bordered table-checkable" id="itemTableList">
                            <thead>
                            <tr>
                                <th>Sr</th>
                                <th>Department</th>
                                <th>Item</th>
                                <th>Variant</th>
                                <th>Qty</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Assign To</th>
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
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

<script>
    jQuery(document).ready(function() {
        datatable.init();});


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
                        url: "{{ route('getWorkerTasksList') }}",
                        type: 'POST',
                        data: {
                            status:'confirmed',
                            // parameters for custom backend script demo
                            columnsDef: [
                                'id', 'item_id', 'variant_id', 'qty','date','status','assign_to'
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
                            data: 'item_id'
                        },
                        {
                            data: 'variant_id'
                        },
                        {
                            data: 'qty'
                        },
                        {
                            data: 'date'
                        },

                        {
                            data: 'status'
                        },

                        {
                            data: 'assign_to',
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
                    e.preventDefault();
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
</script>
</html>
