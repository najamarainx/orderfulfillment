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
    public function bookingDetail()
    {
        return $this->hasOne(OrderFulfillmentBookingAssign::class, 'booking_id', 'id');
    }
    public function bookingCategory()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function bookingSlot()
    {
        return $this->belongsTo(OrderFulfillmentTimeSlot::class, 'time_slot_id', 'id');
    }
    public function bookingOrder(){
        return $this->hasOne(OrderFulfillmentBookingOrderLog::class, 'booking_id', 'id');
    }
}
