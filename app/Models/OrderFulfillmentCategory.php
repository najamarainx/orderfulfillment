<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class OrderFulfillmentCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "orderfulfillment_categories";

    public function checkCategoryAssign($id) {
        $check = true;
        $checkCategoryCount = DB::table('orderfulfillment_permissions')->where('category_id',$id)->count();
        if($checkCategoryCount) {
            $check = false;
        }
        return $check;
    }
}
