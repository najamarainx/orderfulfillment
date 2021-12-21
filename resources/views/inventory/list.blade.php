@extends('layouts.app')
@section('title', 'Inventory Item')

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
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Invenotry</h5>
                <!--end::Page Title-->
                <!--begin::Actions-->
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                <span class="text-muted font-weight-bold mr-4">Inventory List</span>
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
                    <h3 class="card-label">Inventory Item List
                    </h3>
                </div>
                {{-- <div class="card-toolbar">
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
                </div> --}}
            </div>
            <div class="card-body">
                <form class="kt-form kt-form--fit">
                    <div class="row mb-6">
                        <div class="col-lg-3 mb-lg-2 mb-2">
                            <label>Department: <span class="text-danger">*</span> </label>
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
                            <label>Item: <span class="text-danger">*</span> </label>
                            <select   class="form-control datatable-input kt_select2_1"  data-col-index="2">
                                    @if(!empty($items))
                                    <option value="">Select</option>
                                    @foreach ($items as $itemObj)
                                      <option value="{{$itemObj->id}}">{{$itemObj->name}}</option>
                                    @endforeach
                                    @endif
                            </select>
                        </div>
                        <div class="col-lg-3 mb-lg-2 mb-2">
                            <label>Variant: <span class="text-danger">*</span> </label>
                            <select   class="form-control datatable-input kt_select2_1"  data-col-index="3">
                                    @if(!empty($variants))
                                    <option value="">Select</option>
                                    @foreach ($variants as $variantObj)
                                      <option value="{{$variantObj->id}}">{{$variantObj->name}}</option>
                                    @endforeach
                                    @endif
                            </select>
                        </div>
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
                <table class="table table-bordered table-checkable" id="inventoryItemList">
                    <thead>
                        <tr>
                            <th>Sr</th>
                            <th>Department</th>
                            <th>Item</th>
                            <th>Variant</th>
                            <th>Qty</th>
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
                table = $('#inventoryItemList').DataTable({
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
                        url: "{{ route('getInventoryItemList') }}",
                        type: 'POST',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'id','department', 'item','variant','qty'
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
                            data: 'department'
                        },
                        {
                            data: 'item'
                        },
                        {
                            data: 'variant'
                        },
                        {
                            data: 'qty'
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

        })

</script>
@endsection
