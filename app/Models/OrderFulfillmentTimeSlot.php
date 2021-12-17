<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class OrderFulfillmentTimeSlot extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "orderfulfillment_time_slots";

    public function slot_users()
    {
        return $this->hasMany(OrderFulfillmentUserTimeSlot::class, 'time_slot_id', 'id');
    }



}
