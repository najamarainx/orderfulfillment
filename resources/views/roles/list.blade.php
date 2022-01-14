@extends('layouts.app')
@section('title', 'Role')

@section('page_level_css_plugin')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page_level_css')
    <style>
          body {
        font-family: poppins;
    }
    
.d-flex.flex-row.flex-column-fluid.page {
    background-color: white;
}

.card.card-custom {
    box-shadow: 0px 0px 30px 0px rgb(82 63 105 / 42%);
}

.dataTables_wrapper .dataTable thead th {
    color: #9ca7da;
}

.dataTables_wrapper .dataTable td {
    color: black;
}
        .error {
            color: red !important;
        }
        .btn.btn-light {
    background-color: #FFE2E5;
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
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Users</h5>
                    <!--end::Page Title-->
                    <!--begin::Actions-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                    <span class="text-muted font-weight-bold mr-4">Role</span>
                    <!--end::Actions-->
                </div>
                <!--end::Info-->
            </div>
        </div>
        <!--begin::Container-->
        <div class="col-12">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Roles List {{ isset($totalItems) && !empty($totalItems) ? '('.$totalItems.')'  :' '  }}

                        </h3>
                    </div>
                    @if(hasPermission('addRole'))
                    <div class="card-toolbar">
                        <!--begin::Dropdown-->

                        <!--end::Dropdown-->
                        <!--begin::Button-->
                        <a data-target="#addRoleModal" data-toggle="modal" class="btn btn-primary font-weight-bolder"
                            id='btn_add_new'>
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
                            </span>Add Role</a>
                        <!--end::Button-->
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <form class="kt-form kt-form--fit">
                        <div class="row mb-6">
                            <div class="col-lg-3 mb-lg-2 mb-2">
                                <label>Role:</label>
                                <input type="text" class="form-control datatable-input" placeholder="E.g: test"
                                    data-col-index="1" />
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
                    <!--begin: Datatable-->
                    <table class="table table-bordered table-checkable" id="roleTableList">
                        <thead>
                            <tr>
                                <th>Record ID</th>
                                <th>Role</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                    <!--end: Datatable-->
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade show" id="addRoleModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-modal="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form onsubmit="return false" id="addForm">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label" for="role">Role</label>
                                    <input type="hidden" name="id" id="id">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Role Name">
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



    <div class="modal fade" id="assign_permission_modal" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Assign Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="assign_permission_form">
                        <div class="row" id="assign_permission_html"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary font-weight-bold" id="assign_permission_to_role">Save</button>
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
                table = $('#roleTableList').DataTable({
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
                        url: "{{ route('getRoleList') }}",
                        type: 'POST',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'id', 'name', 'created_at'
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
                    }
                },
                errorPlacement: function(error, element) {
                    var elem = $(element);
                    if (elem.hasClass("selectpicker")) {
                        element = elem.parent();
                        error.insertAfter(element);
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
            $('#addRoleModal').modal({
                backdrop: 'static',
                keyboard: false
            }).on('hide.bs.modal', function() {
                $("#addForm").validate().resetForm();
            });
            var form = $("#addForm");
            form[0].reset();
        });


        $(document).on('click', '#btn_save', function() {
            var validate = $("#addForm").valid();
            if (validate) {
                var form_data = $("#addForm").serializeArray();
                $.ajax({
                    type: "POST",
                    url: "{{ route('roleSubmit') }}", // your php file name
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
                            $('#addRoleModal').modal('hide');
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
                url: "{{ route('getRoleById') }}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status == 'success') {
                        $('#addRoleModal').modal({
                            backdrop: 'static',
                            keyboard: false
                        }).on('hide.bs.modal', function() {
                            $("#addForm").validate().resetForm();
                        });
                        var rec = data.data;
                        var id = rec.id;
                        var name = rec.name;
                        $('#id').val(id);
                        $('#name').val(name);
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
                        url: "{{ route('roleDelete') }}", // your php file name
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

        $(document).on('click','.assign_permission',function() {
                var id = $(this).data('id');
                var form_data = new FormData();
                form_data.append('role_id', id);
                $.ajax({
                    type: "POST",
                    url: "{{route('rolePermissions')}}", // your php file name
                    data: form_data,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data){
                        if(data.status == 'success') {
                            var rec = data.data;
                            $('#assign_permission_html').html(rec);
                            $('#assign_permission_modal').modal({
                                backdrop: 'static',
                                keyboard: false
                            });
                        } else {
                            Swal.fire("Sorry!", data.message, "error");
                        }
                    },
                    error: function (errorString){
                        Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                    }
                });
            });

            $(document).on('click','#assign_permission_to_role',function() {
                var form_data = $("#assign_permission_form").serializeArray();
                $.ajax({
                    type: "POST",
                    url: "{{route('assignPermissions')}}", // your php file name
                    data: form_data,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data){
                        if(data.status == 'success') {
                            $('#assign_permission_modal').modal('hide');
                            Swal.fire("Success!", data.message, "success");
                        } else {
                            Swal.fire("Sorry!", data.message, "error");
                        }
                    },
                    error: function (errorString){
                        Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                    }
                });
            });
    </script>
@endsection
