@extends('layouts.app')
@section('title', 'User')
@section('page_level_css_plugin')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page_level_css')
    <style>
        body{
        background-color: white;font-family: 'Poppins';
    }
    a.btn.btn-sm.btn-clean.btn-icon.edit {
        background-color: #FFE2E5;
    border-color: transparent;
}
a.btn.btn-sm.btn-clean.btn-icon.delete {
    background-color: #FFE2E5;
    border-color: transparent;
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
a.btn.btn-sm.btn-clean.btn-icon.edit:hover {
        background-color: #B21F24;
    border-color: transparent;
}
a.btn.btn-sm.btn-clean.btn-icon.delete:hover {
    background-color: #B21F24;
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
@php
    $userTypes=array('measurement','installation','customer_support','accountant','production_manager','assembler','packaging');
    $type  = Auth::user()->type;
    if($type == 'production_manager'){
        $userTypes=array('team_lead','worker','screen');
    }else if($type == 'team_lead'){
        $userTypes=array('worker');

    }

    $usersTypeArray = ['assembler','packaging','installation'];


@endphp
@section('content')
    <!--begin::Content-->
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
                    <span class="text-muted font-weight-bold mr-4">List</span>
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
                            <span class="card-label font-weight-bolder text-dark">User List {{ isset($totalItems) && !empty($totalItems) ? '('.$totalItems.')'  :' '  }}</span>
                        </h3>
                        <div class="card-toolbar">

                            <a data-target="#staticBackdrop" data-toggle="modal" class="btn btn-primary font-weight-bolder" id='btn_add_new'>
                        <span class="svg-icon svg-icon-md">
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
                        </span>Add User</a>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-2 pb-0 mt-n3">

                            <!--begin::Tap pane-->
                        <form class="kt-form kt-form--fit">
                            <div class="row">
                                    <div class="col-lg-3 col-md-2 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Name:</label>
                                            <input type="text" class="form-control datatable-input" placeholder="Name" data-col-index="1">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-2 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Email:</label>
                                            <input type="email" class="form-control datatable-input" placeholder="Email" data-col-index="2">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-2 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Phone Number:</label>
                                            <input type="number" class="form-control datatable-input" placeholder="Phone.No" data-col-index="3">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-2 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Role:</label>
                                            <select class="form-control kt_select2_1 datatable-input " id="role_search" data-col-index="4" >
                                                <option value="">Select Role</option>
                                                @foreach($roles as $role)
                                                    <option value="{{$role->id}}" >{{ucfirst($role->name)}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    @if(!in_array(Auth::user()->type , $usersTypeArray))
                                    <div class="col-lg-3 col-md-2 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>User Type:</label>
                                            <select class="form-control kt_select2_1 datatable-input "id="type_search" data-col-index="5">
                                                <option value="">Select User Type</option>
                                                @foreach($userTypes as $type)
                                                    <option value="{{$type}}">{{str_replace('_',' ',ucfirst($type))}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-lg-3 col-md-2 col-sm-6 col-xs-12">
                                        <label>&nbsp;</label><br />
                                        <button class="btn btn-primary btn-primary--icon" id="kt_search">
                                        <span>
                                            <i class="la la-search"></i>
                                            <span>Search</span>
                                        </span>
                                                </button>&#160;&#160;
                                        <button class="btn btn-secondary btn-secondary--icon" id="kt_reset">
                                        <span>
                                            <i class="la la-close"></i>
                                            <span>Reset</span>
                                        </span>
                                                </button>

                                    </div>
                                </div>
                        </form>
                                <!--begin::Table-->

                                    <table class="table table-bordered table-checkable" id="datatableList">
                                        <thead>
                                        <tr>
                                            <th>Sr</th>
                                           <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone No</th>
                                            <th>Role</th>
                                            <th>User Type</th>
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
    <!--------modal user---------------->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">

            <form onsubmit="return false" id="addForm">
                <input type="hidden" class="form-control" name="id" id="id" value="" />
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" name="is_head" id="is_head">
                            <div class="form-group">
                            <label class="control-label" for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name"  data-col-index="1">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                            <label class="control-label" for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                            <label class="control-label" for="phone">Phone No.</label>
                                <input type="number" name="phone" id="phone" class="form-control" placeholder="Phone.No (UK)">
                            </div>
                        </div>
                        @if(!in_array(Auth::user()->type,$usersTypeArray))
                        <div class="col-6">
                            <div class="form-group">
                            <label class="control-label" for="user_type">User Type</label>
                                <select class="form-control kt_select2_1 user_type" name="user_type" id="user_type" onchange="getUserType(this.value)" required >
                                    <option value="">Select User Type</option>
                                    @foreach($userTypes as $type)
                                    <option value="{{$type}}">{{str_replace('_',' ',ucfirst($type))}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class="col-6">
                            <div class="input-group role_p">
                                <label class="control-label" for="user_role">User Role</label>
                                <div class="d-flex w-75">
                                    <select class="form-control kt_select2_1 user_role" id="user_role" name="user_role" required >
                                        <option value="">Select Role</option>
                                        @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{ucfirst($role->name)}}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary font-weight-bold" id="show_permission">
                                            <i class="la la-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @if(Auth::user()->type == 'production_manager')
                        <div class="col-6">
                            <div class="form-group">
                            <label class="control-label" for="user_role">Departments</label>
                                <select class="form-control kt_select2_1 user_department" id="user_department" name="user_department" required >
                                    <option value="">Select Department</option>
                                    @if(!($departments->isEmpty()))
                                    @foreach($departments as $department)
                                    <option value="{{$department->id}}">{{ucfirst($department->name)}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class="col-12" id="show_type" style="{{Auth::user()->type == 'installation' ? 'display:block' : 'display:none'}}">
                            <div class="form-group">
                                <label class="control-label" for="zip_code">Post Code</label>
                                <select class="form-control select2 kt_select2_3 " multiple="multiple" name="zip_id[]" id="zip_id">
                                   @foreach($zipcodes as $zipcode)
                                        <option value="{{$zipcode->id}}">{{ucfirst($zipcode->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="text-danger zip_error"></span>
                        </div>
                        <div class="col-12 security_code " style="display:none;">
                            <div class="form-group">
                                <input type="text" name="security_code" id="security_code" class="form-control" placeholder="Security Code">
                            </div>
                            <span class="text-danger security_code_error"></span>
                        </div>



                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary font-weight-bold" id="btn_save">Save</button>
                </div>
            </div>
            </form>
        </div>
    </div>
<!-------end user modal-------------->
<!-------modal permission--------------->
    <div class="modal fade" id="show_permission_modal" tabindex="-1" role="dialog" aria-labelledby="show_permission_modal"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                    <span class="card-icon svg-icon svg-icon-primary svg-icon-2x">
                        <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo5\dist/../src/media/svg/icons\Home\Key.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                             height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <polygon fill="#000000" opacity="0.3"
                                         transform="translate(8.885842, 16.114158) rotate(-315.000000) translate(-8.885842, -16.114158) "
                                         points="6.89784488 10.6187476 6.76452164 19.4882481 8.88584198 21.6095684 11.0071623 19.4882481 9.59294876 18.0740345 10.9659914 16.7009919 9.55177787 15.2867783 11.0071623 13.8313939 10.8837471 10.6187476" />
                                <path
                                    d="M15.9852814,14.9852814 C12.6715729,14.9852814 9.98528137,12.2989899 9.98528137,8.98528137 C9.98528137,5.67157288 12.6715729,2.98528137 15.9852814,2.98528137 C19.2989899,2.98528137 21.9852814,5.67157288 21.9852814,8.98528137 C21.9852814,12.2989899 19.2989899,14.9852814 15.9852814,14.9852814 Z M16.1776695,9.07106781 C17.0060967,9.07106781 17.6776695,8.39949494 17.6776695,7.57106781 C17.6776695,6.74264069 17.0060967,6.07106781 16.1776695,6.07106781 C15.3492424,6.07106781 14.6776695,6.74264069 14.6776695,7.57106781 C14.6776695,8.39949494 15.3492424,9.07106781 16.1776695,9.07106781 Z"
                                    fill="#000000"
                                    transform="translate(15.985281, 8.985281) rotate(-315.000000) translate(-15.985281, -8.985281) " />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                        Permissions
                    </span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body" id="show_permission_body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary font-weight-bold" id="btn_save">Save</button>
                </div>
            </div>
        </div>
    </div>
<!------end permission modal------------->
@endsection
@section('page_level_js_plugin')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.4') }}"></script>
    <script src="{{ asset('assets/plugins/custom/jqvalidation/jquery.validate.min.js?v=7.0.4') }}"></script>
@endsection
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
                    url: "{{ route('getUserList') }}",
                    type: 'POST',
                    data: {
                        // parameters for custom backend script demo
                        columnsDef: [
                            'Sr','name','email','phone_number','role','user_type','created_at'
                        ],
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [
                    {
                        data: 'Sr'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'phone_number'
                    },
                    {
                        data: 'role'
                    },
                    {
                        data: 'user_type'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'action',
                        responsivePriority: -1,
                        bSortable: false
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
                name: {
                    required: true
                },
                email: {
                    required: true
                },
                phone: {
                    required: true,
                'check_phone_no': true

                },
                user_type: {
                    required: true
                },
                user_role: {
                    required: true
                },

            },
            errorPlacement: function(error, element) {
                var elem = $(element);
                if (elem.hasClass("user_type") || elem.hasClass("user_department")) {

                    error.appendTo(element.parent().after());
                    //error.insertAfter(element);
                }
                else if(elem.hasClass("user_role")){
                    error.appendTo(element.parent().after());
                }
                else {
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
            $('#id').val('');
            $('#zip_id').val('').trigger('change');
            $('#user_type').val('').trigger('change');
            $('#user_role').val('').trigger('change');
            $('#email').val('').prop("readonly", false);
            $('#user_department').val('').trigger('change.select2')

        });


        $(document).on('click', '#btn_save', function(){
            @if(Auth::user()->type == 'production_manager')
            $( "#user_department" ).rules( "add", {
                    required: true,
                    })
            @endif
            var validate = $("#addForm").valid();
            if(validate) {
                var userType=$('#user_type').val();
               if(userType=='measurement' || userType=='installation'){

                    if($('#zip_id').val()==''){
                        $('.zip_error').html('this field is required');
                        return false;
                    }

                }else{
                    $('.zip_error').html('');
                }

                var form_data = $("#addForm").serializeArray();
                $.ajax({
                    type: "POST",
                    url: "{{route('userSubmit')}}", // your php file name
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
                            var form = $("#addForm");
                            form[0].reset();
                            $('#staticBackdrop').modal('hide');
                            table.ajax.reload();
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
        $(document).on('click','.edit',function() {
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
                success: function (data){
                    if(data.status == 'success') {
                        $('#staticBackdrop').modal({
                            backdrop: 'static',
                            keyboard: false
                        }).on('hide.bs.modal', function(){
                            $("#addForm").validate().resetForm();

                        });
                        var rec = data.data;
                        console.log(rec);
                        var id = rec.id;
                        var name = rec.name;
                        var department_id = rec.department_id;
                        $('#id').val(id);
                        $('#name').val(name);
                        $('#phone').val(rec.phone_number);
                        $('#is_head').val(rec.is_head);
                        $('#email').val(rec.email).prop("readonly", true);
                        if(department_id != null){
                          $('#user_department').val(department_id).trigger("change.select2");
                        }
                        //$('#user_type').val(rec.type);
                        $('#user_type').val(rec.type).trigger('change');
                        $('#user_role').val(rec.role_id).trigger('change');
                        if(rec.type=='installment' || rec.type=='measurement'){
                            $('#show_type').show();
                            var zips = data.zipIDs;
                            var str_array = zips.split(',');
                            $("#zip_id").val(str_array).trigger("change");
                        }






                    } else {
                        Swal.fire("Sorry!", data.message, "error");
                    }
                },
                error: function (errorString){
                    Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                }
            });
        });
        $(document).on('click','.delete',function() {
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
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "{{route('userDelete')}}", // your php file name
                        data: form_data,
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data){
                            if(data.status == 'success') {
                                Swal.fire("Success!", data.message, "success");
                                table.ajax.reload();
                            } else {
                                Swal.fire("Sorry!", data.message, "error");
                            }
                        },
                        error: function (errorString){
                            Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                        }
                    });
                }
            });
        });


        var input = document.getElementById("addForm");
        input.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                document.getElementById("btn_save").click();
            }
        });



    });
    jQuery.validator.addMethod('check_phone_no', function(phone_number, element) {
        return phone_number.length > 9 &&
            phone_number.match(/^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$/);
    }, 'Please enter a correct UK number.');
    function getUserType(userType){
       if(userType=='installation' || userType=='measurement'){

           $('#show_type').show();
       }
       else{
           $('#show_type').hide();
       }
       /*if(userType=='worker')
       {$('.security_code').show();}else{ $('#security_code').val('');$('.security_code').hide();}*/

    }


    $(document).on('click', '#show_permission', function() {
        var role_id = $('#user_role').val();
        if (role_id != "") {
            var form_data = new FormData();
            form_data.append('role_id', role_id);
            $.ajax({
                type: "POST",
                url: "{{route('getPermissionByRoleId')}}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status == 'success') {
                        $('#show_permission_modal').modal({
                            backdrop: 'static',
                            keyboard: false
                        });
                        $('#show_permission_body').html(data.html);
                    } else {
                        Swal.fire("Sorry!", data.message, "error");
                    }
                },
                error: function(errorString) {
                    Swal.fire("Sorry!", "Something went wrong please contact to admin",
                        "error");
                }
            });
        } else {
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
            toastr.warning('Please select role first');
        }
    });





</script>
@endsection
