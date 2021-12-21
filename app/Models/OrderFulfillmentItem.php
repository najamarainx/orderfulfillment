<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class OrderFulfillmentItem extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'orderfulfillment_items';
    public function orderVariant()
    {
        return $this->hasMany(OrderFulfillmentVariant::class, 'item_id', 'id');
    }
    public function selectedVariant()
    {
        return $this->hasOne(OrderFulfillmentVariant::class, 'item_id', 'id');
    }
}
