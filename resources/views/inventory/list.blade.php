@extends('layouts.app')
@section('title', 'Inventory Item')
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
        span.select2.select2-container.select2-container--default {
            width:100% !important;
        }
    </style>
@endsection
@section('content')
<div class="d-flex flex-column-fluid">
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Invenotry</h5>
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                <span class="text-muted font-weight-bold mr-4">Inventory List</span>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Inventory Item List {{ isset($totalItems) && !empty($totalItems) ? '('.$totalItems.')'  :' '  }}
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <form class="kt-form kt-form--fit">
                    <div class="row mb-6">
                        <div class="col-lg-3 mb-lg-2 mb-2">
                            <label>Department: <span class="text-danger">*</span> </label>
                            <select   class="form-control datatable-input kt_select2_1 inventory_search "  data-col-index="1">
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
                            <select   class="form-control datatable-input kt_select2_1 inventory_search"  data-col-index="2">
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
                            <select   class="form-control datatable-input kt_select2_1 inventory_search"  data-col-index="3">
                                    @if(!empty($variants))
                                    <option value="">Select</option>
                                    @foreach ($variants as $variantObj)
                                      <option value="{{$variantObj->id}}">{{$variantObj->name}}</option>
                                    @endforeach
                                    @endif
                            </select>
                        </div>
                        <div class="col-lg-3 mb-lg-2 mb-2 d-flex justify-content-between px-2">
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
                    $('.inventory_search').val('').trigger('change')
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
