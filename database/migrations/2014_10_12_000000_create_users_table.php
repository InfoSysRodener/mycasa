<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('email',150)->unique();
            $table->string('mobile_number',30)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('mobile_number_verified_at')->nullable();
            $table->string('password',150);
            $table->string('user_type',255)->default('consumer');
            $table->string('fb_id',255)->nullable();
            $table->string('password_reset',255)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
