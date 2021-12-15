<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderFulfillmentSaleLog extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'orderfulfillment_sale_logs';

    public function orderDetials(){
        return $this->belongsTo(Order::class,'order_id','id');
    }
    public function itemDetails(){
        return $this->belongsTo(OrderFulfillmentItem::class,'item_id','id');
    }
    public function variantDetails(){
        return $this->belongsTo(OrderFulfillmentVariant::class,'variant_id','id');
    }
    public function departmentDetails(){
        return $this->belongsTo(OrderFulfillmentDepartment::class,'department_id','id');
    }
    public function assignedTask(){
        return $this->belongsTo(OrderFulfillmentAssignedTask::class,'task_id','id');
    }
    public function assignedUser(){
        return $this->belongsTo(OrderFulfillmentUser::class,'user_id','id');
    }




}
