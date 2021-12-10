<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderFulfillmentBookingOrderItemLog extends Model
{
    use HasFactory;
    protected $table = 'orderfulfillment_booking_order_item_logs';
    public function orderProducts()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function orderCategory()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
