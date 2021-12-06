@foreach ($timeSlotDetail as $timeSlotObj)
    @php
        $totalBooking = App\Models\OrderFulfillmentBooking::whereDate('date', $date)->where('time_slot_id', $timeSlotObj->id)->count();
        $disabledAtt = '';
        $disabledClass = '';
        $limit = $timeSlotObj->slot_limit;
        if($limit <= $totalBooking) {
            $disabledAtt = 'disabled="disabled"';
            $disabledClass = 'disabled';
        }
    @endphp
    <div class="col-md-6">
        <div class="slot_radio {{ $disabledClass }}">
            <input type="radio" name="time_slot" id="time_slot_{{ $timeSlotObj->id }}" class="radio" value="{{ $timeSlotObj->id }}" data-time="{{ date('g:i a',strtotime($timeSlotObj->booking_from_time)).' - '.date('g:i a',strtotime($timeSlotObj->booking_to_time)) }}" {{ $disabledAtt }} />
            <label for="time_slot_{{ $timeSlotObj->id }}">{{ date('g:i a',strtotime($timeSlotObj->booking_from_time)).' - '.date('g:i a',strtotime($timeSlotObj->booking_to_time)) }}</label>
        </div>
    </div>
@endforeach
