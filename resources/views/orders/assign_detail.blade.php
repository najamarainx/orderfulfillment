@extends('layouts.app')
@section('title', 'Order Detail')

@section('page_level_css_plugin')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page_level_css')
    <style>
        .error {
            color: red !important;
        }

         .float_end {
             text-align: end;
         }

        .font_weight {
            font-weight: 100 !important;
        }

        .card {
            box-shadow: -4px 0px 13px 0px rgb(156 165 204 / 52%) !important;
        }

        .ml {
            margin-left: 1rem;
        }

        .inc_dec {
            padding: 0;
        }

        .mt {
            margin-top: 2rem;
        }

        .tableFixHead {
            overflow-y: auto;
            height: 200px;
        }

        .tableFixHead thead th {
            position: sticky;
            top: 0;
        }
        .ml {
            margin-left: 5.5px;
            margin-right: 6px;
        }
        .w_5 {
            width: 5rem;
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
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Detail Page</h5>
                    <!--end::Page Title-->
                    <!--begin::Actions-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200">
                    </div>
                    <span class="text-muted font-weight-bold mr-4">Detail Page</span>
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
                    <!--begin::Advance Table Widget 3-->
                    <div class="col-lg-12">
                        <div class="card card-custom gutter-b">
                            <!--begin::Header-->
                            <div class="card-header border-0 py-5">
                                <h3 class="card-title align-items-center">
                                                <span class="card-label font-weight-bolder text-dark">Order
                                                    (#{{$orderItems->id}})</span>
                                    <input type="hidden" name="order_id" id="order_id" value="{{$orderItems->id}}">
                                </h3>
                                <button type="button" id="proceed_inventory" data-id="{{$orderItems->id}}" class="btn btn-primary font-weight-bold">Proceed</button>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body pt-0 pb-3">
                                <!--begin::Table-->
                                <div class="table-responsive">
                                    <table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_3">
                                        <thead>
                                        <tr class="text-left text-uppercase">
                                            <th class="px-0">Product Name</th>
                                            <th>Quantity</th>
                                            <th class="text-info">Dimensions</th>
                                            <th>Measurement</th>
                                            <th style="min-width: 137px">Fittings Type</th>
                                            <th>Side Of Controls
                                            </th>
                                            <th>Chain Color
                                            </th>
                                            <th>Fittings Option
                                            </th>
                                            <th>Status
                                            </th>
                                            <th class="pr-0 text-right" style="min-width: 160px">action
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orderItems->orderdetail as $orderItem)
                                        <tr>
                                            <td class="pl-0">
                                                <a href="#" class="text-dark-75 font-weight-normal text-hover-primary mb-1 ">{{ucfirst($orderItem->orderProducts->name)}}</a>
                                            </td>
                                            <td>
                                                <span class="text-dark-75 font-weight-normal d-block ">{{$orderItem->qty}}</span>
                                            </td>
                                            <td>
                                                <span class="text-dark-75 font-weight-normal d-block ">{{$orderItem->dimension}}</span>
                                            </td>
                                            <td>
                                                <span class="text-dark-75 font-weight-normal d-block ">{{ucfirst($orderItem->scale)}}</span>
                                            </td>
                                            <td>
                                                <span class="text-dark-75 font-weight-normal d-block ">{{ucfirst($orderItem->fitting_type)}}</span>
                                            </td>
                                            <td>
                                                 <span class="text-dark-75 font-weight-normal d-block ">{{ucfirst($orderItem->side_control)}}</span>
                                            </td>
                                            <td>
                                                 <span class="text-dark-75 font-weight-normal d-block ">{{ucfirst($orderItem->chain_color)}}</span>
                                            </td>
                                            <td>
                                                 <span class="text-dark-75 font-weight-normal d-block ">{{ucfirst($orderItem->fitting_option)}}</span>
                                            </td>
                                            <td>
                                                <span class="label label-lg label-light-success label-inline">Pending</span>
                                            </td>
                                            <td class="text-right pr-0">

                                                <a onclick="returnProductInventory({{$orderItem->product_id}})" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                                                    <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Write.svg-->
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                             width="24px" height="24px"
                                                                             viewBox="0 0 24 24" version="1.1">
                                                                            <g stroke="none" stroke-width="1"
                                                                               fill="none" fill-rule="evenodd">
                                                                                <rect x="0" y="0" width="24"
                                                                                      height="24" />
                                                                                <path
                                                                                    d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z"
                                                                                    fill="#000000" fill-rule="nonzero"
                                                                                    transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)" />
                                                                                <path
                                                                                    d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z"
                                                                                    fill="#000000" fill-rule="nonzero"
                                                                                    opacity="0.3" />
                                                                            </g>
                                                                        </svg>
                                                                        <!--end::Svg Icon-->
                                                                    </span>
                                                </a>

                                                <a onclick="assignProductInventory({{$orderItem->product_id}})" class="btn btn-icon btn-light btn-hover-primary btn-sm" data-toggle="modal" data-target="#staticBackdrop1">
                                                                    <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/General/Trash.svg-->
                                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<polygon points="0 0 24 0 24 24 0 24"></polygon>
																				<rect fill="#000000" opacity="0.3" x="11" y="5" width="2" height="14" rx="1"></rect>
																				<path d="M6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 C4.90236893,18.3165825 4.90236893,17.6834175 5.29289322,17.2928932 L11.2928932,11.2928932 C11.6714722,10.9143143 12.2810586,10.9010687 12.6757246,11.2628459 L18.6757246,16.7628459 C19.0828436,17.1360383 19.1103465,17.7686056 18.7371541,18.1757246 C18.3639617,18.5828436 17.7313944,18.6103465 17.3242754,18.2371541 L12.0300757,13.3841378 L6.70710678,18.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 14.999999) scale(1, -1) translate(-12.000003, -14.999999)"></path>
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

                            </div>
                            <!--end::Body-->
                        </div>
                    </div>

                </div>
                <div class="row">
                    <!--begin::Advance Table Widget 3-->

                    <div class="col-lg-6">
                        <div class="card card-custom gutter-b ml-auto">
                            <!--begin::Header-->
                            <div class="card-header border-0 py-5">
                                <h3 class="card-title align-items-center">
                                                <span class="card-label font-weight-bolder text-dark">Shipping
                                                    Information</span>
                                </h3>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body pt-0 pb-3">
                                <!--begin::Table-->
                                <div class="table-responsive">
                                    <table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_3">
                                        <tr>
                                            <th class="font_weight">Name</th>
                                            <td class="float_end">{{ucfirst($orderItems->name)}}</td>
                                        </tr>
                                        <tr>
                                            <th class="font_weight">Country</th>
                                            <td class="float_end">{{ucfirst($orderItems->country)}}</td>
                                        </tr>
                                        <tr>
                                            <th class="font_weight">City</th>
                                            <td class="float_end">{{ucfirst($orderItems->city)}}</td>
                                        </tr>

                                        <tr>
                                            <th class="font_weight">Postal Code</th>
                                            <td class="float_end">{{$orderItems->zip_code}}</td>
                                        </tr>
                                        <tr>
                                            <th class="font_weight">Phone</th>
                                            <td class="float_end">{{$orderItems->phone}}</td>
                                        </tr>
                                        <tr>
                                            <th class="font_weight">Address</th>
                                            <td class="float_end">{{$orderItems->address}}</td>
                                        </tr>


                                    </table>
                                </div>
                                <!--end::Table-->

                            </div>
                            <!--end::Body-->
                        </div>
                    </div>
                    @if(Auth::user()->type=='developer' or Auth::user()->type=='super_admin')
                    <div class="col-lg-6">
                        <div class="card card-custom gutter-b ml-auto">
                            <!--begin::Header-->
                            <div class="card-header border-0 py-5">
                                <h3 class="card-title align-items-center">
                                                <span class="card-label font-weight-bolder text-dark">Price
                                                    Information</span>
                                </h3>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body pt-0 pb-3">
                                <!--begin::Table-->
                                <div class="table-responsive">
                                    <table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_3">
                                        <tr>
                                            <th class="font_weight">Paid Amount</th>
                                            <td class="float_end">{{$orderItems->paid_amount}}</td>
                                        </tr>
                                        <tr>
                                            <th class="font_weight">Total Amount</th>
                                            <td class="float_end">{{$orderItems->total_price}}</td>
                                        </tr>

                                    </table>
                                </div>
                                <!--end::Table-->

                            </div>
                            <!--end::Body-->
                        </div>
                    </div>
                    @endif
                </div>
                <!--end::Advance Table Widget 3-->
            </div>
            <!--end::Container-->

            <!--Start::View Modal-->
            <div class="modal fade" id="staticBackdrop1" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title product_form" id="exampleModalLabel"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body" id="append_product_inventory">
                            <!--begin::Table-->

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold" onclick="resetForm()" data-dismiss="modal">Cancel</button>
                            <button type="button" id="btn_assign_inventory" class="btn btn-primary font-weight-bold">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::View Modal-->
            <!--end::View Modal-->
        </div>
        <!--end::Entry-->
    </div>
    <!--end::Content-->
