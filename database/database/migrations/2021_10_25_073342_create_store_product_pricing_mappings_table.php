<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreProductPricingMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_product_pricing_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->index('store_id')->nullable()->constrained('stores');
            $table->foreignId('product_id')->index('product_id')->nullable()->constrained('products');
            $table->decimal('margin',10, 2)->nullable();
            $table->decimal('vat',10,2)->nullable();
            $table->decimal('discount',10,2)->nullable();
            $table->decimal('sale_price',10,2)->nullable();
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
        Schema::dropIfExists('store_product_pricing_mappings');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
