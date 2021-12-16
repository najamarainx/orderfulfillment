<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderFulfillmentBookingAssign extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "orderfulfillment_booking_assigns";
    public function assignedUser()
    {
        return $this->belongsTo(OrderFulfillmentUser::class, 'user_id', 'id');
    }
    public function bookedUser()
    {
        return $this->belongsTo(OrderFulfillmentUser::class, 'created_by','id');
    }
}
