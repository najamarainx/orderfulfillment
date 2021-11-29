<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoreMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_store_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index('user_id')->constrained('users');
            $table->foreignId('store_id')->index('store_id')->constrained('stores');
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
        Schema::dropIfExists('user_store_mappings');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
