<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderFulfillmentBookingOrderLog extends Model
{
    use HasFactory;
    protected $table = 'orderfulfillment_booking_order_logs';
    public function orderdetail()
    {
        return $this->hasMany(OrderFulfillmentBookingOrderItemLog::class, 'order_id', 'id');
    }

}
