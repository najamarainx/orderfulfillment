<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderFulfillmentInventoryItem extends Model
{
    use HasFactory;
    protected $table = "orderfulfillment_inventory_items";
    protected $guarded=[];
}
