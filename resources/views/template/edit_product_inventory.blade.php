
<tr class="explode hide container" id="remove_append_tr_{{$product_id}}">
    <td colspan="9" style="border-left:5px solid #b10303;background: rgb(236, 236, 236);">
        <div>
            @php $usersTypeArray = ['assembler','packaging','installation']; @endphp

            <table class="table table-condensed table-head-custom table-vertical-center" id="exist_append_items">
                <thead>
                <tr class="text-left text-uppercase">
                    <th style="min-width: 110px">Department</th>
                    <th style="min-width: 120px">Item</th>
                    <th style="min-width: 120px">Variant</th>
                    <th style="min-width: 120px">Quantity</th>
                    @if(!in_array(Auth::user()->type,$usersTypeArray))
                    <th style="min-width: 120px">Action</th>
                    @endif
                </tr>
                </thead>
                <tbody data-repeater-list="">
                @foreach($assignedInventory as $assigned)
                <tr id="append_{{$assigned->id}}">
                    <td>
                        <input class="form-control" type="text"  value="{{$assigned->department_name}}" readonly>
                        <input class="form-control" type="hidden" id="save_dept_id_{{$assigned->id}}" value="{{$assigned->department_id}}">
                    </td>
                    <td>
                        <input class="form-control" type="text"  value="{{$assigned->item_name}}" readonly>
                        <input class="form-control" type="hidden"  id="save_item_id_{{$assigned->id}}" value="{{$assigned->item_id}}">
                    </td>
                    <td>
                        <div class="form-group mb-0">
                            <input class="form-control" type="text"  value="{{$assigned->variant_name}}" readonly>
                            <input class="form-control" type="hidden" id="save_item_id_{{$assigned->id}}"  value="{{$assigned->variant_id}}">
                        </div>
                    </td>
                    <td>
                        <div class="row">
                        <div class="form-group col-6 mb-0">
                            <input class="form-control" id="qty_{{$assigned->id}}" type="number" {{isset($assigned->is_verified) && $assigned->is_verified==1 ? 'readonly' : ''}}  value="{{floor($assigned->qty)}}">
                            <span class="text-danger" id="qty_error_{{$assigned->id}}"></span>
                        </div>
                        <div class="form-group col-6 mb-0">

                            <input class="form-control" type="text" readonly value="{{floor($assigned->available_qty)}}">
                            <input class="form-control" type="hidden" id="available_qty_{{$assigned->id}}"  value="{{floor($assigned->available_qty)}}">
                        </div>
                        </div>





                    </td>
                    @if(Auth::user()->type != 'assembler')
                    <td>
                        @if($assigned->is_verified==0)
                        <button type="button" class="btn btn-icon btn-light btn-hover-primary btn-sm remove_invenoty_product" data-id="{{$assigned->product_id.'~'.$assigned->id}}">
                                                                                    <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg-->
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                                                <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                                                                                    <rect x="0" y="7" width="16" height="2" rx="1"/>
                                                                                                    <rect opacity="0.3" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000) " x="0" y="7" width="16" height="2" rx="1"/>
                                                                                                </g>
                                                                                            </g>
                                                                                        </svg>
                                                                                        <!--end::Svg Icon-->
                                                                                    </span>
                        </button>
                        <button type="button" class="btn btn-icon btn-light btn-hover-primary btn-sm update_invenoty_product" data-id="{{$assigned->product_id.'~'.$assigned->id}}">
                                                                                    <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg-->
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                                                                <path d="M17,4 L6,4 C4.79111111,4 4,4.7 4,6 L4,18 C4,19.3 4.79111111,20 6,20 L18,20 C19.2,20 20,19.3 20,18 L20,7.20710678 C20,7.07449854 19.9473216,6.94732158 19.8535534,6.85355339 L17,4 Z M17,11 L7,11 L7,4 L17,4 L17,11 Z" fill="#000000" fill-rule="nonzero"/>
                                                                                                <rect fill="#000000" opacity="0.3" x="12" y="4" width="3" height="5" rx="0.5"/>
                                                                                            </g>
                                                                                        </svg>
                                                                                        <!--end::Svg Icon-->
                                                                                    </span>
                        </button>
                        @endif
                    </td>
                    @endif
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </td>
</tr>

