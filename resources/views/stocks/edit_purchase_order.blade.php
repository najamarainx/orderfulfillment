@extends('layouts.app')
@section('title', 'Order Preview')

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

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">


                        <div id="kt_repeater_2">
                            <div class="card card-custom">
                                <div class="card-header d-flex justify-content-between">
                                    <h3 class="card-title">Add New Inventory</h3>
                                    <div data-repeater-create="" onclick="addRow()" class="btn btn-primary align-content-center h-100 mt-4">
                                        <i class="ki ki-plus text-white"></i>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <!--begin::Table-->
                                    <form id="addForm" method="post">
                                    <input type="hidden" name="id" name="id" value="{{$orderItems->id}}">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-12 form-group ">
                                            <label class="mb-0">Select Supplier</label>
                                            <select class="form-control form-control-lg kt_select2_1 w-100" data-live-search="true" name="supplier_id" id="supplier_id">
                                                <option value="">Select Supplier</option>
                                                @foreach($suppliers as $supplier)
                                                    <option value="{{$supplier->id}}" {{isset($orderItems->supplierDetail->id) && $orderItems->supplierDetail->id==$supplier->id ? 'selected' : ''}}>{{ucfirst($supplier->name)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!--begin::Table-->
                                    <div class="table-responsive">
                                        <table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_4">
                                            <thead>
                                            <tr class="text-left">
                                                <th style="min-width: 110px">Department</th>
                                                <th style="min-width: 120px">Item Name</th>
                                                <th style="min-width: 120px">Unit</th>
                                                <th style="min-width: 120px">Variant</th>
                                                <th style="min-width: 120px">Unit Price</th>
                                                <th style="min-width: 120px">Quantity</th>
                                                <th style="min-width: 120px">Total Price</th>
                                                <th class="pr-0 text-right" style="min-width: 160px">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody data-repeater-list="">
                                            @php
                                                $totalAmount = 0;
                                                $totalQty = 0;
                                            @endphp
                                            @foreach ($orderItems->stockOrderDetail as $key=>$orderItemObj)
                                                @php
                                                    $totalAmount += $orderItemObj->total_price;
                                                    $totalQty += $orderItemObj->qty;
                                                @endphp
                                                <tr id="{{$key}}">
                                                    <td>
                                                        <div class="form-group mb-0">
                                                            <select class="form-control form-control-lg kt_select2_1 " onchange="getDeptItems(this.value,{{$key}})" name="department_id[]" id="department_id_{{$key}}" data-live-search="true">
                                                                <option value="">Select Department</option>
                                                                @foreach($departments as $department)
                                                                    <option value="{{$department->id}}" {{isset($orderItemObj->department_id) && $orderItemObj->department_id==$department->id ? 'selected' : ''}}>{{ucfirst($department->name)}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group mb-0">
                                                            <select class="form-control form-control-lg kt_select2_1 " onchange="getItemUnit(this.value,{{$key}})" id="item_id_{{$key}}" disabled data-live-search="true">
                                                                <option value="">Select Item</option>
                                                                @foreach($items as $item)
                                                                    <option value="{{$item->id}}" {{isset($orderItemObj->item_id) && $orderItemObj->item_id==$item->id ? 'selected' : ''}}>{{ucfirst($item->name)}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <input type="hidden" name="item_id[]" id="item_select_{{$key}}" value="{{isset($orderItemObj->item_id) && !empty($orderItemObj->item_id) ? $orderItemObj->item_id : ''}}">
                                                    </td>
                                                    <td>
                                                        <div class="form-group mb-0">
                                                            <input class="form-control" type="text" id="unit_item_{{$key}}" readonly value="{{!empty($orderItemObj->orderItem->unit) ? $orderItemObj->orderItem->unit : ''}}" placeholder="">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group mb-0">
                                                            <select class="form-control form-control-lg kt_select2_1 w-100" name="variant[]" id="varaint_id_{{$key}}"  data-live-search="true">
                                                                <option value="">Select Variant</option>
                                                                @foreach($variants as $variant)
                                                                    <option value="{{$variant->id}}" {{isset($orderItemObj->variant_id) && $orderItemObj->variant_id==$variant->id ? 'selected' : ''}}>{{$variant->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group mb-0">
                                                            <input class="form-control" type="number" name="unit_price[]" onkeyup="calculateTotalPrice({{$key}})" id="unit_price_{{$key}}" value="{{floor($orderItemObj->per_unit_price)}}" placeholder="Unit Price">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group mb-0">
                                                            <input class="form-control total_qty" type="number" name="qty[]" onkeyup="calculateTotalPrice({{$key}})" id="qty_id_{{$key}}" value="{{floor($orderItemObj->qty)}}" placeholder="Quantity">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group mb-0">
                                                            <input class="form-control total_price" type="number" readonly name="price[]" id="price_id_{{$key}}" value="{{floor($orderItemObj->total_price)}}">
                                                        </div>
                                                    </td>

                                                    <td class="pr-0 text-right">
                                                        <a href="javascript:;"  class="btn btn-icon btn-light btn-hover-primary btn-sm removetr" data-id="{{$key}}">
																			<span class="svg-icon svg-icon-md svg-icon-primary">
																				<!--begin::Svg Icon | path:assets/media/svg/icons/General/Trash.svg-->
																				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																						<rect x="0" y="0" width="24" height="24" />
																						<path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero" />
																						<path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3" />
																					</g>
																				</svg>
                                                                                <!--end::Svg Icon-->
																			</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                    <!--end::Table-->
                                    <hr class="w-100">

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-12">
                                            <div class="form-group mb-0">
                                                <label class="mb-0">Total Quantity</label>
                                                <input class="form-control text-dark qty" name="overall_total_qty" value="{{$totalQty}}" type="number" readonly placeholder="Total Quantity">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12">
                                            <div class="form-group mb-0">
                                                <label class="mb-0">Total Price</label>
                                                <input class="form-control text-dark price" value="{{$totalAmount}}" name="overall_total_price" type="number" readonly placeholder="Total Price">
                                            </div>
                                        </div>
                                    </div>

                                    </form>
                                </div>
                                <div class="card-footer text-right w-100">
                                    <button type="reset" class="btn btn-secondary mr-3">Cancel</button>
                                    <button type="button" id="btn_save" data-id="save_inventory" class="btn btn-primary">Save Inventory</button>
                                    <button type="button" id="btn_save" data-id="save" class="btn btn-primary">Save </button>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>



            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
    <!--end::Content-->
@endsection
@section('page_level_js')
    <script type="text/javascript">
        function getDeptItems(depID,line){


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
                    $('#unit_item_'+line).val('');
                    $('#item_id_'+line).removeAttr('disabled');
                    $('#item_id_'+line).empty();
                    $('#item_id_'+line).append(new Option("Select Item", "")).trigger("updated");
                    $.each(datas, function (i, data) {
                        $('#item_id_'+line).append($('<option>', {
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

        function getItemUnit(itemID,line){
            let itemUnit = itemID;
            var myArray = itemUnit.split("~");
            $('#unit_item_'+line).val('');
            $('#unit_item_'+line).val(myArray[1]);
            $('#item_select_'+line).val('');
            $('#item_select_'+line).val(myArray[0]);
        }

        function calculateTotalPrice(number=-1){

            if(number!=-1){
                var unit_variant=$('#unit_price_'+number).val();
                var qty_variant=$('#qty_id_'+number).val();
                if(unit_variant==''){unit_varaint=0;}
                if(qty_variant==''){qty_variant=0;}
                var total_amount=unit_variant * qty_variant;
                $('#price_id_'+number).val(total_amount);
            }
            var totalqtyvalues = 0;
            $(".total_qty").each(function(){
                totalqtyvalues += +$(this).val();
            });
            $('.qty').val(totalqtyvalues);
            var totalpricevalues = 0;
            $(".total_price").each(function(){
                totalpricevalues += +$(this).val();
            });

            $('.price').val(totalpricevalues);

        }

        /*$('#kt_advance_table_widget_4 tr').click(function(){
            $(this).remove();
            calculateTotalPrice();
            return false;
        });*/

        $(document).on('click', '.removetr', function() {
            var id = $(this).data('id');
            $('table#kt_advance_table_widget_4 tr#'+id).remove();
            calculateTotalPrice();

        });

        function addRow()
        {
            var rowid=$('#kt_advance_table_widget_4 tr:last').attr('id');
            rowid=parseInt(rowid) + parseInt(1);
            var html='<tr id='+rowid+'>';

            html+='<td><div class="form-group mb-0">';
            html+='<select class="form-control form-control-lg kt_select2_1 " name="department_id[]" onchange="getDeptItems(this.value,'+rowid+')" id="department_id_'+rowid+'"  data-live-search=true>';
            html+='<option value="">Select Department</option>';
                    @foreach($departments as $department)
                    html+='<option value="{{$department->id}}">{{ucfirst($department->name)}}</option>';
                    @endforeach
            html+='</select>';
            html+='</div></td>';

            html+='<td><div class="form-group mb-0">';
            html+='<select class="form-control form-control-lg kt_select2_1 " onchange="getItemUnit(this.value,'+rowid+')" id="item_id_'+rowid+'" disabled data-live-search=true>';
            html+='<option value="">Select Item</option>';

            html+='</select>';
            html+='</div> <input type="hidden" name="item_id[]" id="item_select_'+rowid+'"></td>';



            html+='<td><div class="form-group mb-0">';
            html+='<div class="form-group mb-0">';
            html+='<input class="form-control" type="text" id="unit_item_'+rowid+'" readonly  placeholder="">';
            html+='</div>';
            html+='</div></td>';

            html+='<td><div class="form-group mb-0">';
            html+='<select class="form-control form-control-lg kt_select2_1 " name="variant[]" id="varaint_id_'+rowid+'"  data-live-search=true>';
            html+='<option value="">Select Variant</option>';
            @foreach($variants as $variant)
             html+='<option value="{{$variant->id}}">{{$variant->name}}</option>';
            @endforeach
            html+='</select>';
            html+='</div></td>';

            html+='<td><div class="form-group mb-0">';
            html+='<div class="form-group mb-0">';
            html+=' <input class="form-control" type="number" name="unit_price[]" onkeyup="calculateTotalPrice('+rowid+')" id="unit_price_'+rowid+'"  placeholder="Unit Price">';
            html+='</div>';
            html+='</div></td>';

            html+='<td><div class="form-group mb-0">';
            html+=' <input class="form-control total_qty" type="number" name="qty[]" onkeyup="calculateTotalPrice('+rowid+')" id="qty_id_'+rowid+'"  placeholder="Quantity">';
            html+='</div></td>';

            html+='<td><div class="form-group mb-0">';
            html+='<input class="form-control total_price" type="number" readonly name="price[]" id="price_id_'+rowid+'">';
            html+='</div></td>';

            html+='<td class="pr-0 text-right">';
            html+='<a href="javascript:;" data-repeater-delete="" class="btn btn-icon btn-light btn-hover-primary btn-sm removetr" data-id="'+rowid+'">';
            html+='<span class="svg-icon svg-icon-md svg-icon-primary">';
            html+='<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24" /><path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero" /><path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3" /></g></svg>';
            html+='</span>';
            html+='</a>';
            html+='</td>';

            html+='</tr>';

            $("#kt_advance_table_widget_4 > tbody").append(html);




        }



        $(document).on('click', '#btn_save', function() {
            var id = $(this).data('id');
            if(id=='save'){id=0;}
            if(id=='save_inventory'){id=1;}
            var form_data = $("#addForm").serializeArray();
            //form_data.push('is_verified', id);
            form_data.push({ name: "is_verified", value: id });
            $.ajax({
                type: "POST",
                url: "{{route('stockorderUpdate')}}", // your php file name
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

                        window.location ="{{ route('stockList') }}";


                    } else {
                        Swal.fire("Sorry!", data.message, "error");
                    }
                },
                error: function(errorString) {
                    Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                }
            });

        });
    </script>
@endsection
