<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;


    public function product_images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }
    public function product_tags()
    {
        return $this->hasMany(ProductTag::class, 'product_id', 'id');
    }

    public function productMappings(){
        return  $this->hasOne(ProductContractMapping::class,'product_id','id');
    }
    public function product_color(){
        return  $this->hasOne(Color::class,'id','color_id');
    }
    public function product_category(){
        return  $this->hasOne(Category::class,'id','category_id');
    }

    public function bandPricingMapping() {
        return $this->hasMany(BandPriceMapping::class, 'band_id', 'id');
    }


}
