@extends('layouts.app')
@section('title', 'User')
@section('page_level_css_plugin')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page_level_css')
    <style>
        .error{
            color: red!important;
        }
    </style>
@endsection
@section('content')
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard</h5>
                    <!--end::Page Title-->
                    <!--begin::Actions-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                    <span class="text-muted font-weight-bold mr-4">Dashboard</span>
                    <!--end::Actions-->
                </div>
                <!--end::Info-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">



                <!--begin::Advance Table Widget 2-->
                <div class="card card-custom gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-center">
                            <span class="card-label font-weight-bolder text-dark">User List</span>
                        </h3>
                        <div class="card-toolbar">
                            <ul class="nav nav-pills nav-pills-sm nav-dark-75">
                                <li class="nav-item">
                                    <a class="nav-link py-2 px-4 active" data-toggle="modal" data-target="#staticBackdrop">Add User</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-2 pb-0 mt-n3">

                            <!--begin::Tap pane-->
                        <form class="kt-form kt-form--fit">
                            <div class="row">
                                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input type="number" class="form-control datatable-input" placeholder="Name" data-col-index="1">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control datatable-input" placeholder="Email" data-col-index="2">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input type="number" class="form-control datatable-input" placeholder="Phone.No" data-col-index="3">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <select class="form-control datatable-input" id="exampleSelect1" data-col-index="4">
                                                <option default>Select Role</option>
                                                <option>20%</option>
                                                <option>40%</option>
                                                <option>60%</option>
                                                <option>Full Paid</option>
                                                <option>Un Paid</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <select class="form-control datatable-input" id="exampleSelect2" data-col-index="5">
                                                <option default>Select User Type</option>
                                                <option>Pending</option>
                                                <option>In Progress</option>
                                                <option>Approved</option>
                                                <option>Reschedule</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                        <div class="d-flex justify-content-between align-content-between">
                                            <button type="button" class="btn btn-outline-primary w-100 mr-2">Reset</button>
                                            <button type="button" class="btn btn-primary w-100 ml-2">Search</button>
                                        </div>
                                    </div>
                                </div>
                        </form>
                                <!--begin::Table-->

                                    <table class="table table-bordered table-checkable" id="datatableList">
                                        <thead>
                                        <tr>
                                            <th>Sr</th>
                                           <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone. No</th>
                                            <th>Role</th>
                                            <th>User Type</th>
                                           <th>Action</th>
                                        </tr>
                                        </thead>

                                    </table>

                                <!--end::Table-->


                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Advance Table Widget 2-->









            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>

    <!--end::Content-->
    <!--------modal user---------------->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <input type="name" id="name" class="form-control" placeholder="Name">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="number" name="phone" id="phone" class="form-control" placeholder="Phone.No">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <select class="form-control" id="exampleSelect2">
                                    <option default>Select User Type</option>
                                    <option>Pending</option>
                                    <option>In Progress</option>
                                    <option>Approved</option>
                                    <option>Reschedule</option>
                                </select>
                            </div>
                        </div>


                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary font-weight-bold">Save</button>
                </div>
            </div>
        </div>
    </div>
<!-------end user modal-------------->

@endsection
@section('page_level_js_plugin')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.4') }}"></script>
    <script src="{{ asset('assets/plugins/custom/jqvalidation/jquery.validate.min.js?v=7.0.4') }}"></script>
@endsection
@section('page_level_js')
<script type="text/javascript">
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
            table = $('#datatableList').DataTable({
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
                    url: "{{ route('getZipList') }}",
                    type: 'POST',
                    data: {
                        // parameters for custom backend script demo
                        columnsDef: [
                            'Sr','Name','created_at'
                        ],
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [
                    {
                        data: 'Sr'
                    },
                    {
                        data: 'Name'
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
                    [1, "desc"]
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
            ignore: ":hidden:not(.selectpicker)",
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

        $('input[type="file"]').change(function(e) {
            var fileName = e.target.files[0].name;
            $(this).next('label.file_label').html(fileName);
        });

        $(document).on('click', '#btn_add_new', function(){
            $('#staticBackdrop').modal({
                backdrop: 'static',
                keyboard: false
            }).on('hide.bs.modal', function(){
                $("#addForm").validate().resetForm();
            });
            var form = $("#addForm");
            form[0].reset();
        });


        $(document).on('click', '#btn_save', function(){
            var validate = $("#addForm").valid();
            if(validate) {
                var form_data = $("#addForm").serializeArray();
                $.ajax({
                    type: "POST",
                    url: "{{route('zipSubmit')}}", // your php file name
                    data: form_data,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
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
                    error: function (errorString) {
                        Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                    }
                });
            }
        });
        $(document).on('click','.edit',function() {
            var id = $(this).data('id');
            var form_data = new FormData();
            form_data.append('id', id);
            $.ajax({
                type: "POST",
                url: "{{route('getZipById')}}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data){
                    if(data.status == 'success') {
                        $('#staticBackdrop').modal({
                            backdrop: 'static',
                            keyboard: false
                        }).on('hide.bs.modal', function(){
                            $("#addForm").validate().resetForm();

                        });
                        var rec = data.data;
                        var id = rec.id;
                        var name = rec.name;
                        $('#id').val(id);
                        $('#name').val(name);
                    } else {
                        Swal.fire("Sorry!", data.message, "error");
                    }
                },
                error: function (errorString){
                    Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                }
            });
        });
        $(document).on('click','.delete',function() {
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
                        url: "{{route('zipDelete')}}", // your php file name
                        data: form_data,
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data){
                            if(data.status == 'success') {
                                Swal.fire("Success!", data.message, "success");
                                table.ajax.reload();
                            } else {
                                Swal.fire("Sorry!", data.message, "error");
                            }
                        },
                        error: function (errorString){
                            Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                        }
                    });
                }
            });
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
