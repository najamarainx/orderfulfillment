@extends('layouts.app')
@section('title', 'Measurement Order')
@section('page_level_css_plugin')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page_level_css')
    <style>
        .error {
            color: red !important;
        }
        input[type='number'] {
    -moz-appearance:textfield;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
}
    </style>
@endsection
@section('content')
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">


            <!--begin::Advance Table Widget 2-->
            <div class="card card-custom gutter-b">
                <!--begin::Header-->
                <div class="card-header border-0 py-5">
                    <h3 class="card-title align-items-center">
                        <span class="card-label font-weight-bolder text-dark">Add Order</span>
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-0 pb-3">
                    <form id="addItem">
                        <div class="row ">
                            <div class="col-lg-6 col-md-6 col-sm-12 pr-lg-6 pr-md-6 border-right-lg border-right-md ">
                                <div class="row ">
                                    <div class="col-12 ">
                                        <div class="form-group mb-4 ">
                                            <label class="mb-0 ">Select Category</label>
                                            <select class="form-control form-control-lg  category_id kt_select2_1 w-100 "
                                                id="category_id" data-live-search="true" name="category_id">
                                                <option value="">Selet Category</option>
                                                @if (!$categories->isEmpty())
                                                    @foreach ($categories as $catObj)
                                                        <option value="{{ $catObj->id }}">{{ $catObj->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 ">
                                        <div class="form-group mb-4 ">
                                            <label class="mb-0 ">Select Product</label>
                                            <select
                                                class="form-control category_products form-control-lg kt_select2_1 w-100 "
                                                id="category_products" data-live-search="true" name="product_id">

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-4">
                                            <label class="mb-0">Select Parameters</label>
                                            <div class="alert alert-light">
                                                <div class="radio-inline d-flex justify-content-between" id="parameters">
                                                    <label class="radio">
                                                        <input type="radio" name="parameter" value="mm" />
                                                        <span></span>
                                                        mm
                                                    </label>
                                                    <label class="radio">
                                                        <input type="radio" name="parameter" value="cm" />
                                                        <span></span>
                                                        cm
                                                    </label>
                                                    <label class="radio">
                                                        <input type="radio" name="parameter" checked value="inch" />
                                                        <span></span>
                                                        inch
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 ">
                                        <div class="row ">
                                            <div class="col-6 ">
                                                <div class="form-group mb-4 ">
                                                    <label class="mb-0 ">Lenth</label>
                                                    <div class="input-group ">
                                                        <div class="input-group-prepend ">
                                                            <span class="input-group-text ">
                                                                <svg xmlns="http://www.w3.org/2000/svg "
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink "
                                                                    width="24px " height="24px " viewBox="0 0 24 24 "
                                                                    version="1.1 ">
                                                                    <g stroke="none " stroke-width="1 " fill="none "
                                                                        fill-rule="evenodd ">
                                                                        <polygon points="0 0 24 0 24 24 0 24 " />
                                                                        <rect fill="#000000 " opacity="0.3 "
                                                                            transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000) "
                                                                            x="7 " y="11 " width="10 " height="2 "
                                                                            rx="1 " />
                                                                        <path d="M6.70710678,8.70710678 C6.31658249,9.09763107 5.68341751,9.09763107 5.29289322,8.70710678 C4.90236893,8.31658249 4.90236893,7.68341751 5.29289322,7.29289322 L11.2928932,1.29289322 C11.6714722,0.914314282 12.2810586,0.90106866
                                            12.6757246,1.26284586 L18.6757246,6.76284586 C19.0828436,7.13603827 19.1103465,7.76860564 18.7371541,8.17572463 C18.3639617,8.58284362 17.7313944,8.61034655 17.3242754,8.23715414 L12.0300757,3.38413782 L6.70710678,8.70710678
                                            Z " fill="#000000 " fill-rule="nonzero " />
                                                                        <path d="M6.70710678,22.7071068 C6.31658249,23.0976311 5.68341751,23.0976311 5.29289322,22.7071068 C4.90236893,22.3165825 4.90236893,21.6834175 5.29289322,21.2928932 L11.2928932,15.2928932 C11.6714722,14.9143143 12.2810586,14.9010687
                                            12.6757246,15.2628459 L18.6757246,20.7628459 C19.0828436,21.1360383 19.1103465,21.7686056 18.7371541,22.1757246 C18.3639617,22.5828436 17.7313944,22.6103465 17.3242754,22.2371541 L12.0300757,17.3841378 L6.70710678,22.7071068
                                            Z " fill="#000000 " fill-rule="nonzero "
                                                                            transform="translate(12.000003, 18.999999) rotate(-180.000000) translate(-12.000003, -18.999999) " />
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                        <input type="number" name="length" class="form-control length"
                                                            id="length" placeholder="Lenth ">
                                                        <input type="hidden" id="length_placeholder">
                                                        <input type="hidden" id="width_placeholder">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 ">
                                                <div class="form-group mb-4 ">
                                                    <label class="mb-0 ">Width</label>
                                                    <div class="input-group ">
                                                        <div class="input-group-prepend ">
                                                            <span class="input-group-text ">
                                                                <svg xmlns="http://www.w3.org/2000/svg "
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink "
                                                                    width="24px " height="24px " viewBox="0 0 24 24 "
                                                                    version="1.1 ">
                                                                    <g stroke="none " stroke-width="1 " fill="none "
                                                                        fill-rule="evenodd ">
                                                                        <polygon points="0 0 24 0 24 24 0 24 " />
                                                                        <rect fill="#000000 " opacity="0.3 "
                                                                            transform="translate(12.000000, 12.000000) rotate(-360.000000) translate(-12.000000, -12.000000) "
                                                                            x="7 " y="11 " width="10 " height="2 "
                                                                            rx="1 " />
                                                                        <path d="M13.7071045,15.7071104 C13.3165802,16.0976347 12.6834152,16.0976347 12.2928909,15.7071104 C11.9023666,15.3165861 11.9023666,14.6834211 12.2928909,14.2928968 L18.2928909,8.29289682 C18.6714699,7.91431789 19.2810563,7.90107226
                                            19.6757223,8.26284946 L25.6757223,13.7628495 C26.0828413,14.1360419 26.1103443,14.7686092 25.7371519,15.1757282 C25.3639594,15.5828472 24.7313921,15.6103502 24.3242731,15.2371577 L19.0300735,10.3841414 L13.7071045,15.7071104
                                            Z " fill="#000000 " fill-rule="nonzero "
                                                                            transform="translate(19.000001, 12.000003) rotate(-270.000000) translate(-19.000001, -12.000003) " />
                                                                        <path d="M-0.292895505,15.7071104 C-0.683419796,16.0976347 -1.31658478,16.0976347 -1.70710907,15.7071104 C-2.09763336,15.3165861 -2.09763336,14.6834211 -1.70710907,14.2928968 L4.29289093,8.29289682 C4.67146987,7.91431789 5.28105631,7.90107226
                                            5.67572234,8.26284946 L11.6757223,13.7628495 C12.0828413,14.1360419 12.1103443,14.7686092 11.7371519,15.1757282 C11.3639594,15.5828472 10.7313921,15.6103502 10.3242731,15.2371577 L5.03007346,10.3841414 L-0.292895505,15.7071104
                                            Z " fill="#000000 " fill-rule="nonzero "
                                                                            transform="translate(5.000001, 12.000003) rotate(-450.000000) translate(-5.000001, -12.000003) " />
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                        <input type="number" name="width" class="form-control width"
                                                            id="width" placeholder="Width ">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-danger" id="width_measure_error"></p>
                                    <div class="col-12 ">
                                        <ul class="nav nav-pills d-flex justify-content-between " id="myTab2 "
                                            role="tablist ">
                                            <li class="nav-item w-100 ">
                                                <a class="btn btn-outline-primary w-100 " id="get-quotes-tab-1 "
                                                    data-toggle="tab " onclick="getPrice()">
                                                    <span class="nav-text ">Get Quotes</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <input type="hidden" name="order_item_id" id="order_item_id">
                                        <p class="text-danger mt-2 text-center" id="qoute_error"></p>
                                        <input type="hidden" name="order_price" id="order_price">
                                        <div class="mt-2 fade alert alert-success text-center active show"
                                            style="display:none" id="get-quotes" role="tabpanel"
                                            aria-labelledby="get-quotes-tab-1">
                                            <h3 class="font-weight-bolder d-block font-size-lg mt-3" id="home-3"
                                                role="tabpane3" aria-labelledby="home-tab-3">£<span
                                                    id="get_quote_price"></span></h3>
                                        </div>
                                        {{-- <div class="tab-content mt-5 " id="myTabContent1 ">
                                            <div class="tab-pane fade alert alert-success text-center " id="get-quotes "
                                                role="tabpanel " aria-labelledby="get-quotes-tab-1 ">
                                                <h3 class="font-weight-bolder d-block font-size-lg mt-3 " id="home-3 "
                                                    role="tabpane3 " aria-labelledby="home-tab-3 ">£<span id="get_quote_price"></span></h3>
                                            </div>
                                        </div> --}}
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 pl-lg-6 pl-md-6">
                                <div class="row">

                                    <div class="col-12">
                                        <label class="mb-0">Select Your fitting type</label>
                                        <div class="alert alert-light">

                                            <div class="radio-inline d-flex justify-content-between">
                                                <label class="radio">
                                                    <input type="radio" name="fitting" class="fitting_type" value="Recess"
                                                        checked />
                                                    <span></span>
                                                    Recess
                                                </label>
                                                <label class="radio">
                                                    <input type="radio" name="fitting" class="fitting_type"
                                                        value="Exact" />
                                                    <span></span>
                                                    Exact
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group mb-4">
                                            <label class="mb-0">Side of Controls</label>
                                            <select name="side_control" class="form-control" id="side_control">
                                                <option value="">Side of Controlls</option>
                                                <option value="left">Left</option>
                                                <option value="right">Right</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-4">
                                            <label class="mb-0">Chain Color</label>
                                            <select name="chain_color" class="form-control" id="chain_color">
                                                <option value="">Chain Color</option>
                                                <option value="white">White</option>
                                                <option value="black">Black</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="fitting_option" style="display: none">

                                            <div class="form-group mb-4">
                                                <label class="mb-0">Select your fitting option</label>
                                                <select name="set_fitting" class="form-control" id="set_fitting">
                                                    <option value="">Fitting Option</option>
                                                    <option value="bracket_to_bracket">Bracket to Bracket</option>
                                                    <option value="fabric_width">Fabric Width</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <div class="form-group mb-4">
                                            <label class="mb-0">Customer Note</label>
                                            <textarea type="text" class="form-control" placeholder="Customer Note"
                                                id="customer_note"></textarea>
                                        </div>
                                    </div>


                                </div>
                            </div>

                        </div>
                    </form>
                    <div class="text-right ">
                        <button class="btn btn-primary font-weight-bold " type="button" id="save">Save</button>
                    </div>
                    <!--begin::Table-->
                    <h3 class="card-title align-items-center pt-7 ">
                        <span class="card-label font-weight-bolder text-dark ">Order Detail</span>
                    </h3>
                    <div class="table-responsive mb-20">
                        <form id="addOrderForm">
                            <input type="hidden" name="order_id" id="order_id"
                                value="{{ !empty($orderDetail->id) ? $orderDetail->id : '' }}">
                            <table class="table table-head-custom table-vertical-center" id="form_data">
                                <thead>
                                    <tr class="w3-blue">
                                        <th nowrap>Sr#</th>
                                        <th nowrap>Category</th>
                                        <th nowrap>Product</th>
                                        <th nowrap style="min-width: 75px">Qty</th>
                                        <th nowrap>Parameters</th>
                                        <th nowrap>Length</th>
                                        <th nowrap>Width</th>
                                        <th nowrap>Fitting</th>
                                        <th nowrap>Fitting Option</th>
                                        <th nowrap>Side of Controls</th>
                                        <th nowrap>Side of Controls</th>
                                        <th nowrap>Note</th>
                                        <th nowrap style="min-width: 75px">Price</th>
                                        <th nowrap>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($orderDetail))
                                        @foreach ($orderDetail->orderdetail as $i => $orderObj)
                                            @php $measurement = explode("x",$orderObj->dimension)  @endphp
                                            <tr class="child" id="order_item_row_wrapper_{{ $orderObj->id }}">
                                                <td>
                                                    {{ $i + 1 }}
                                                </td>
                                                <td>
                                                    {{ $orderObj->orderCategory->name }}
                                                    <input type="hidden" name="category_id[]" class="form-control cat_id"
                                                        value="{{ $orderObj->orderCategory->id }}">
                                                </td>
                                                <td>{{ $orderObj->orderProducts->name }}
                                                    <input type="hidden" name="product_id[]" class="form-control pro_id"
                                                        value="{{ $orderObj->orderProducts->id }}">
                                                </td>
                                                <td>
                                                    <input type="number" name="order_qty[]" data-key="{{ $i }}"
                                                        class="form-control order_qty w-100" value="{{ $orderObj->qty }}"
                                                        min="1">
                                                </td>
                                                <td>
                                                    <input type="text" readonly name="measurement[]"
                                                        class="form-control measurement" value="{{ $orderObj->scale }}">
                                                </td>
                                                <td>
                                                    <input type="text" readonly name="length[]" class="form-control length"
                                                        value="{{ $measurement[0] }}">
                                                </td>
                                                <td>
                                                    <input type="text" readonly name="width[]" class="form-control width"
                                                        value="{{ $measurement[1] }}">
                                                </td>
                                                <td>
                                                    <input type="text" readonly name="fitting[]"
                                                        class="form-control fitting"
                                                        value="{{ $orderObj->fitting_type }}">
                                                </td>
                                                <td>
                                                    <input type="text" readonly name="fitting_option[]"
                                                        class="form-control fitting_option"
                                                        value="{{ $orderObj->fitting_option }}">
                                                </td>
                                                <td>
                                                    <input type="text" readonly name="side_control[]"
                                                        class="form-control side_control"
                                                        value="{{ $orderObj->side_control }}">
                                                </td>
                                                <td>
                                                    <input type="text" readonly name="chain_color[]"
                                                        class="form-control chain_color"
                                                        value="{{ $orderObj->chain_color }}">
                                                </td>
                                                <td>
                                                    <input type="text" readonly name="customer_note[]"
                                                        class="form-control" value="">
                                                </td>
                                                <td>
                                                    <input type="text" name="order_price[]"
                                                        class="form-control single_price" id="price_{{ $i }}"
                                                        value="{{ $orderObj->price }}"><input type="hidden"
                                                        class="form-control single_hidden_price"
                                                        id="hidden_price_{{ $i }}"
                                                        value="{{ $orderObj->price }}">
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0);" class="remCF1"><i
                                                            class="fas trash fa-trash"></i></a>
                                                    <a href="javascript:;"
                                                        class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3 edit"
                                                        data-id="{{ $orderObj->id }}">
                                                        <span class="svg-icon svg-icon-md svg-icon-primary">
                                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Write.svg-->
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                                    <path
                                                                        d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z"
                                                                        fill="#000000" fill-rule="nonzero"
                                                                        transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)">
                                                                    </path>
                                                                    <path
                                                                        d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z"
                                                                        fill="#000000" fill-rule="nonzero" opacity="0.3">
                                                                    </path>
                                                                </g>
                                                            </svg>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>

                            </table>
                            <p class="text-danger payment_error"></p>
                            <div class="row footer_wrapper_html"
                                style=" {{ !empty($orderDetail) }} ? 'display:block' : 'display:none'">
                                <div class="col-5"></div>
                                <div class="col-2 ">
                                    <label for="">Total Price</label>
                                    <div class="form-goup text-right">
                                        <input type="number" name="order_total_price" class="form-control border" readonly
                                            name="totalPrice" id="order_total_price"
                                            value="{{ !empty($orderDetail->total_price) ? $orderDetail->total_price : '' }}">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <label for="">Paid Amount</label>
                                    <div class="form-group text-right">
                                        <input type="number" placeholder="Paid Amount" class="form-control border"
                                            name="paid_price" id="order_paid_price"
                                            value="{{ !empty($orderDetail->paid_amount) ? $orderDetail->paid_amount : '' }}">
                                    </div>
                                </div>
                                <div class="col-3  text-right mt-4">
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-primary" data-id="1" id="save_order">Save and
                                            proceed</button>
                                        <button type="button" class="btn btn-primary" data-id="0"
                                            id="save_order">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!--end::Table-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Advance Table Widget 2-->



        </div>
        <!--end::Container-->
    </div>
