<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderFulfillmentAssignedTask extends Model
{
    use HasFactory;
    protected $table = 'orderfulfillment_assigned_tasks';
    public function assignedUser(){
        return $this->belongsTo(OrderFulfillmentUser::class,'user_id','id');
    }
    protected $guarded=[];
}
