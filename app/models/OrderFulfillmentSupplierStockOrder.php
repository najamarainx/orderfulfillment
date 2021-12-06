<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderFulfillmentSupplierStockOrder extends Model
{
    use HasFactory;
    protected $table = 'orderfulfillment_stock_order_items';
}
