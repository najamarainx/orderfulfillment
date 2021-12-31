@extends('layouts.app')
@section('title', 'Item')

@section('page_level_css_plugin')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page_level_css')
    <style>
        .error {
            color: red !important;
        }
        span.select2.select2-container.select2-container--default {
            width:100% !important;
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
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Stock </h5>
                <!--end::Page Title-->
                <!--begin::Actions-->
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                <span class="text-muted font-weight-bold mr-4">Item List</span>
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
                    <h3 class="card-label">Item List
                    </h3>
                </div>
                <div class="card-toolbar">
                    <!--begin::Dropdown-->
                    <!--end::Dropdown-->
                    <!--begin::Button-->
                    <a class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#addItemModal"
                        id="btn_add_new">
                        <span class="svg-icon svg-icon-md">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
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
                            <!--end::Svg Icon-->
                        </span>Add Item</a>
                    <!--end::Button-->
                </div>
            </div>
            <div class="card-body">
                <form class="kt-form kt-form--fit">
                    <div class="row mb-6">
                        <div class="col-lg-3 mb-lg-2 mb-2">
                            <label>Department:</label>
                            <select   class="form-control datatable-input kt_select2_1"  data-col-index="1">
                                    @if(!empty($departments))
                                    <option value="">Select</option>
                                    @foreach ($departments as $departmentObj)
                                      <option value="{{$departmentObj->id}}">{{$departmentObj->name}}</option>
                                    @endforeach
                                    @endif
                            </select>
                        </div>
                        <div class="col-lg-3 mb-lg-2 mb-2">
                            <label>Name:</label>
                            <input type="text" class="form-control datatable-input" placeholder="E.g: test"
                                data-col-index="2" />
                        </div>
                        <div class="col-lg-3 mb-lg-2 mb-2">
                            <label>&nbsp;</label><br /><button class="btn btn-primary btn-primary--icon" id="kt_search">
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
                            <th>Name</th>
                            <th>Min Quantity</th>
                            <th>Unit</th>
                            <th>Created</th>
                            <th>Actions</th>
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

    <div class="modal fade" id="addItemModal" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
               <form onsubmit="return false" id="addForm">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <input type="hidden" name="id" id="id">
                            <label>Title <span class="text-danger">*</span> </label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Title">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Department <span class="text-danger">*</span> </label>
                            <select name="department_id" id="department_id" class="form-control department_id kt_select2_1" >
                                    @if(!empty($departments))
                                    <option value="">Select</option>
                                    @foreach ($departments as $departmentObj)
                                      <option value="{{$departmentObj->id}}">{{$departmentObj->name}}</option>
                                    @endforeach
                                    @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Min Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="min_qty" id="min_qty"  min="1" class="form-control" placeholder="Min Quantity">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Unit <span class="text-danger">*</span></label>
                            <input type="text"  name="unit"  id="unit" class="form-control" placeholder="Unit">
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="button" class="btn btn-light-primary font-weight-bold"
                    data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold btn_save" id="btn_save">Save</button>
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
                        url: "{{ route('getItemList') }}",
                        type: 'POST',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'id','department_id', 'name','min_qty','unit', 'created_at'
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
                            data: 'name'
                        },
                        {
                            data: 'min_qty'
                        },
                        {
                            data: 'unit'
                        },
                        {
                            data: 'created_at'
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

jQuery(document).ready(function() {
            datatable.init();
            var validator = $("#addForm").validate({
                rules: {
                    name: {
                        required: true
                    },
                    min_qty: {
                        required: true
                    },
                    unit: {
                        required: true
                    },
                    department_id: {
                        required: true
                    }

                },
                errorPlacement: function(error, element) {
                var elem = $(element);
                if (elem.hasClass("department_id")) {

                    error.appendTo(element.parent().after());
                    //error.insertAfter(element);
                }

                else {
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
            $('#addItemModal').modal({
                backdrop: 'static',
                keyboard: false
            }).on('hide.bs.modal', function() {
                $("#addForm").validate().resetForm();
            });
            var form = $("#addForm");
            form[0].reset();
            $('#id').val('');
            $('#department_id').val('').trigger('change.select2')

        });


        $(document).on('click', '#btn_save', function() {
            var validate = $("#addForm").valid();
            if (validate) {
                var form_data = $("#addForm").serializeArray();
                $.ajax({
                    type: "POST",
                    url: "{{ route('itemSubmit') }}", // your php file name
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
                            $('#addItemModal').modal('hide');
                            table.ajax.reload();
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

        $(document).on('click', '.edit', function() {
            var id = $(this).data('id');
            var form_data = new FormData();
            form_data.append('id', id);
            $.ajax({
                type: "POST",
                url: "{{ route('getItemById') }}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status == 'success') {
                        $('#addItemModal').modal({
                            backdrop: 'static',
                            keyboard: false
                        }).on('hide.bs.modal', function() {
                            $("#addForm").validate().resetForm();
                        });
                        var rec = data.data;
                        var id = rec.id;
                        var name = rec.name;
                        var min_qty = rec.min_qty;
                        var department_id = rec.department_id;
                        var unit = rec.unit;
                        $('#id').val(id);
                        $('#name').val(name);
                        $('#min_qty').val(min_qty);
                        $('#unit').val(unit);
                        $('#department_id').val(department_id).trigger('change.select2');
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
                        url: "{{ route('itemDelete') }}", // your php file name
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
