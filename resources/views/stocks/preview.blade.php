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
        /* @media only print {
            #print-content{
                font-size: 130px !important;
                font-family: georgia, times, serif;
                font-style: italic !important;
                font-weight: 500;
                color: red;
            }
        } */

    </style>
@endsection
@section('content')
    <div id="content2" class="card card-custom">
        <div id="print-content" class="card-body p-0">
            <!--begin::Invoice-->
            <!--begin::Invoice header-->
            <div class="container">
                <div class="card card-custom card-shadowless">
                    <div class="card-body p-0">
                        <div class="row justify-content-center py-8 px-8 py-md-27 px-md-0">

                            <div class="col-md-9">
                                <div class="d-flex justify-content-between pb-5 pb-md-5 flex-column flex-md-row">
                                    <div class="form-group row">
                                        <h3 class="display-3 text-primary font-weight-boldest mb-4">
                                            {{ ucfirst($orderItems->supplierDetail->name) }}</h3>
                                    </div>
                                    <div class="d-flex flex-column align-items-md-end px-0">
                                        <span
                                            class="display-4 text-dark font-weight-bold mb-4 text-dark d-flex flex-column align-items-md-end opacity-70">
                                            <span class="w-100 text-right">Transaction Id</span>
                                            @php $month = date('m');
                                                $transactionId = $month . str_pad($orderItems->id, STR_PAD_RIGHT);
                                            @endphp
                                        </span>
                                        <span class="w-100 text-right font-weight-boldest display-4">#{{ $transactionId }}</span>
                                        <span class="w-100 text-right">Date: {{date('d M y',strtotime($orderItems->created_at))}}</span>
                                    </div>
                                </div>
                                <!-- <div class="border-bottom w-100 opacity-100"></div> -->
                                <hr class="w-100">
                                <div class="d-flex justify-content-between text-dark pt-6">
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolde mb-2r">Supplier Phone No</span>
                                        <span class="opacity-70">{{$orderItems->supplierDetail->phone}}</span>
                                    </div>
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolde mb-2r">Company Phone No</span>
                                        <span class="opacity-70">{{$orderItems->supplierDetail->phone}}</span>
                                    </div>
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolder mb-2">Supplier Company Addressl</span>
                                        <span class="opacity-70">{{$orderItems->supplierDetail->address}}</span>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <!--end::Invoice header-->
            <!--begin::Invoice Body-->
            <div class="position-relative">
                <!--begin::Background Rows-->
                <div class="bgi-size-cover bg-primary bgi-position-center bgi-no-repeat h-65px"></div>
                <div class="bg-white h-65px"></div>
                <div class="bg-light h-65px"></div>
                <div class="bg-white h-65px"></div>
                <div class="bg-light h-65px"></div>
                <!--end::Background Rows-->
                <!--begin:Table-->
                <div class="container position-absolute top-0 left-0 right-0">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>

                                        <tr class="font-weight-boldest text-white h-65px">
                                            <td class="align-middle font-size-h5 pl-0 border-0">Item ID</td>
                                            <td class="align-middle font-size-h5 pl-0 border-0">Item Name</td>
                                            <td class="align-middle font-size-h5 pl-0 border-0">Unit</td>
                                            <td class="align-middle font-size-h5 pl-0 border-0">Item Variant</td>
                                            <td class="align-middle font-size-h5 pl-0 border-0">Item Quantity</td>
                                            <td class="align-middle font-size-h5 pl-0 border-0">Item Price</td>
                                            <td class="align-middle font-size-h5 text-right border-0">total Price Item</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!($orderItems->stockOrderDetail->isEmpty()))
                                        @php $totalItem = 0; @endphp
                                        @foreach ($orderItems->stockOrderDetail as $orderItemObj)
                                        @php $totalItem += $orderItemObj->total_price; @endphp
                                        <tr class="font-size-lg font-weight-bolder h-65px">
                                            <td class="align-middle font-size-h6 font-weight-normal pl-0 border-0">{{$orderItemObj->id}}</td>
                                            <td class="align-middle font-size-h6 font-weight-normal pl-0 border-0">{{!empty($orderItemObj->orderItem->name) ? $orderItemObj->orderItem->name : ''}}</td>
                                            <td class="align-middle font-size-h6 font-weight-normal pl-0 border-0">{{!empty($orderItemObj->orderItem->unit) ? $orderItemObj->orderItem->unit : ''}}</td>
                                            <td class="align-middle font-size-h6 font-weight-normal pl-0 border-0">{{!empty($orderItemObj->orderVariant->name) ? $orderItemObj->orderVariant->name : ''}}</td>
                                            <td class="align-middle font-size-h6 font-weight-normal pl-0 border-0">{{$orderItemObj->qty}}</td>
                                            <td class="align-middle font-size-h6 font-weight-normal pl-0 border-0">£{{$orderItemObj->per_unit_price}}
                                            </td>
                                            <td class="align-middle font-size-h6 font-weight-normal text-right border-0">
                                                £{{$orderItemObj->total_price}}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end:Table-->
                <!--begin::Total-->
                <div class="container">
                    <div class="row justify-content-center pt-25 pb-20">
                        <div class="col-md-9">
                            <div
                                class="rounded d-flex align-items-center justify-content-between text-white max-w-425px position-relative ml-auto px-7 py-5 bgi-no-repeat bgi-size-cover bgi-position-center bg-primary">
                                <div class="font-weight-boldest font-size-h5">TOTAL AMOUNT</div>
                                <div class="text-right d-flex flex-column">
                                    <span class="font-weight-boldest font-size-h3 line-height-sm">£{{$totalItem}}</span>
                                    <span class="font-size-sm">Taxes included</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Total-->
            </div>
            <!--end::Invoice Body-->
            <!--begin::Invoice Footer-->

            <!--end::Invoice Footer-->

            <!--end::Invoice-->
        </div>
    </div>
    <!-- begin: Invoice action-->
    <div class="container">
        <div class="row justify-content-center py-2 px-4 py-md-2 px-md-0">
            <div class="col-md-9">
                {{-- onclick="window.print();" --}}
                <div class="d-flex font-size-sm flex-wrap">
                    <button type="button" class="btn btn-primary font-weight-bolder py-4 mr-3 mr-sm-14 my-1 px-7" onclick="printDiv('print-content')">Print Invoice</button>
                    <button type="button" class="btn btn-light-danger font-weight-bolder mr-3 ml-sm-auto my-1 px-7" id="downloadPDF">Download</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end: Invoice action-->
@endsection

@section('page_level_js_plugin')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script> --}}

    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
@endsection
@section('page_level_js')

    <script>
        $('#downloadPDF').click(function () {
            domtoimage.toPng(document.getElementById('content2'))
                .then(function (blob) {
                    var pdf = new jsPDF('l', 'pt', [$('#content2').width(), $('#content2').height()]);

                    pdf.addImage(blob, 'PNG', 0, 0, $('#content2').width(), $('#content2').height());
                    pdf.save("stock-invoice.pdf");

                    that.options.api.optionsChanged();
                });
        });
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();
            console.log(originalContents);
            document.body.innerHTML = originalContents;
        }
    </script>

@endsection

