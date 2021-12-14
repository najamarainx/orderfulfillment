<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class OrderItem extends Model
{
    protected $guarded = [];
    use HasFactory;
    use SoftDeletes;
    public function orderProducts()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
