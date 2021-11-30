@extends('layouts.app')
@section('title', 'Zip')
@section('page_level_css_plugins')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.4') }}" rel="stylesheet"
          type="text/css" />
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
                            <span class="card-label font-weight-bolder text-dark">Zip List</span>
                        </h3>
                        <div class="card-toolbar">
                            <ul class="nav nav-pills nav-pills-sm nav-dark-75">
                                <li class="nav-item">
                                    <a class="nav-link py-2 px-4 active" data-toggle="modal" data-target="#staticBackdrop">Add Zip</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-2 pb-0 mt-n3">

                        <!--begin::Tap pane-->
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <input type="number" class="form-control" placeholder="Name">
                                </div>
                            </div>


                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <div class="d-flex justify-content-between align-content-between">
                                    <button type="button" class="btn btn-outline-primary w-100 mr-2">Reset</button>
                                    <button type="button" class="btn btn-primary w-100 ml-2">Search</button>
                                </div>
                            </div>
                        </div>
                        <!--begin::Table-->
                        <div class="table-responsive">
                            <table class="table table-bordered table-checkable" id="datatableList">
                                <thead>
                                <tr class="text-left text-uppercase">
                                    <th class="px-0">Sr</th>
                                    <th>Code</th>
                                    <th>Created At</th>
                                    <th class="pr-0 ">action</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr class="text-left text-uppercase">
                                    <th class="px-0">Sr</th>
                                    <th>Code</th>
                                    <th>Created At</th>
                                    <th class="pr-0 ">action</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
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
            <form onsubmit="return false" id="addForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Zip Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="id" id="id" value="" />
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <input type="name" id="name" class="form-control" placeholder="Zip Code">
                            </div>
                        </div>
                     </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
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

        $(document).on('click', '#btn_add_new', function() {
            $('#add_edit_modal').modal({
                backdrop: 'static',
                keyboard: false
            }).on('hide.bs.modal', function() {
                validator.resetForm();
            });
            resetForm();
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
