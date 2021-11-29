<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order_id')->index('order_id');
            $table->unsignedInteger('product_id')->index('product_id');
            $table->string('scale',20)->nullable();
            $table->string('dimension',50)->nullable();
            $table->string('fitting_type',100)->nullable();
            $table->string('side_control',100)->nullable();
            $table->string('chain_color',100)->nullable();
            $table->string('fitting_option',100)->nullable();
            $table->decimal('qty',10,2)->nullable();
            $table->decimal('price',10,2)->nullable();
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
        Schema::dropIfExists('order_items');
    }
}
