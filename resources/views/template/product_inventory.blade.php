@if(!$assignedInventory->isEmpty())
<div class="table-responsive tableFixHead">
    <table class="table  table-head-custom table-vertical-center" id="kt_advance_table_widget_3">
        <thead>
        <tr class="text-left text-uppercase">
            <th class="px-0">Department</th>
            <th>Item</th>
            <th class="text-info">Variant</th>
            <th class="text-info">Qty</th>
            <th>Status
            </th>

        </tr>
        </thead>
        <tbody class="">
        @foreach($assignedInventory as $Inventory)
        <tr>
            <td class="pl-0">
                <a href="#" class="text-dark-75 font-weight-normal text-hover-primary mb-1 ">{{$Inventory->department_name}}</a>
            </td>
            <td>
                <span class="text-dark-75 font-weight-normal d-block ">{{$Inventory->item_name}}</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-normal d-block ">{{$Inventory->variant_name}}</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-normal d-block ">{{$Inventory->qty}}</span>
            </td>
            <td>
                <span class="label label-lg label-light-success label-inline">{{ucfirst($Inventory->status)}}</span>
            </td>

        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endif
<!--end::Table-->

<hr>
<form id="addForm">
    <input type="hidden" name="product_id" id="product_id" value="{{$product_id}}">
    <div class=" row">
        <div class="col-lg-1 col-1">
            <button class="btn btn-primary mt" type="button" onclick="addfield(0)">+</button>
        </div>
        <div class=" form-group col-lg-2 col-5">
            <label>Department</label>
            <select class="form-control kt_select2_1 " id="department_0" name="department[]" onchange="getDeptItems(this.value,0)" required >
                <option value="">Select Department</option>
                @if(!($departments->isEmpty()))
                @foreach($departments as $department)
                <option value="{{$department->id}}">{{ucfirst($department->name)}}</option>
                @endforeach
                @endif
            </select>
        </div>
        <div class=" form-group col-lg-2 col-5">
            <label>Item</label>
            <select class="form-control kt_select2_1"  id="item_id_0" name="item_id[]">
                <option>Item</option>
            </select>
        </div>
        <div class=" form-group col-lg-2 col-5 ml-auto">
            <label>Variant</label>
            <select class="form-control kt_select2_1" onchange="getVariantQty(this.value,0)" name="variant[]" id="variant_id_0">
                <option value="">Varient</option>
                @foreach($variants as $variant)
                <option value="{{$variant->id}}">{{ucfirst($variant->name)}}</option>
                @endforeach

            </select>
        </div>
        <div class=" form-group col-lg-2 col-5 mr-auto">
            <label>Actual Qty</label>
            <select class="form-control kt_select2_1" name="qty[]" id="qty_id_0">
                <option>Qty</option>
            </select>
        </div>
        <div class="col-lg-3 col-10 ml-auto mr-auto">
            <label>Qty</label>
            <div class="row">
                <div><button type="button" class="btn btn-primary qty-plus" data-id="0">+</button></div>
                <input type="text " class="form-control datatable-input inc_dec ml col-lg-4 col-8" data-col-index="1 " name="choose_qty[]" id="check_qty_0">
                <div><button type="button" class="btn btn-primary qty-minus" data-id="0">-</button></div>
            </div>
        </div>
        <div id="newfield" class="col-12"></div>

    </div>
</form>
