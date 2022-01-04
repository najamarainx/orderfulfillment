@extends('layouts.app')
@section('title', 'Zip')
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
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-2">
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard

                </h5>
                <!--end::Page Title-->
                <!--begin::Actions-->
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                <span class="text-muted font-weight-bold mr-4">Post Code</span>
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
                        <span class="card-label font-weight-bolder text-dark">Post Code List</span>
                    </h3>
                    <div class="card-toolbar">

                        <a data-target="#staticBackdrop" data-toggle="modal" class="btn btn-primary font-weight-bolder"
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
                            </span>Add Post Code</a>
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-2 pb-0 mt-n3">

                    <!--begin::Tap pane-->
                    <form class="kt-form kt-form--fit">
                        <div class="row mb-6">
                            <div class="col-lg-3 mb-lg-2 mb-2">
                                <label>Post Code:</label>
                                <input type="text" class="form-control datatable-input" placeholder="E.g: Code"
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
                    <!--begin::Table-->

                    <table class="table table-bordered table-checkable" id="datatableList">
                        <thead>
                            <tr>
                                <th>Sr</th>
                                <th>Code</th>
                                <th>Created At</th>
                                <th>action</th>
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
                        'Sr', 'Name', 'created_at'
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
