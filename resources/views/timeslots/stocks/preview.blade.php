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
    <div class="card card-custom">
        <div class="card-body p-0">
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
                                            <span>Transaction Id</span>
                                            @php $month = date('m');
                                                $transactionId = $month . str_pad($orderItems->id, STR_PAD_RIGHT);
                                            @endphp
                                        </span>
                                        <span class="font-weight-boldest display-4">#{{ $transactionId }}</span>
                                        <span>Date: {{date('M d y',strtotime($orderItems->created_at))}}</span>
                                    </div>
                                </div>
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
            <div class="position-relative">
                <div class="bgi-size-cover bg-primary bgi-position-center bgi-no-repeat h-65px"></div>
                <div class="bg-white h-65px"></div>
                <div class="bg-light h-65px"></div>
                <div class="bg-white h-65px"></div>
                <div class="bg-light h-65px"></div>
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
            </div>
            <div class="container">
                <div class="row justify-content-center py-8 px-8 py-md-28 px-md-0">
                    <div class="col-md-9">
                        <div class="d-flex font-size-sm flex-wrap">
                            <button type="button" class="btn btn-primary font-weight-bolder py-4 mr-3 mr-sm-14 my-1 px-7"
                                onclick="window.print();">Print Invoice</button>
                            <button type="button" class="btn btn-light-danger font-weight-bolder mr-3 ml-sm-auto my-1 px-7"
                                onclick="window.print();">Download</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
