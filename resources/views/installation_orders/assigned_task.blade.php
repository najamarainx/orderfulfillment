@extends('layouts.app')
@section('title', 'Task List')

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
    <div class="d-flex flex-column-fluid">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Order</h5>
                    <!--end::Page Title-->
                    <!--begin::Actions-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                    <span class="text-muted font-weight-bold mr-4">Task List </span>
                    <!--end::Actions-->
                </div>
                <!--end::Info-->
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-custom gutter-b">
                            <div class="card-header flex-wrap py-3">
                                <div class="card-title">
                                    <h3 class="card-label">Assigned Task
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <form class="kt-form kt-form--fit">
                                            <div class="row mb-6">
                                                <div class="col-lg-3 mb-lg-2 mb-2">
                                                    <label>Name:</label>
                                                    <input type="text" class="form-control datatable-input"
                                                        placeholder="E.g: test" data-col-index="1" />
                                                </div>
                                                <div class="col-lg-9 mb-lg-2 mb-2">
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
                                        <table class="table table-condensed table-head-custom table-vertical-center"
                                            id="itemTableList">
                                            <thead>
                                                <tr class="text-left text-uppercase">
                                                    <th>Sr</th>
                                                    <th>Assign To</th>
                                                    <th>Assign From</th>
                                                    <th>Status</th>
                                                    <th class="" style="min-width: 160px">Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('page_level_js_plugin')
        <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ asset('assets/plugins/custom/jqvalidation/jquery.validate.min.js?v=7.0.4') }}"></script>
    @endsection
    @section('page_level_js')
        <script>
            jQuery(document).ready(function() {
                datatable.init();
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
                            url: "{{ route('getInstallationUsersList') }}",
                            type: 'POST',
                            data: {
                                order_id: {{ last(request()->segments()) }},
                                // order_id = "{{ last(request()->segments()) }}",

                                // parameters for custom backend script demo
                                columnsDef: [
                                    'id', 'name','added_by','status'
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
                                data: 'name'
                            },
                            {
                                data: 'added_by'
                            },
                            {
                                data: 'status'
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
                        bookingListTable.column($(this).data('col-index')).search(val ? val : '', false, false)
                            .draw();
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


            $(document).on('click', '.save_assemled_user', function() {
                user_id = $(this).attr('data-user-id');
                var form = new FormData();
                var order_id = {{ last(request()->segments()) }};
                form.append('user_id', user_id);
                form.append('order_id', order_id);
                $.ajax({
                    type: "POST",
                    url: "{{ route('assignedInstallationTask') }}", // your php file name
                    data: form,
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

            });
            $(document).on('click', '.delete_assemled_user', function() {
                id = $(this).attr('data-assmbler-id');
                var form = new FormData();
                form.append('id', id);
                $.ajax({
                    type: "POST",
                    url: "{{ route('deleteInstallationUser') }}", // your php file name
                    data: form,
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

            });


        </script>
    @endsection
