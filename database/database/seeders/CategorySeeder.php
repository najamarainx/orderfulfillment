<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryData = [
            ['name' => 'Category','type' => 'permission','added_by' => 1,'updated_by' => 1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'Permission','type' => 'permission','added_by' => 1,'updated_by' => 1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'Role','type' => 'permission','added_by' => 1,'updated_by' => 1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'User','type' => 'permission','added_by' => 1,'updated_by' => 1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'Contract','type' => 'permission','added_by' => 1,'updated_by' => 1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'Store','type' => 'permission','added_by' => 1,'updated_by' => 1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'Color','type' => 'permission','added_by' => 1,'updated_by' => 1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'Charge','type' => 'permission','added_by' => 1,'updated_by' => 1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'Product','type' => 'permission','added_by' => 1,'updated_by' => 1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'StoreSetting','type' => 'permission','added_by' => 1,'updated_by' => 1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'StoreProduct','type' => 'permission','added_by' => 1,'updated_by' => 1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'Tag','type' => 'permission','added_by' => 1,'updated_by' => 1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'Band','type' => 'permission','added_by' => 1,'updated_by' => 1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'Order','type' => 'permission','added_by' => 1,'updated_by' => 1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],


            // ['name' => 'Roller Blind','type' => 'product','added_by' => 1,'updated_by' => 1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            // ['name' => 'Vertical Blind','type' => 'product','added_by' => 1,'updated_by' => 1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]
        ];
        DB::table('categories')->insert($categoryData);
    }
}
