<?php
namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userArr = [
            'role_id' => 1,
            'name' => 'Developer',
            'u_name' => 'superadmin',
            'email' => 'dev@admin.com',
            'phone_number' => '03216252600',
            'password' => Hash::make("Admin123"),
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'type' => 'super_admin',
            'added_by' => 1,
            'updated_by' => 1
        ];
        User::create($userArr);

    }
}
