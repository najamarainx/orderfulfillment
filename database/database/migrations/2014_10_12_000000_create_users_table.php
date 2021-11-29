<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles');
            $table->string('name', 150);
            $table->string('u_name', 150)->nullable();
            $table->string('email', 150);
            $table->string('phone_number', 25)->nullable();
            $table->string('cnic', 50)->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 191);
            $table->enum('type',['super_admin','employee','shop','customer'])->default('shop');
            $table->string('photo', 250)->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_admin')->default(0);
            $table->string('country', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('zip_code', 150)->nullable();
            $table->text('address')->nullable();
            $table->rememberToken();
            $table->bigInteger('added_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
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
        Schema::dropIfExists('users');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
