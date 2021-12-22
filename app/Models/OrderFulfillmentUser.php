<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
class OrderFulfillmentUser extends Authenticatable
{







    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $table = "orderfulfillment_users";

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    /*
    protected $fillable = [
        'name',
        'u_name',
        'email',
        'password',
        'role_id',
    ];
    */
    protected $guarded=[];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function checkRoleAssigned($id)
    {
        $check = true;
        $checkRolesnCount = DB::table('orderfulfillment_users')->where('role_id', $id)->count();
        if ($checkRolesnCount) {
            $check = false;
        }
        return $check;
    }
}
