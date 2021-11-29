<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->index('contract_id')->constrained('contracts');
            $table->string('name','500')->nullable();
            $table->string('slug','100')->nullable();
             $table->text('address')->nullable();
            $table->unsignedInteger('added_by')->nullable();
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
        Schema::dropIfExists('stores');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
