<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderFulfillmentUserTimeSlot extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'orderfulfillment_user_time_slot_assigns';
}
