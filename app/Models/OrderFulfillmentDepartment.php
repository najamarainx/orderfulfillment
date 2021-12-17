<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
class OrderFulfillmentDepartment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "orderfulfillment_departments";
    protected $guarded = [];
    public function checkDepartmentAssigned($id) {
        $check = true;
        $checkDepartmentCount = DB::table('orderfulfillment_items')->where('department_id',$id)->count();
        if($checkDepartmentCount) {
            $check = false;
        }
        return $check;
    }
}
