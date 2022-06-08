@extends('layouts.app')
@section('title', 'Zip')
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
}
i.la.la-eye {
    color:#B21F24;
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
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard
                </h5>
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                <span class="text-muted font-weight-bold mr-4">Post Code</span>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-center">
                        <span class="card-label font-weight-bolder text-dark">Post Code List {{ isset($totalItems) && !empty($totalItems) ? '('.$totalItems.')'  :' '  }}</span>
                    </h3>
                    <div class="card-toolbar">
                        <a data-target="#staticBackdrop" data-toggle="modal" class="btn btn-primary font-weight-bolder"
                            id='btn_add_new'>
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
                            </span>Add Post Code</a>
                    </div>
                </div>
                <div class="card-body pt-2 pb-0 mt-n3">
                    <form class="kt-form kt-form--fit">
                        <div class="row mb-6">
                            <div class="col-lg-3 mb-lg-2 mb-2">
                                <label>Post Code:</label>
                                <input type="text" class="form-control datatable-input" placeholder="E.g: Code"
                                    data-col-index="1" />
                            </div>
                            <div class="col-lg-4 mb-lg-2 mb-2 d-flex justify-content-start px-2">
                                <label>&nbsp;</label><br />
                                <button class="btn btn-primary btn-primary--icon cut_btn_filters w-100 mr-2" id="kt_search">
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
                    <table class="table table-bordered table-checkable" id="datatableList">
                        <thead>
                            <tr>
                                <th>Sr</th>
                                <th>Code</th>
                                <th>Days</th>
                                <th>Created At</th>
                                <th>action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form onsubmit="return false" id="addForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Post Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <label class="control-label" for="Zip_Code">Post Code</label>
                    <input type="hidden" class="form-control" name="id" id="id" value="" />
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Post Code">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="checkbox-inline">
                                <label class="checkbox checkbox-square checkbox-danger">
                                    <input type="checkbox" id="sat" name="sat" value="sat" ><span></span>
                                    Saturday
                                </label>
                            </label>
                        </div>
                        <div class="col-sm-3">
                            <label class="checkbox-inline">
                                <label class="checkbox checkbox-square checkbox-danger">
                                    <input type="checkbox" id="sun"  name="sun" value="sun" ><span></span>
                                    Sunday
                                </label>
                            </label>
                        </div>
                        <div class="col-sm-3">
                            <label class="checkbox-inline">
                                <label class="checkbox checkbox-square checkbox-danger">
                                    <input type="checkbox" id="mon" name="mon" value="mon" ><span></span>
                                    Monday
                                </label>
                            </label>
                        </div>
                        <div class="col-sm-3">
                            <label class="checkbox-inline">
                                <label class="checkbox checkbox-square checkbox-danger">
                                    <input type="checkbox" id="tue" name="tue" value="tue" ><span></span>
                                    Tuesday
                                </label>
                            </label>
                        </div>
                        <div class="col-sm-3">
                            <label class="checkbox-inline">
                                <label class="checkbox checkbox-square checkbox-danger">
                                    <input type="checkbox" id="wed" name="wed" value="wed" ><span></span>
                                    Wednesday
                                </label>
                            </label>
                        </div>
                        <div class="col-sm-3">
                            <label class="checkbox-inline">
                                <label class="checkbox checkbox-square checkbox-danger">
                                    <input type="checkbox" id="thu" name="thu" value="thu" ><span></span>
                                    Thursday
                                </label>
                            </label>
                        </div>
                        <div class="col-sm-3">
                            <label class="checkbox-inline">
                                <label class="checkbox checkbox-square checkbox-danger">
                                    <input type="checkbox" id="fri" name="fri" value="fri" ><span></span>
                                    Friday
                                </label>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold"
                        data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary font-weight-bold" id="btn_save">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
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
                        'Sr', 'Name', 'Days', 'created_at'
                    ],
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            columns: [{
                    data: 'Sr'
                },
                {
                    data: 'Name'
                },
                {
                    data: 'Days'
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
    $(document).on('click', '#btn_add_new', function() {
        $('#staticBackdrop').modal({
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
                url: "{{route('zipSubmit')}}", // your php file name
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
    $(document).on('click', '.edit', function() {
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
            success: function(data) {
                if (data.status == 'success') {
                    $('#staticBackdrop').modal({
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
                    $("#sun").prop("checked", rec.sun);
                    $("#mon").prop("checked", rec.mon);
                    $("#tue").prop("checked", rec.tue);
                    $("#wed").prop("checked", rec.wed);
                    $("#thu").prop("checked", rec.thu);
                    $("#fri").prop("checked", rec.fri);
                    $("#sat").prop("checked", rec.sat);
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
                    url: "{{route('zipDelete')}}", // your php file name
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
                        Swal.fire("Sorry!",
                            "Something went wrong please contact to admin",
                            "error");
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
