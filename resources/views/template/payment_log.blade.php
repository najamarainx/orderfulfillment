<form id="addForm" onsubmit="return false" >
    <input type="hidden" name="orderID" value="{{$orderID}}">
<table class="table table-head-custom table-vertical-center " id="kt_advance_table_widget_3 ">
    <thead>
    <tr class="text-left text-uppercase ">
        <th class="px-0 " style="width: 50px ">Sr#
        </th>
        <th style="min-width: 120px ">Received By</th>
        <th class="text-info " style="min-width: 150px ">Designation
        </th>
        <th class="text-info " style="min-width: 150px ">Amount Received($)</th>
        <th></th>
    </tr>
    </thead>

        <tbody>
        @php
            $i=1;
        @endphp
        @foreach($paymentLogs as $paymentLog)

                <tr>
                    <td class="pl-0 ">
                       {{$i}}
                    </td>
                    <td class="pl-0 py-8 ">
                        {{ucfirst($paymentLog->name)}}
                    </td>
                    <td>
                        {{ucfirst($paymentLog->type)}}
                    </td>
                    <td>
                        {{$paymentLog->paid_amount}}
                    </td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" name="verify_amt[{{$paymentLog->id}}]" type="checkbox" {{isset($paymentLog->is_verified) && $paymentLog->is_verified==1 ? 'checked  disabled':''}} value="{{$paymentLog->is_verifeid}}" id="defaultCheck1">
                        </div>
                    </td>
                </tr>

            @php $i++ @endphp
        @endforeach
        </tbody>

</table>
</form>
