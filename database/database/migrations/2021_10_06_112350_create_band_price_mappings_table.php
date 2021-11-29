<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBandPriceMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('band_price_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('band_id')->index('band_id')->constrained('bands');
            $table->decimal('length', 10, 2 );
            $table->decimal('width',10, 2 );
            $table->decimal('price',10, 2 );
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
        Schema::dropIfExists('band_price_mappings');
    }
}
