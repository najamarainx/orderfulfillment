@extends('layouts.app')
@section('title', 'Users Time Slot')

@section('page_level_css_plugin')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page_level_css')
    <style>
        .error {
            color: red !important;
        }
        .slot_checkbox input.checkbox:empty {
            display: none;
        }

        .slot_checkbox input.checkbox:empty~label {
            position: relative;
            float: left;
            line-height: 2.5em;
            text-indent: 3.25em;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            width: 100%;
            border: 1px solid #B21F24;
            background-color: #B21F24;
            color: #fff;
        }

        .slot_checkbox input.checkbox:empty~label:before {
            position: absolute;
            display: block;
            top: 0;
            bottom: 0;
            left: 0;
            content: '';
            width: 2.5em;
            background: #B21F24;
            border-radius: 3px 0 0 3px;
        }

        .slot_checkbox input.checkbox:hover:not(:checked)~label:before {
           text-indent: .9em;
            color: #C2C2C2;
        }

        .slot_checkbox input.checkbox:hover:not(:checked)~label {
            color: #C2C2C2;
        }

        .slot_checkbox input.checkbox:checked~label:before {
            content: '\2714';
            text-indent: .9em;
            color: #9CE2AE;
            background-color: #B21F24;
        }

        .slot_checkbox input.checkbox:checked~label {
            color: #fff;
            background-color: #B21F24;
        }

        .slot_checkbox input.checkbox:focus~label:before {
            box-shadow: 0 0 0 3px #999;
        }

        .disabled input.checkbox:empty~label,
        .disabled input.checkbox:empty~label:before {
            background-color: lightgray !important;
        }

        .disabled input.checkbox:hover:not(:checked)~label:before {
            content: '';
            text-indent: .9em;
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
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Listing</h5>
                    <!--end::Page Title-->
                    <!--begin::Actions-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                    <span class="text-muted font-weight-bold mr-4">Users Zip Slot</span>
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
                <div class="card card-custom gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0 py-5">
                        <h3 class="card-title align-items-center">
                            <span class="card-label font-weight-bolder text-dark">Users Zip Slot</span>
                        </h3>
                        <div class="card-toolbar">

                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-0 pb-3">
                        <form class="kt-form kt-form--fit" id="addForm">
                            <input type="hidden" name="id" id="id" value="{{$zip_id}}">
                            @foreach($slots as $key=>$slot)
                                @php
                                    $userselected=array();
                                    if(!empty($slot->slot_users)){
                                    foreach($slot->slot_users as $userCehck){
                                        $userselected[]=$userCehck->user_id;
                                    }

                                    }

                                @endphp
                            <div class="row col-8 m-auto d-flex justify-content-between">
                                <div class="slot_checkbox col-4">
                                    <input type="checkbox" name="time_slot[{{$key}}]" id="time_slot_{{$slot->id}}" onclick="showUsers({{$slot->id}})" class="checkbox time_slot" value="{{$slot->id}}" @if(!empty($userselected)) {{'checked'}} @endif >
                                    <label for="time_slot_{{$slot->id}}">{{ date('g:i a',strtotime($slot->booking_from_time)).' - '.date('g:i a',strtotime($slot->booking_to_time)) }}</label>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <select class="form-control select2 kt_select2_3 " id="slot_user_{{$slot->id}}" multiple="multiple" @if(empty($userselected)) {{'disabled'}} @endif  name="user_zip[{{$key}}][]">
                                            @foreach($usersBYZipCode as $user)
                                                <option value="{{$user->id}}" @if(!empty($userselected) && in_array($user->id,$userselected)) {{'selected'}} @endif>{{ucfirst($user->name)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="text-danger zip_error"></span>
                                </div>
                            </div>
                            @endforeach
                        </form>
                        <!--end::Table-->

                    </div>
                    <!--end::Body-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary font-weight-bold" id="btn_save">Save</button>
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
    <!--end::Content-->
@endsection
@section('page_level_js_plugin')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.4') }}"></script>
    <script src="{{ asset('assets/plugins/custom/jqvalidation/jquery.validate.min.js?v=7.0.4') }}"></script>
@endsection
@section('page_level_js')
    <script type="text/javascript">

        jQuery(document).ready(function() {
           var validator = $("#addForm").validate({
                ignore: ":hidden:not(.selectpicker)",
                rules: {

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

            $(document).on('click', '#btn_add_new', function(){
                $('#staticBackdrop').modal({
                    backdrop: 'static',
                    keyboard: false
                }).on('hide.bs.modal', function(){
                    $("#addForm").validate().resetForm();
                });
                var form = $("#addForm");
                form[0].reset();
            });


            $(document).on('click', '#btn_save', function(){
                var validate = $("#addForm").valid();
                if(validate) {
                    var form_data = $("#addForm").serializeArray();
                    $.ajax({
                        type: "POST",
                        url: "{{route('slotSave')}}", // your php file name
                        data: form_data,
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
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
                                location.reload();
                            } else {
                                Swal.fire("Sorry!", data.message, "error");
                            }
                        },
                        error: function (errorString) {
                            Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                        }
                    });
                }
            });

           var input = document.getElementById("addForm");
            input.addEventListener("keyup", function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    document.getElementById("btn_save").click();
                }
            });



        });

        function showUsers(id){
            var usersoption = document.getElementById("time_slot_"+id).checked;
            if(usersoption==true){
                $("#slot_user_"+id).prop("disabled", false);
            }else{
                $("#slot_user_"+id).val('').trigger('change');
                $("#slot_user_"+id).prop("disabled", true);
            }

        }

    </script>
@endsection
