<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderFulfillmentStockOrderItem extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "orderfulfillment_stock_order_items";

    public function orderItem()
    {
        return $this->belongsTo(OrderFulfillmentItem::class, 'item_id', 'id');
    }
    public function orderVariant()
    {
        return $this->belongsTo(OrderFulfillmentVariant::class, 'variant_id', 'id');
    }
}
