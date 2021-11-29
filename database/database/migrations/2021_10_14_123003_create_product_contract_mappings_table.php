<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductContractMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_contract_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->index('contract_id')->constrained('contracts');
            $table->foreignId('product_id')->index('product_id')->constrained('products');
            $table->decimal('discount',10,2)->nullable();
            $table->enum('type',['fixed','percentage'])->default('fixed');
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
        Schema::dropIfExists('product_contract_mappings');
    }
}
