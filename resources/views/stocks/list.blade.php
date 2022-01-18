@extends('layouts.app') @section('title', 'Stock List') @section('page_level_css_plugin')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" /> @endsection @section('page_level_css')
    <style>
           body{
        background-color: white;
        font-family: 'Poppins';
    }
    a.btn.btn-sm.btn-clean.btn-icon {  background-color: #FFE2E5;
    border-color: transparent;
}
a.btn.btn-sm.btn-clean.btn-icon.delete {
    background-color: #FFE2E5;
    border-color: transparent;
}
i.la.la-eye {
    color:#B21F24;
}
.btn.btn-clean i {
    color:#B21F24;
}
.btn.btn-clean i:hover{
    color: #FFE2E5 !important;
}
.btn.btn-clean i:active{
    color: #FFE2E5 !important;
}
.btn.btn-clean:not(:disabled):not(.disabled):active:not(.btn-text) i{color: #FFE2E5;
}
a.btn.btn-sm.btn-clean.btn-icon:hover {   background-color: #B21F24 !important;
    border-color: transparent;
}
a.btn.btn-sm.btn-clean.btn-icon.delete:hover {
    background-color: #B21F24;
    border-color: transparent;
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
            color: red!important;
        }

        span.select2.select2-container.select2-container--default {
            width: 100% !important;
        }
    </style> @endsection @php $userTypes=array('measurement','installation','customer_support','accountant','production_manager'); @endphp @section('content')
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Stock</h5>
                    <!--end::Page Title-->
                    <!--begin::Actions-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div> <span class="text-muted font-weight-bold mr-4">Stock List</span>
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
                            <span class="card-label font-weight-bolder text-dark">Stock Order {{ isset($totalItems) && !empty($totalItems) ? '('.$totalItems.')'  :' '  }}</span>
                        </h3>
                        <div class="card-toolbar">
                            <a data-target="#staticBackdrop" data-toggle="modal" class="btn btn-primary font-weight-bolder" id='btn_add_new'> <span class="svg-icon svg-icon-md">
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
                        </span>Add Stock</a>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-2 pb-0 mt-n3">
                        <!--begin::Tap pane-->
                        <form class="kt-form kt-form--fit">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label>Billing Number:</label>
                                        <input type="text"  class="form-control datatable-input" placeholder="Billing Number" data-col-index="0"> </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label>Supplier:</label>
                                        <select class="form-control kt_select2_1 datatable-input " id="supplier_search" data-col-index="1">
                                            <option value="">Supplier</option> @foreach($suppliers as $supplier)
                                                <option value="{{$supplier->id}}">{{ucfirst($supplier->name)}}</option> @endforeach </select>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label>&nbsp;</label>
                                    <br>
                                    <button class="btn btn-primary btn-primary--icon" id="kt_search"> <span>
                                            <i class="la la-search"></i>
                                            <span>Search</span> </span>
                                    </button>&#160;&#160;
                                    <button class="btn btn-secondary btn-secondary--icon" id="kt_reset"> <span>
                                            <i class="la la-close"></i>
                                            <span>Reset</span> </span>
                                    </button>
                                     </div>
                            </div>
                        </form>
                        <!--begin::Table-->
                        <table class="table table-bordered table-checkable" id="datatableList">
                            <thead>
                            <tr>
                                <th>Billing ID</th>
                                <th>Name</th>
                                <th>Total Price(£)</th>
                                <th>Qty</th>
                                <th>Created At</th>
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
    <!-----start stock add---->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <form onsubmit="return false" id="addForm">
                <input type="hidden" class="form-control" name="id" id="id" value="" />
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Stock
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <i aria-hidden="true" class="ki ki-close"></i> </button>
                </div>
                <div class="modal-body" style="height: 300px;">
                    <div class="col-4">
                        <div class="form-group ">
                            <label>Supplier<span class="text-danger">*</span></label>
                            <select class="form-control kt_select2_1" id="supplier_stock_id" name="supplier_stock_id">
                                <option value="">Supplier</option> @foreach($suppliers as $supplier)
                                    <option value="{{$supplier->id}}">{{ucfirst($supplier->name)}}</option> @endforeach </select>
                        </div>
                    </div>
                    <div class="card shadow-sm p-3 mb-5 bg-white rounded">
                        <div class="card-body">
                            <div class="row">
                                    <div class="col-lg-11 col-10">
                                        <div class="row">
                                            <div class="form-group col-lg-3 col-6">
                                                <label for="department">Department<span class="text-danger">*</span></label>
                                                <select class="form-control kt_select2_1 departments" onchange="getDeptItems(this.value,'0','0')" name="dept_stock[]"  id="dept_stock_id_0_0">
                                                    <option value="">Depatement</option>
                                                    @foreach($departments as $department)
                                                        <option value="{{$department->id}}">{{ucfirst($department->name)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class=" form-group col-lg-3 col-6">
                                                <label for="name">Item<span class="text-danger">*</span></label>
                                                <select class="form-control kt_select2_1 items" onchange="getItemUnit(this.value,'0','0')" name="item_stock[]" id="item_stock_id_0_0">
                                                    <option value="">Items</option>
                                                 </select>
                                            </div>
                                            <div class="form-group col-lg-3 col-6">
                                                <label for="unit">Unit<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="unit_stock[]" id="unit_stock_id_0_0" readonly></div>

                                        </div>
                                        <div class="row">
                                            <div class="col-10">
                                                <div class="row">
                                                    <div class="form-group col-lg-3 col-6">
                                                        <label for="department">Variant<span class="text-danger">*</span></label>
                                                        <select class="form-control kt_select2_1 variants" name="variant_stock[0][]" id="variant_stock_id_0_0">
                                                            <option value="">Variants</option>
                                                            @foreach($variants as $variant)
                                                                <option value="{{$variant->id}}">{{ucfirst($variant->name)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class=" form-group col-lg-3 col-6">
                                                        <label for="name">Per Unit Price<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="per_unit_price[0][]" onkeyup="calculateTotalPrice(0,0)" id="per_unit_price_0_0" >
                                                    </div>
                                                    <div class="form-group col-lg-3 col-6">
                                                        <label for="unit">qty<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control total_qty" name="qty_unit_price[0][]" onkeyup="calculateTotalPrice(0,0)" id="qty_unit_price_0_0" > </div>
                                                    <div class="form-group  col-lg-3 col-6">
                                                        <label for="qty">Total Price<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control total_price" name="total_variant_price[0][]" id="total_variant_price_0_0" readonly> </div>
                                                </div>
                                            </div>
                                            <div class="col-1 mt-7">
                                                <button type="button" onclick="addfield(0,0)" class="btn btn-primary">+</button>
                                            </div>
                                            <div id="newfield_0_0" class="col-12"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-2 mt-7">
                                        <button onclick="addcard(0)" type="button" class="btn btn-primary">+</button>
                                    </div>
                                </div>

                        </div>

                    </div>
                    <div id="newrowcard"></div>
                </div>
                <div class="row d-flex justify-content-end">
                    <div class="form-group col-lg-3 col-6">
                        <label for="unit">Quantity</label>
                        <input type="text" class="form-control" name="overall_total_qty" id="overall_total_qty" readonly>
                    </div>
                    <div class="form-group col-lg-3 col-6">
                        <label for="unit">Total Price</label>
                        <input type="text" class="form-control" id="overall_total_price" name="overall_total_price" readonly>
                    </div>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary font-weight-bold" id="btn_save">Save</button>
                </div>
            </div>
            </form>
        </div>
        <!----end stock----------->@endsection @section('page_level_js_plugin')
            <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.4') }}"></script>
            <script src="{{ asset('assets/plugins/custom/jqvalidation/jquery.validate.min.js?v=7.0.4') }}"></script> @endsection
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
                                url: "{{ route('getStockOrderList') }}",
                                type: 'POST',
                                data: {
                                    // parameters for custom backend script demo
                                    columnsDef: ['id', 'name', 'dept', 'price', 'qty', 'created_at'],
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                            },
                            columns: [{
                                data: 'id'
                            }, {
                                data: 'name'
                            },  {
                                data: 'price'
                            }, {
                                data: 'qty'
                            }, {
                                data: 'created_at'
                            }, {
                                data: 'action',
                                responsivePriority: -1,
                                bSortable: false
                            }, ],
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
                                if(params[i]) {
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
                                $('#type_search').val('').trigger('change')
                                $('#role_search').val('').trigger('change')
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
                            supplier_stock_id: {
                                required: true
                            },
                            ['dept_stock']: {
                                required: true
                            },
                            ['unit_stock']: {
                                required: true
                            },
                            ['qty_stock']: {
                                required: true
                            },

                        },
                        errorPlacement: function(error, element) {
                            var elem = $(element);
                            if(elem.hasClass("user_type")) {
                                error.appendTo(element.parent().after());
                                //error.insertAfter(element);
                            } else if(elem.hasClass("user_role")) {
                                error.appendTo(element.parent().after());
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
                        $('#supplier_stock_id').val('').trigger('change.select2');
                        $('.items').val('').trigger('change.select2');
                        $('#variants').val('').trigger('change.select2');
                        $('#departments').val('').trigger('change.select2');
                    });
                    $(document).on('click', '#btn_save', function() {
                        var validate = $("#addForm").valid();
                        if(validate) {
                            var form_data = $("#addForm").serializeArray();
                            $.ajax({
                                type: "POST",
                                url: "{{route('stockorderSubmit')}}", // your php file name
                                data: form_data,
                                dataType: "json",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(data) {
                                    if(data.status == 'success') {
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
                            url: "{{route('getUserById')}}", // your php file name
                            data: form_data,
                            dataType: "json",
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                if(data.status == 'success') {
                                    $('#staticBackdrop').modal({
                                        backdrop: 'static',
                                        keyboard: false
                                    }).on('hide.bs.modal', function() {
                                        $("#addForm").validate().resetForm();
                                    });
                                    var rec = data.data;
                                    console.log(rec);
                                    var id = rec.id;
                                    var name = rec.name;
                                    $('#id').val(id);
                                    $('#name').val(name);
                                    $('#phone').val(rec.phone_number);
                                    $('#email').val(rec.email).prop("readonly", true);
                                    //$('#user_type').val(rec.type);
                                    $('#user_type').val(rec.type).trigger('change');
                                    $('#user_role').val(rec.role_id).trigger('change');
                                    if(rec.type == 'installment' || rec.type == 'measurement') {
                                        $('#show_type').show();
                                        var zips = data.zipIDs;
                                        var str_array = zips.split(',');
                                        $("#zip_id").val(str_array).trigger("change");
                                    }
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
                            if(result.value) {
                                $.ajax({
                                    type: "POST",
                                    url: "{{route('stockorderDelete')}}", // your php file name
                                    data: form_data,
                                    dataType: "json",
                                    processData: false,
                                    contentType: false,
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function(data) {
                                        if(data.status == 'success') {
                                            Swal.fire("Success!", data.message, "success");
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
                    });
                    var input = document.getElementById("addForm");
                    input.addEventListener("keyup", function(event) {
                        if(event.keyCode === 13) {
                            event.preventDefault();
                            document.getElementById("btn_save").click();
                        }
                    });
                });

                function getUserType(userType) {
                    if(userType == 'installation' || userType == 'measurement') {
                        $('#show_type').show();
                    } else {
                        $('#show_type').hide();
                    }
                }
                var cardnumber = 1;

                function addcard(id) {
 var card='<div class="card shadow-sm p-3 mb-5 bg-white rounded mt-5" id=card_row_'+cardnumber+'>';
     card+='<div class="card-body">';
            card+='<div class="row">';

                    card+=' <div class="col-lg-11 col-10">';
                            card+='<div class="row">';
                                        card+='<div class="form-group col-lg-3 col-6"><label for="department">Department:</label>';
                                                card+='<select class="form-control kt_select2_1" onchange="getDeptItems(this.value,'+cardnumber+',0)" name="dept_stock['+cardnumber+']" id="dept_stock_id_'+cardnumber+'_0">';
                                                         card+='<option value="">Depatement</option>';
                                                                @foreach($departments as $department)
                                                                card+='<option value="{{$department->id}}">{{ucfirst($department->name)}}</option>';
                                                                 @endforeach
                                                 card+='</select>';
                                        card+='</div>';

                                        card+='<div class="form-group col-lg-3 col-6"><label for="name">Item:</label>';
                                                card+='<select class="form-control kt_select2_1" onchange="getItemUnit(this.value,'+cardnumber+',0)" id="item_stock_id_'+cardnumber+'_0"  name="item_stock['+cardnumber+']">';
                                                        card+='<option value="">Item</option>';
                                                         card+='</select>';
                                        card+='</div>';
                                         card+='<div class="form-group col-lg-3 col-6">';
                                            card+='<label for="unit">Unit<span class="text-danger">*</span></label><input type="text" class="form-control" id="unit_stock_id_'+cardnumber+'_0"  name="unit_stock['+cardnumber+']"  readonly></div>';

                            card+='</div>';
                            card+='<div class="row">';
                                    card+='<div class="col-10">';
                                            card+='<div class="row">';
                                                        card+='<div class="form-group col-lg-3 col-6">';
                                                                card+='<label for="department">Variant<span class="text-danger">*</span></label>';
                                                                        card+='<select class="form-control kt_select2_1" name="variant_stock['+cardnumber+'][]" id="variant_stock_id_'+cardnumber+'_0">';
                                                                                card+='<option value="">Variants</option>';
                                                                        card+='</select>';
                                                        card+='</div>';
                                                        card+='<div class="form-group col-lg-3 col-6">';
                                                        card+='<label for="name">Per Unit Price<span class="text-danger">*</span></label><input type="text" id="per_unit_price_'+cardnumber+'_0" name="per_unit_price['+cardnumber+'][]" class="form-control" onkeyup="calculateTotalPrice('+cardnumber+',0)">';
                                                        card+='</div>';
                                                        card+='<div class="form-group col-lg-3 col-6"><label for="unit">qty<span class="text-danger">*</span></label><input type="text" id="qty_unit_price_'+cardnumber+'_0" onkeyup="calculateTotalPrice('+cardnumber+',0)" name="qty_unit_price['+cardnumber+'][]" class="form-control total_qty">';
                                                        card+='</div>';
                                                        card+='<div class="form-group col-lg-3 col-6">';
                                                        card+='<label for="unit">Total Price<span class="text-danger">*</span></label><input type="text"  id="total_variant_price_'+cardnumber+'_0"  name="total_variant_price['+cardnumber+'][]" class="form-control total_price" readonly>';
                                                        card+='</div>';
                                            card+='</div>';
                                    card+='</div>';
                                    card+='<div class="col-2 mt-7"><button onclick="addfield('+cardnumber+',0)" class="btn btn-primary">+</button></div>';
                                    card+=' <div id="newfield_'+cardnumber+'_'+0+'" class="col-12"></div>';
                            card+='</div>';

                    card+='</div>';

                    card+='<div class="col-lg-1 col-2 mt-7"><button onclick="removeText('+cardnumber+')" class="btn btn-primary">-</button></div>';


            card+='</div>';
     card+='</div>';
 card+='</div>';


                    $('#newrowcard').append(card);
                    cardnumber++;


                }

                function removeText(id) {
                    $('#card_row_' + id).remove();
                }
                var numbervar = 1;

                function addfield(main,id) {

                   var item_id=$('#item_stock_id_'+main+'_'+id).val();

                   if(item_id!=''){

                       var html='<div class=row id=row_'+numbervar+'>';
                       html+='<div class=col-10>';
                       html+='<div class="row">';
                       html+='<div class="form-group col-lg-3 col-6"><label for=department>Variant<span class="text-danger">*</span></label><div id="append_va_'+main+'_'+numbervar+'"><select class="form-control kt_select2_1" name="variant_stock['+main+']['+numbervar+']" id="variant_stock_id_'+main+'_'+numbervar+'">';
                       html+='<option value="">Variants</option>';
                       html+='</select>';
                       html+='</select></div></div>';
                       html+='<div class="form-group col-lg-3 col-6">';
                       html+='<label for="name">Per Unit Price<span class="text-danger">*</span></label><input type="text" id="per_unit_price_'+main+'_'+numbervar+'" name="per_unit_price['+main+']['+numbervar+']" class="form-control" onkeyup="calculateTotalPrice('+main+','+numbervar+')"></div>';
                       html+='<div class="form-group col-lg-3 col-6"><label for="unit">qty<span class="text-danger">*</span></label><input type="text" id="qty_unit_price_'+main+'_'+numbervar+'" onkeyup="calculateTotalPrice('+main+','+numbervar+')" name="qty_unit_price['+main+']['+numbervar+']" class="form-control total_qty"></div>';
                       html+='<div class="form-group col-lg-3 col-6"><label for="unit">Total Price<span class="text-danger">*</span></label><input type="text"  id="total_variant_price_'+main+'_'+numbervar+'"  name="total_variant_price['+main+']['+numbervar+']" class="form-control total_price" readonly></div>';
                       html+='</div>';
                       html+='</div>';
                       html+='<div class="col-2 mt-7">';
                       html+='<button type="button" onclick="removeField('+numbervar+')" class="btn btn-primary">-</button>';
                       html+='</div>';
                       html+='<div id="newfield_'+main+'_'+numbervar+'" class="col-12"></div>';
                       html+='</div>';

                       $('#newfield_'+main+'_'+id+'').append(html);
                       clonevariant(main,id,numbervar);


                       numbervar++;

                   }else{

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
                           toastr.warning('please choose item first');
                   }


 }
 function removeField(id) {
    $('#row_' + id).remove();
                }

 function getDeptItems(depID,number,line){


     var form_data = new FormData();
     form_data.append('depID', depID);
     $.ajax({
         type: "POST",
         url: "{{route('getDeptItems')}}", // your php file name
         data: form_data,
         dataType: "json",
         processData: false,
         contentType: false,
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         success: function(datas) {

             $('#item_stock_id_'+number+'_'+line).empty();
             $('#item_stock_id_'+number+'_'+line).append(new Option("Select Item", "")).trigger("updated");
             $.each(datas, function (i, data) {
                 $('#item_stock_id_'+number+'_'+line).append($('<option>', {
                     value: data.id+'~'+data.unit,
                     text : data.name
                 })).trigger("updated");
             });
         },
         error: function(errorString) {
             Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
         }
     });

 }

 function getItemUnit(itemID,number,line){
     let itemUnit = itemID;
     var myArray = itemUnit.split("~");
     var form_data = new FormData();
     form_data.append('item_id', myArray[0]);

     $.ajax({
         type: "POST",
         url: "{{route('getItemVariants')}}", // your php file name
         data: form_data,
         dataType: "json",
         processData: false,
         contentType: false,
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         success: function(datas) {

             var myArray = itemUnit.split("~");
             $('#unit_stock_id_'+number+'_'+line).val('');
             $('#unit_stock_id_'+number+'_'+line).val(myArray[1]);

             $('#variant_stock_id_'+number+'_'+line).empty();
             $('#variant_stock_id_'+number+'_'+line).append(new Option("Select Variant", "")).trigger("updated");
             $.each(datas.variant_detail, function (i, data) {
                 $('#variant_stock_id_'+number+'_'+line).append($('<option>', {
                     value: data.id,
                     text : data.name
                 })).trigger("updated");
             });





         },
         error: function(errorString) {
             Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
         }
     });





 }

 function  clonevariant(main,id,numbervar)
 {
     var ddl = $("#variant_stock_id_"+main+'_'+id).clone();
     ddl.attr("id", 'variant_stock_id_'+main+'_'+numbervar);
     ddl.attr("name", "variant_stock["+main+"]["+numbervar+"]");
     ddl.attr("class", "form-control kt_select2_1");
     $('#append_va_'+main+'_'+numbervar).empty();
     $("#append_va_"+main+'_'+numbervar).append(ddl);

 }

 function calculateTotalPrice(main,number){
    var unit_variant=$('#per_unit_price_'+main+'_'+number).val();
    var qty_variant=$('#qty_unit_price_'+main+'_'+number).val();
    if(unit_variant==''){unit_varaint=0;}
    if(qty_variant==''){qty_variant=0;}
    var total_amount=unit_variant * qty_variant;
    $('#total_variant_price_'+main+'_'+number).val(total_amount);

     var totalqtyvalues = [];
     $('.total_qty').each(function(){
         totalqtyvalues.push({ name: this.name, value: this.value });
     });
     var totalqtyvalues = 0;
     $(".total_qty").each(function(){
         totalqtyvalues += +$(this).val();
     });
     $('#overall_total_qty').val(totalqtyvalues);
     var totalpricevalues = 0;
     $(".total_price").each(function(){
         totalpricevalues += +$(this).val();
     });
     $('#overall_total_price').val(totalpricevalues);



 }
                @if(Session::has('error'))
                    toastr.options =
                    {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                toastr.warning("{{ session('error') }}");
                @endif
</script> @endsection
