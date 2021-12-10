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
                                </tbody>

                            </table>
                            <div class="row footer_wrapper_html" style="display:none">
                              <div class="col-6"></div>
                                <div class="col-2 text-right">
                                    <input type="number" name="orde_total_price" class="form-control border" readonly name="totalPrice" id="order_total_price">
                                </div>
                                <div class="col-2  text-right">
                                    <input type="number" placeholder="Paid Amount" class="form-control border"    name="paid_price" id="order_paid_price">
                                </div>
                                <div class="col-2  text-right">
                                    <button type="button" class="btn btn-primary" id="save_order">Save</button>
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
                if (category != "" && product != "" && length != "") {
                    var i = 0;

                    $('#form_data tbody').append(
                        '<tr class="child"><td>' + count + '</td><td>' + category +
                        '<input type="hidden" name="category_id[]"  class="form-control" value="'+category_id+'"  ></td><td>'
                         + product + '<input type="hidden" name="product_id[]"  class="form-control" value="'+product_id+'"  ></td><td>'
                         + '<input type="number" name="order_qty[]" data-key="'+i+'"  class="form-control order_qty w-100" value="1" min="1" >' + '</td><td>'
                         + '<input type="text" readonly name="measurement[]"  class="form-control" value="'+parameters+'"  >' + '</td><td>' +
                            '<input type="text" readonly name="length[]"  class="form-control" value="'+length+'"  >' + '</td><td>' +
                                '<input type="text" readonly name="width[]"  class="form-control" value="'+width+'"  >' + '</td><td>' + '<input type="text" readonly name="fitting[]"  class="form-control" value="'+fitting+'"  >' + '</td><td>' + '<input type="text" readonly name="fitting_option[]"  class="form-control" value="'+set_fitting+'"  >' + '</td><td>' +
                                    '<input type="text" readonly name="side_control[]"  class="form-control" value="'+side_of_controls+'"  >' + '</td><td>' + '<input type="text" readonly name="chain_color[]"  class="form-control" value="'+chain_color+'"  >' + '</td><td>' +
                                        '<input type="text" readonly name="customer_note[]"  class="form-control" value="'+customer_note+'"  >' +
                        '</td><td>' +
                            '<input type="text" name="order_price[]"  class="form-control" id="price_'+i+'" value="'+price+'"  ><input type="hidden"  class="form-control" id="hidden_price_'+i+'" value="'+price+'"  >' +
                        '</td><td><a href="javascript:void(0);" class="remCF1"><i class="fas trash fa-trash"></i></a></td></tr>'
                    );
                    i++;
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
        });
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
                    alert('contact to admin');
                }
            });

        }


            $(document).on('keyup','.order_qty',function(){
                var qty_key = $(this).attr('data-key');
                var qty = $(this).val();
                var price  = $('#hidden_price_'+qty_key).val();
                totalPrice = qty * price;
                $('#price_'+qty_key).val(totalPrice);
                var paid_amount = 0;
                    $("input[name='order_price[]']").each(function() {
                       paid_amount += parseFloat($(this).val());
                    });
                    $('#order_total_price').val('');
                    $('#order_total_price').val(paid_amount);
            });

            $(document).on('keyup','#order_paid_price',function(){
                paid_price = $(this).val();
                console.log(paid_price);
            });

           $(document).on('click','#save_order',function(){
             var form_data = $("#addOrderForm").serializeArray();
             var booking_id = {{last(request()->segments())}};
             form_data.push({ name: "booking_id", value: booking_id })

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
                            var form = $("#addForm");
                            form[0].reset();
                            $('#addRoleModal').modal('hide');
                            table.ajax.reload();
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