@endsection
@section('page_level_js_plugin')
    <script src="{{ asset('assets/plugins/custom/jqvalidation/jquery.validate.min.js?v=7.0.4') }}"></script>
@endsection
@section('page_level_js')
    <script type="text/javascript">
        jQuery(document).ready(function() {
            var validator = $("#addItem").validate({
                rules: {
                    category_id: {
                        required: true
                    },
                    product_id: {
                        required: true
                    },
                    length: {
                        required: true
                    },
                    width: {
                        required: true
                    },
                    side_control: {
                        required: true
                    },
                    chain_color: {
                        required: true
                    },

                },
                errorPlacement: function(error, element) {
                    var elem = $(element);
                    if (elem.hasClass("category_id") || elem.hasClass("category_products")) {

                        error.appendTo(element.parent().after());
                        //error.insertAfter(element);
                    } else if (elem.hasClass("length") || elem.hasClass("width")) {
                        error.appendTo(element.parent().parent().after());

                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            var input = document.getElementById("addItem");
            input.addEventListener("keyup", function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    document.getElementById("btn_save").click();
                }
            });

        })

        $('#save').on('click', function() {
            var validate = $('#addItem').valid();

            if ($('#order_price').val() == '') {
                $('#qoute_error').text('Please get qoute first');
                validate = false;
                // $( "#order_price" ).rules( "add", {
                //     });
                //    }
            }
            if (validate) {

                var category = $('#category_id option:selected').text();
                var category_id = $('#category_id').val();
                var product_id = $('#category_products').val();
                var product = $('#category_products option:selected').text();
                var parameters = $('input[name="parameter"]:checked').val();
                var fitting = $('input[name="fitting"]:checked').val();
                var length = $('#length').val();
                var width = $('#width').val();

                // var fitting_type = $('#fitting_type').val();
                var side_of_controls = $('#side_control').val();
                price = $('#order_price').val();

                var chain_color = $('#chain_color').val();

                var set_fitting = $('#set_fitting').val();
                var customer_note = $('#customer_note').val();
                var count = $('#form_data tr').length;
                var order_item_id = $('#order_item_id').val();
                var rowCount = $('#form_data tbody .child').length;
                if (order_item_id != '') {
                    $('#order_item_row_wrapper_' + order_item_id).remove();
                }
                if (category != "" && product != "" && length != "") {
                    var i = 0;
                    var ca_id = $('#form_data tbody .child').find('.cat_id').val();
                    var pro_id = $('#form_data tbody .child').find('.pro_id').val();
                    var measurement = $('#form_data tbody .child').find('.measurement').val();
                    console.log(measurement);
                    //    var  measurement =  $('#form_data tbody .child').find('.measurement').val();
                    var pre_length = $('#form_data tbody .child').find('.length').val();
                    var pre_width = $('#form_data tbody .child').find('.width').val();
                    var pre_fitting = $('#form_data tbody .child').find('.fitting').val();
                    var pre_fitting_option = $('#form_data tbody .child').find('.fitting_option').val();
                    var pre_side_control = $('#form_data tbody .child').find('.side_control').val();
                    var pre_chain_color = $('#form_data tbody .child').find('.chain_color').val();
                    if (((ca_id) && cat_id == category_id) && ((pro_id) && pro_id == product_id) && ((
                            measurement) && measurement == parameters) && ((pre_length) && pre_length == length) &&
                        ((pre_width) && pre_width == width) && ((pre_fitting) && pre_fitting == fitting) && ((
                            pre_side_control) && pre_side_control == side_of_controls) && ((pre_chain_color) &&
                            pre_chain_color == chain_color)) {
                        var qty = $('#form_data tbody .child').find('.order_qty').val();
                        var price = $('#form_data tbody .child').find('.single_price').val();
                        total_qty = parseInt(qty) + parseInt(1);
                        total_price = total_qty * price;
                        $('#form_data tbody .child').find('.order_qty').val(total_qty);
                        $('#form_data tbody .child').find('.single_price').val(total_price);
                        $('#form_data tbody .child').find('.single_hidden_price').val(total_price);

                    } else {
                            row =   rowCount + 1;
                        $('#form_data tbody').append(
                            ' <tr class="child" ><td>' + count + '</td><td>' + category +
                            '<input type="hidden" name="category_id[]"  class="form-control cat_id" value="' +
                            category_id + '"  ></td><td>' +
                            product +
                            '<input type="hidden" name="product_id[]"  class="form-control pro_id" value="' +
                            product_id + '"  ></td><td>' +
                            '<input type="number" name="order_qty[]" data-key="' +row  +
                            '"  class="form-control order_qty w-100" value="1" min="1" >' + '</td><td>' +
                            '<input type="text" readonly name="measurement[]"  class="form-control measurement" value="' +
                            parameters + '"  >' + '</td><td>' +
                            '<input type="text" readonly name="length[]"  class="form-control length" value="' +
                            length +
                            '"  >' + '</td><td>' +
                            '<input type="text" readonly name="width[]"  class="form-control width" value="' +
                            width +
                            '"  >' + '</td><td>' +
                            '<input type="text" readonly name="fitting[]"  class="form-control fitting" value="' +
                            fitting +
                            '"  >' + '</td><td>' +
                            '<input type="text" readonly name="fitting_option[]"  class="form-control fitting_option" value="' +
                            set_fitting + '"  >' + '</td><td>' +
                            '<input type="text" readonly name="side_control[]"  class="form-control side_control" value="' +
                            side_of_controls + '"  >' + '</td><td>' +
                            '<input type="text" readonly name="chain_color[]"  class="form-control chain_color" value="' +
                            chain_color + '"  >' + '</td><td>' +
                            '<input type="text" readonly name="customer_note[]"  class="form-control" value="' +
                            customer_note + '"  >' +
                            '</td><td>' +
                            '<input type="text" name="order_price[]"  class="form-control single_price" id="price_' +
                            row +
                            '" value="' + price +
                            '"  ><input type="hidden"  class="form-control single_hidden_price" id="hidden_price_' +
                            row + '" value="' +
                            price + '"  >' +
                            '</td><td><a href="javascript:void(0);" class="remCF1"><i class="fas trash fa-trash"></i></a></td></tr>'
                        );

                    }
                }
                var paid_amount = 0;
                $("input[name='order_price[]']").each(function() {
                    paid_amount += parseFloat($(this).val());
                });
                $('#order_total_price').val('');
                $('#order_total_price').val(paid_amount);
                console.log(paid_amount);
                $('.footer_wrapper_html').show()
                var form = $("#addItem");
                form[0].reset();
                $('#category_id').val('').trigger('change.select2');
                $('#category_products').val('').trigger('change.select2');
                $('#order_price').val();
                $('#order_price').val();
                $('#get-quotes').hide();
            }
        });
        $(document).on('click', '.remCF1', function() {
            $(this).parent().parent().remove();
            $('#myTable tbody tr').each(function(i) {
                $($(this).find('td')[0]).html(i + 1);
            });
        });
        $(document).on('change', '#category_id', function() {
            cat_id = $(this).val();
            getProductCategory(cat_id);
        });

        function getProductCategory(cat_id) {
            var form_data = new FormData();
            form_data.append('id', cat_id);
            $.ajax({
                type: "POST",
                url: "{{ route('getProductByCategory') }}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status == 'success') {
                        if (data.products != '') {
                            $('#category_products').html('');
                            var product_options_html = '<option value="">Select a product</option>';
                            $.each(data.products, function(key, item) {
                                product_options_html +=
                                    `<option value="${item.id}">${item.name}</option>`;
                            });
                            $('#category_products').html(product_options_html);

                        }
                    } else {
                        Swal.fire("Sorry!", data.message, "error");
                    }
                },
                error: function(errorString) {
                    Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                }
            });
        }
        $(document).on('click', '.fitting_type', function() {
            fitting_type = $(this).val();
            if (fitting_type == 'Exact') {
                $('.fitting_option').show();
                $("#set_fitting").rules("add", {
                    required: true,
                });
            } else {
                $('.fitting_option').hide();
                $("#set_fitting").rules("add", {
                    required: false,
                });
            }
        });
        $(document).on('change', '#category_products', function() {
            product_id = $(this).val();
            var form_data = new FormData();
            form_data.append('id', product_id);
            $.ajax({
                type: "POST",
                url: "{{ route('getProductMinPrices') }}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status == 'success') {
                        if (data.price != '') {
                            //   $('#length').val('');
                            //   $('#width').val('');
                            $('#length').attr('placeholder', "min " + data.price.min_order_length);
                            $('#width').attr('placeholder', "min " + data.price.min_order_width);
                            $('#length_placeholder').val(data.price.min_order_length);
                            $('#width_placeholder').val(data.price.min_order_width);
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

        $("input[name='parameter']").change(function() {
            var min_width = $('#length_placeholder').val();
            var min_height = $('#width_placeholder').val();
            var measure = $('input[name="parameter"]:checked').val();
            $('#length').val('');
            $('#width').val('');
            $('#get_quote_price').text('');
            $('#total_price').val('');
            if (measure == 'inch') {
                $("#length").attr("placeholder", " ");
                $("#width").attr("placeholder", " ");
                $("#length").attr("placeholder", "min " + min_width);
                $("#width").attr("placeholder", "min " + min_height);

            } else if (measure == 'cm') {
                $("#length").attr("placeholder", " ");
                $("#width").attr("placeholder", " ");
                var cmwidth = min_width * 2.54;
                var cmheight = min_height * 2.54;
                cmwidth = cmwidth.toFixed(2);
                cmheight = cmheight.toFixed(2);
                $("#length").attr("placeholder", "min " + cmwidth);
                $("#width").attr("placeholder", "min " + cmheight);


            } else {
                $("#length").attr("placeholder", " ");
                $("#width").attr("placeholder", " ");

                var mmwidth = min_width * 25.4;
                var mmheight = min_height * 25.4;
                mmwidth = mmwidth.toFixed(2);
                mmheight = mmheight.toFixed(2);
                $("#length").attr("placeholder", "min " + mmwidth);
                $("#width").attr("placeholder", "min " + mmheight);

            }

        });

        function getPrice() {


            if ($('#width').val() == '') {

                $('#width_measure_error').html('Please do not leave the width input field empty');
                return false;


            }
            if ($('#length').val() == '') {
                $('#height_measure_error').html('Please do not leave the height input field empty');
                return false;
            }
            $('#qoute_error').text('');
            pageproductID = $('#category_products option:selected').val();
            var form_data = new FormData();
            var surl = "{{ route('store.produt.quote') }}" + '/' + pageproductID; // your php file name
            length = $('#length').val();
            width = $('#width').val();
            min_length = $('#length_placeholder').val();
            min_width = $('#width_placeholder').val();
            measure = $('input[name="parameter"]:checked').val();

            form_data.append('measure', measure)
            form_data.append('length', length)
            form_data.append('width', width)
            form_data.append('min_length', min_length)
            form_data.append('min_width', min_width)

            $.ajax({
                type: "POST",
                url: surl, // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status == 'success') {
                        $('#width_measure_error').html('');
                        $('.width_measure_error').html('');
                        $('#height_measure_error').html('');
                        $('.height_measure_error').html('');

                        $('#get-quotes').show();
                        $('#get_quote_price').text('');
                        $('#get_quote_price').text(data.price);
                        $('#order_price').val(data.price);





                    } else {

                        $('#width_measure').val('');
                        $('#height_measure').val('');
                        $('#get-quotes').show();
                        $('#get_quote_price').text('');
                        $('#get_quote_price').text(data.message);
                        $('#order_price').val(data.price);



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
                        toastr.warning(data.message);

                    }
                },
                error: function(errorString) {
                    Swal.fire("Sorry!", "Please Select Product first", "error");
                }
            });

        }


        $(document).on('keyup', '.order_qty', function() {
            var qty_key = $(this).attr('data-key');
            var qty = $(this).val();
            var price = $('#hidden_price_' + qty_key).val();
            console.log(price);
            totalPrice = qty * price;
            $('#price_' + qty_key).val(totalPrice);
            var paid_amount = 0;
            $("input[name='order_price[]']").each(function() {
                paid_amount += parseFloat($(this).val());
            });
            $('#order_total_price').val('');
            $('#order_total_price').val(paid_amount);
        });

        $(document).on('keyup', '#order_paid_price', function() {
            paid_price = $(this).val();
            console.log(paid_price);
        });

        $(document).on('click', '#save_order', function() {
            var verified_id = $(this).attr('data-id');
            var totalPrice = $('#order_total_price').val();
            var paidPrice = $('#order_paid_price').val();
            // console.log(paidPrice);
            if (paidPrice == '') {
                $('.payment_error').text('');
                $('.payment_error').text('Please add paid amount');
                return;
            }
            if (paidPrice > totalPrice) {
                $('.payment_error').text('');
                $('.payment_error').text('Please add paid amount less than total amount');
                return;
            }
            $('.payment_error').text('');

            var form_data = $("#addOrderForm").serializeArray();
            var booking_id = {{ last(request()->segments()) }};
            form_data.push({
                name: "booking_id",
                value: booking_id
            });
            form_data.push({
                name: "verified_id",
                value: verified_id
            })

            $.ajax({
                type: "POST",
                url: "{{ route('storeMeasurementOrder') }}", // your php file name
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
                        if (data.verified_id == 1) {
                            window.location = "{{ route('bookingTaskList') }}";
                        } else {
                            location.reload();
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

        $(document).on('click', '.edit', function() {
            var id = $(this).data('id');
            var form_data = new FormData();
            form_data.append('id', id);
            $.ajax({
                type: "POST",
                url: "{{ route('getOrderItemById') }}", // your php file name
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
                        var category_id = rec.category_id;
                        getProductCategory(category_id);
                        var product_id = rec.product_id;
                        var scale = rec.scale;
                        var dimension = rec.dimension;
                        dimension = dimension.split('x');
                        // console.log(dimension);
                        // var dimension = rec.dimension;
                        var fitting = rec.fitting_type;
                        var side_control = rec.side_control;
                        var chain_color = rec.chain_color;
                        var fitting_option = rec.fitting_option;
                        var qty = rec.qty;
                        var price = rec.price;
                        var id = rec.id;
                        $('#category_id').val(category_id).trigger('change.select2');
                        setTimeout(function() {
                            $('.category_products').val(product_id).trigger('change.select2');
                        }, 1000);
                        $("input[name=parameter][value='" + scale + "']").prop("checked",
                            true);
                        $("input[name=fitting][value='" + fitting + "']").prop("checked",
                            true);
                        $('#side_control').val(side_control).trigger('change.select2');
                        $('#chain_color').val(chain_color).trigger('change.select2');
                        $('#length').val(dimension[0]);
                        $('#width').val(dimension[1]);
                        $('#get_quote_price').text(price);
                        $('#get-quotes').show();
                        $('#order_item_id').val(id);
                        $('#order_price').val(price);
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
    </script>
@endsection
