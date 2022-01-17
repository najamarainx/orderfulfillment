@extends('layouts.app')
@section('title', 'User')
@section('page_level_css_plugin')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page_level_css')
    <style>
        .error{
            color: red!important;
        }
        span.select2.select2-container.select2-container--default {
            width:100% !important;
        }
        .role_p > span.select2.select2-container.select2-container--default {
            width: 84% !important;
        }
    </style>
@endsection


@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-2">
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Users</h5>
                <!--end::Page Title-->
                <!--begin::Actions-->
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                <span class="text-muted font-weight-bold mr-4">User Profile</span>
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
                <div class="card card-custom col-lg-7 col-12">
                    <div class="card-header">
                        <div class="card-title">
                        <h3 class="card-label">Edit Profile</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form onsubmit="return false" id="addForm">
                            <input type="hidden" class="form-control" name="selectedcontryname" id="selectedcontryname" value="" />
                            <div class="row mb-2">
                                <div class="form-group col-md-6">
                                    <label class="col-form-label">Full Name <span class="text-danger">*</span></label>
                                    <input required type="text" class="form-control" name="name" value="{{(Auth::check()) ? Auth::user()->name : ''}}" id="name" placeholder="Enter name" />
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                    <input required type="email" class="form-control colorDisable" value="{{(Auth::check()) ? Auth::user()->email : ''}}" name="email" id="email" readonly
                                        placeholder="Enter email name" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Phone Number <span class="text-danger">*</span></label>
                                    <input required type="text" class="form-control" value="{{Auth::user()->phone_number}}"  name="phone" id="phone"
                                        placeholder="Enter phone number" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="country">Country:</label>
                                    <input type="text" class="form-control" placeholder="Enter Country" name="country" value="{{ !empty(Auth::user()->country) ? Auth::user()->country : '' }}" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="state">State:</label>
                                    <input type="text" class="form-control"  placeholder="Enter State" name="state" value="{{ !empty(Auth::user()->state) ? Auth::user()->state : '' }}" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="city">City: </label>
                                    <input type="text" class="form-control"  placeholder="Enter City" name="city" value="{{ !empty(Auth::user()->city) ? Auth::user()->city : '' }}" >
                                </div>
                                @if(!empty(Auth::user()->zip_code))
                                <div class="form-group col-md-6">
                                    <label for="zipcode">Zip Code: <span
                                            class="text-danger">*</span></label>
                                    <input required type="text" class="form-control" name="zip_code" id="zip_code"
                                           value="{{ !empty(Auth::user()->zip_code) ? Auth::user()->zip_code : '' }}"
                                            readonly>
                                </div>
                                @endif
                                <div class="col-md-12">
                                    <label class="col-form-label">Profile Photo</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="upload-image-site" id="image1"
                                                name="user_image" /><br />
                                            @if(!empty(Auth::user()->photo))
                                            <div id="frames1">
                                                <img src="{{asset('user/profile/').'/'.Auth::user()->photo}}" style="margin-top:20px; text-align:center" width="50px" height="50px"/>
                                            </div>
                                            @else
                                                <div id="frames1"></div>
                                            @endif
                                            <input type="hidden" value="" name="old_image" id="old_image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button type="button" class="btn btn-primary  font-weight-bold" id="btn_save">Update</button>
                        <button type="button" class="btn btn-light-primary ml-2 font-weight-bold">Close</button>
                    </div>
                </div>
                <div class="card card-custom col-lg-4 ml-5 col-12">
                    <div class="card-header">
                        <div class="card-title">
                        <h3 class="card-label">Change Password</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form onsubmit="return false" id="passwordform">
                            <div class="row mb-2">
                                <div class="col-lg-12 col-sm-4">
                                    <label>Current Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="currentpassword" id="currentpassword" placeholder="Enter Current Password" required />
                                </div>
                                <div class="col-lg-12 col-sm-4">
                                    <label>New Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control"  name="newpassword" id="newpassword"
                                        placeholder="Enter New Password" required />
                                </div>
                                <div class="col-lg-12 col-sm-4">
                                    <label>Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" name="cpassword" id="cpassword" class="form-control"
                                        placeholder="Enter Password" required />
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button type="button" class="btn btn-primary  font-weight-bold" id="btn_password">Update</button>
                        <button type="button" class="btn btn-light-primary ml-2 font-weight-bold">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page_level_js_plugin')
<script src="{{ asset('assets/plugins/custom/jqvalidation/jquery.validate.min.js?v=7.0.4') }}"></script>
@endsection
@section('page_level_js')
<script>

$(document).ready(function(){
    var validator = $("#addForm").validate({
        ignore: ":hidden:not(.selectpicker)",
        rules: {
            name: {
                required: true
            },
            email: {
                required: true
            },
            phone: {
                required: true,
                'check_phone_no':true
            },
        },
        errorPlacement: function(error, element) {
            var elem = $(element);
            if (elem.hasClass("upload-image-site")) {
                error.appendTo(elem.parent().after());
            } else {
                error.insertAfter(element);
            }
        }
    });
});
jQuery.validator.addMethod('check_phone_no', function(phone_number, element) {
        return phone_number.length > 9 &&
            phone_number.match(/^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$/);
    }, 'Please enter a correct UK number.');
    $(document).on('click', '#btn_save', function() {
        var validate = $("#addForm").valid();
        if (validate) {
            //var form_data = $("#addForm").serializeArray();
            var form = $('#addForm')[0];
            var selectcuntrycode = $('.iti__selected-dial-code').html();
            var form_data = new FormData(form);
            form_data.append('selectcuntrycode', selectcuntrycode);
            $.ajax({
                type: "POST",
                url: "{{ route('updateProfile') }}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
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
                        setTimeout(function()
                        {
                            location.reload();  //Refresh page
                        }, 5000);
                    } else {
                        //  toastr.danger(data.message);
                        Swal.fire("Sorry!", data.message, "error");
                    }
                },
                error: function(errorString) {
                    Swal.fire("Sorry!", "Something went wrong please contact to admin",
                        "error");
                }
            });
        }
    });

    $(document).on('click', '#btn_password', function() {
    var newpass = $("#newpassword").val();
    var cpass = $("#cpassword").val();
    if(newpass==cpass){
        var validate = $("#passwordform").valid();
        if (validate) {
            //var form_data = $("#addForm").serializeArray();
            var form = $('#passwordform')[0];
            var form_data = new FormData(form);
            $.ajax({
                type: "POST",
                url: "{{route('updatePassword')}}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
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
                        table.ajax.reload();
                    } else {
                        //  toastr.danger(data.message);
                        Swal.fire("Sorry!", data.message, "error");
                    }
                },
                error: function(errorString) {
                    Swal.fire("Sorry!", "Something went wrong please contact to admin",
                        "error");
                }
            });
        }
    }else{
            Swal.fire("Sorry!", "New password And Confirm Password should be same",
                "error");
        return false;
    }
});

</script>
@endsection
