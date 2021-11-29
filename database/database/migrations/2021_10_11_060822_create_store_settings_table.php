<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->index('store_id')->nullable()->constrained('stores');
            // $table->string('title', 250)->nullable();
            $table->string('store_link', 250)->nullable();
            $table->string('custom_domain', 250)->nullable();
            $table->string('sub_domain', 250)->nullable();
            $table->text('description')->nullable();
            $table->text('keywords')->nullable();
            $table->string('logo_path', 500)->nullable();
            $table->string('favicon_path', 500)->nullable();
            $table->string('cart_image', 500)->nullable();
            $table->string('wishlist_image', 500)->nullable();
            $table->string('products_cover_image', 500)->nullable();
            $table->string('email')->nullable();
            $table->string('phone_no', 50)->nullable();
            // $table->text('contact_address')->nullable();
            $table->string('banner_title',190)->nullable();
            $table->text('banner_description')->nullable();
            $table->text('images')->nullable();
            $table->text('footer_text')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('instagram')->nullable();
            // $table->string('pinterest')->nullable();
            $table->string('youtube')->nullable();
            // $table->string('skype')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('tagline')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->nullable();
            $table->boolean('status')->default('1');
            $table->text('about_us')->nullable();
            $table->text('terms_condition')->nullable();
            $table->text('returns_exchange')->nullable();
            $table->text('shipping_delivery')->nullable();
            $table->text('privacy_policy')->nullable();
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
        Schema::dropIfExists('store_settings');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