@endsection
@section('page_level_js')
    <script type="text/javascript">
        function assignProductInventory(ProductID)
        {
            var order_id=$('#order_id').val();
            var form_data = new FormData();
            form_data.append('orderID', order_id);
            form_data.append('ProductID', ProductID);
            $.ajax({
                type: "POST",
                url: "{{route('getAssignedProductInventory')}}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(datas) {
                    $('#staticBackdrop1').modal('show');
                    $('.product_form').text('Order (#'+order_id+')');
                    $('#append_product_inventory').html('');
                    $('#append_product_inventory').html(datas.inventoryassignedHtml);

                },
                error: function(errorString) {
                    Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                }
            });


        }

        function returnProductInventory(ProductID)
        {
            var order_id=$('#order_id').val();
            var form_data = new FormData();
            form_data.append('orderID', order_id);
            form_data.append('ProductID', ProductID);
            $.ajax({
                type: "POST",
                url: "{{route('getProductInventoryList')}}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(datas) {
                    console.log(datas);

                },
                error: function(errorString) {
                    Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                }
            });
        }

        var numbervar = 1;

        function addfield(id) {
            numbervar=numbervar+id;
            var html = '<div class=row id=row_' + numbervar + '>';
            html += '<div class=col-12>';
            html += '<div class="row">';
            html += '<div class="col-1">';
            html += '<button type="button" onclick="removeField(' + numbervar + ')" class="btn btn-primary">-</button>';
            html += '</div>';
            html += '<div class="form-group col-lg-2 col-5"><select class="form-control" onchange="getDeptItems(this.value,'+numbervar+')" name="department[]" id="department_'+ numbervar + '">';
            html += '<option value="">Department</option>';
            @foreach($departments as $department)
                html+='<option value="{{$department->id}}">{{ucfirst($department->name)}}</option>';
            @endforeach
            html += '</select>';
            html += '</select></div>';
            html += '<div class="form-group col-lg-2 col-5"><select class="form-control"  onchange="getItemVariant(this.value,'+numbervar+')"  name="item_id[]" id="item_id_'+ numbervar + '">';

            html += '<option value="">item</option>';
            html += '</select>';
            html += '</select></div>';
            html += '<div class="form-group col-lg-2 col-5"><select class="form-control" onchange="getVariantQty(this.value,'+numbervar+')" name="variant[]" id="variant_id_'+ numbervar + '">';

            html += '<option value="">Variant</option>';
            html += '</select>';
            html += '</select></div>';
            html += '<div class="form-group col-lg-2 col-5"><select class="form-control"   name="qty[]" id="qty_id_'+ numbervar + '">';

            html += '<option value="">Actual Qty</option>';
            html += '</select>';
            html += '</select><span class="text-danger" id="actual_qty_'+ numbervar + '"></span></div>';
            html += '<div class="row col-lg-3 col-10">';
            html += '<div class="col-3 inc_dec">';
            html += '<button type="button" class="btn btn-primary qty-plus" data-id="'+ numbervar +'">+</button>';
            html += '</div>';
            html += '<div class="form-group col-lg-5 col-6 inc_dec"><input type="text" readonly name="choose_qty[]" id="check_qty_'+ numbervar +'" class="form-control w_5 inc_dec col-12"></div>';
            html += '<div class="col-1 inc_dec">';
            html += '<button type="button" class="btn btn-primary qty-minus" data-id="'+ numbervar +'">-</button>';
            html += '</div>';
            html += '</div>';
            //html += '<div id="newfield_'+ numbervar + '" class="col-12"></div>';
            html += '</div>';
            $('#newfield').append(html);
            numbervar++;
        }

        function removeField(id) {
            $('#row_' + id).remove();
        }

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

                    $('#item_id_'+line).empty();
                    $('#item_id_'+line).append(new Option("Select Item", "")).trigger("updated");
                    $.each(datas, function (i, data) {
                        $('#item_id_'+line).append($('<option>', {
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
        function getItemVariant(itemID,line)
        {
            var order_id=$('#order_id').val();
            var product_id=$('#product_id').val();
            var depID=$('#department_'+line).val();
            var itemID=$('#item_id_'+line).val();
            var form_data = new FormData();
            form_data.append('depID', depID);
            form_data.append('itemID', itemID);
            form_data.append('orderID', order_id);
            form_data.append('productID', product_id);

            $.ajax({
                type: "POST",
                url: "{{route('getItemVariant')}}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(datas) {

                    $('#variant_id_'+line).empty();
                    $('#variant_id_'+line).append(new Option("Select Variant", "")).trigger("updated");
                    $.each(datas, function (i, data) {
                        // console.log(data.id);
                        $('#variant_id_'+line).append($('<option>', {
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

        function getVariantQty(variantID,line){
            var depID=$('#department_'+line).val();
            var itemID=$('#item_id_'+line).val();
            var form_data = new FormData();
            form_data.append('depID', depID);
            form_data.append('itemID', itemID);
            form_data.append('variantID', variantID);


            $.ajax({
                type: "POST",
                url: "{{route('getDeptItemsQty')}}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(datas) {

                    $('#qty_id_'+line).empty();
                    $('#qty_id_'+line).append(new Option("Select Quantity", " ")).trigger("updated");
                    $.each(datas, function (i, data) {
                       // console.log(data.id);
                        $('#qty_id_'+line).append($('<option>', {
                            value: data.id,
                            text : data.qty
                        })).trigger("updated");
                    });
                },
                error: function(errorString) {
                    Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                }
            });

        }

        $(document).on('click', '#btn_assign_inventory', function() {

            var order_id=$('#order_id').val();
            var form_data = $("#addForm").serializeArray();
            form_data.push({ name: "order_id", value: order_id });
                $.ajax({
                    type: "POST",
                    url: "{{route('orderSaleLogSubmit')}}", // your php file name
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

                        } else {
                            Swal.fire("Sorry!", data.message, "error");
                        }
                    },
                    error: function(errorString) {
                        Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                    }
                });

        });

        function resetForm()
        {
            document.getElementById("addForm").reset();
        }


        $(document).on('click', '.qty-plus', function() {
            var id = $(this).data('id');
            var availableQty=$('#qty_id_'+id).val();
            if(availableQty!=''){
                $('#actual_qty_'+id).text('');
                var totalQty=Math.floor($('#qty_id_'+id+' option:selected').text());
                var getval=$('#check_qty_'+id).val();
                if(getval==''){getval=0;}
                var put_total_qty=$('#check_qty_'+id).val();
                if(put_total_qty < totalQty){
                    var total=parseInt(getval) + parseInt(1);
                    $('#check_qty_'+id).val(total);
                }

            }
           else{
              $('#actual_qty_'+id).text('please choose actual quantity first');
            }

        });

        $(document).on('click', '.qty-minus', function() {
            var id = $(this).data('id');
            var getval=$('#check_qty_'+id).val();
            var total=parseInt(getval) - parseInt(1);
            if(total > 0 || total==0){
                $('#check_qty_'+id).val(total);
            }

        });

        $(document).on('click', '#proceed_inventory', function() {

            var order_id=$(this).data('id');
            var form_data = new FormData();
            form_data.append('order_id', order_id);



            $.ajax({
                type: "POST",
                url: "{{route('proceedSaleInventory')}}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
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

                        setTimeout(function(){
                            window.location.reload();
                        }, 5000);

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
