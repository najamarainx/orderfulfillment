<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductMilimetersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_milimeters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->index('product_id')->nullable()->constrained('products');
            $table->double('length','10,2')->nullable();
            $table->double('width','10,2')->nullable();
            $table->double('price','10,2')->nullable();
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
        Schema::dropIfExists('product_milimeters');
    }
}
