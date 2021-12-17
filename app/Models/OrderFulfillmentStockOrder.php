<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderFulfillmentStockOrder extends Model
{
    use HasFactory;
    protected $table = "orderfulfillment_stock_orders";
    public function stockOrderDetail()
    {
        return $this->hasMany(OrderFulfillmentStockOrderItem::class, 'stock_order_id', 'id');
    }
    public function supplierDetail()
    {
        return $this->belongsTo(OrderFulfillmentSupplier::class, 'supplier_id', 'id');
    }
}
