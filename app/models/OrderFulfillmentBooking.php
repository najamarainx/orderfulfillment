<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderFulfillmentBooking extends Model
{
    use HasFactory;
    protected $table = 'orderfulfillment_bookings';
    public function assignSlots()
    {
        return $this->hasMany(OrderFulfillmentUserTimeSlot::class, 'time_slot_id', 'id');
    }
}
