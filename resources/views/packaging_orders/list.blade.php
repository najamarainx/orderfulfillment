@extends('layouts.app')
@section('title', 'Order List')
@section('page_level_css_plugin')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page_level_css')
    <style>
         body{
        background-color: white;font-family: 'Poppins';
    }
.btn.btn-light {
    background-color: #FFE2E5;
    border-color: transparent;
}
.card.card-custom{
    box-shadow: 0px 0px 30px 0px rgb(38 32 45 / 64%);
}.dataTables_wrapper .dataTable tfoot th, .dataTables_wrapper .dataTable thead th {
    color:#9b9da2;
}
.dataTables_wrapper .dataTable td{
    color: #181C32;
}
        .error {
            color: red !important;
        }
    </style>
@endsection
@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Order</h5>
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                    <span class="text-muted font-weight-bold mr-4">Order List</span>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Orders List {{ isset($totalPackagingOrder) && !empty($totalPackagingOrder) ? '('. $totalPackagingOrder.')' :' '  }}
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <form class="kt-form kt-form--fit">
                        <div class="row mb-6">
                            <div class="col-lg-4 mb-lg-2 mb-2">
                                <div class="form-group">
                                    <label>Order No:</label>
                                    <input type="text" class="form-control datatable-input" placeholder="Name" data-col-index="0">
                                </div>
                            </div>
                            <div class="col-lg-4 mb-lg-2 mb-2">
                                <label>Stores Name:</label>
                                <select class="form-control kt_select2_1 datatable-input " id="store_search" data-col-index="1" >
                                    <option value="">Select Store</option>
                                    @foreach($stores as $store)
                                        <option value="{{$store->id}}" >{{ucfirst($store->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4 mb-lg-2 mb-2 d-flex justify-content-between px-2">
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
                    <table class="table table-bordered table-checkable" id="departmentTableList">
                        <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Store Name</th>
                            <th>Customer Name</th>
                            <th>Phone</th>
                            <th>Created</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addDepartmentModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="hidden" name="id" id="id">
                                    <label>Department Name <span class="text-danger">*</span> </label>
                                    <input type="text" name="name"  id="name" class="form-control" placeholder="Title">
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
@endsection
@section('page_level_js')
    <script>
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
                table = $('#departmentTableList').DataTable({
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
                        url: "{{ route('getPackagedOrderList') }}",
                        type: 'POST',
                        data: {
                            'order_status':'confirmed',
                            // parameters for custom backend script demo
                            columnsDef: [
                                'id','store_id', 'name', 'phone', 'created_at','status'
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
                            data: 'store_id'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'phone'
                        },
                        {
                            data: 'created_at'
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
                        $('#store_search').val('').trigger('change')
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
                        url: "{{ route('departmentDelete') }}", // your php file name
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
        });
    </script>
@endsection
