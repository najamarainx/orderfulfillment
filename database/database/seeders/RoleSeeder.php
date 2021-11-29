<?php

namespace Database\Seeders;

use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create roles
        $roleData = [
            'id' => 1,
            'name' => 'Super Admin',
            'added_by' => 1,
            'updated_by' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ];
        $id = DB::table('roles')->insertGetId($roleData);
        $customerRoleData = [
            'id' => 2,
            'name' => 'customer',
            'added_by' => 1,
            'updated_by' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ];
         DB::table('roles')->insertGetId($customerRoleData);
        // assign permisssion
        Permission::assignPermission($id);
    }
}
