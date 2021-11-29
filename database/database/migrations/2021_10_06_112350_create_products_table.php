<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// use DB;
class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->index('category_id')->nullable()->constrained('categories');
            $table->foreignId('color_id')->index('color_id')->nullable()->constrained('colors');
            $table->foreignId('charge_id')->index('charge_id')->nullable()->constrained('charges');
            $table->foreignId('band_id')->index('band_id')->nullable()->constrained('bands');
            $table->string('name','500')->nullable();
            $table->string('slug','500')->nullable();
            $table->string('sku','100')->nullable();
            $table->string('main_image','150')->nullable();
            $table->double('min_order_length','10,2')->nullable();
            $table->double('min_order_width','10,2')->nullable();
            $table->text('description')->nullable();
            $table->text('features')->nullable();
            $table->double('charges_price','10,2')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('products');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
