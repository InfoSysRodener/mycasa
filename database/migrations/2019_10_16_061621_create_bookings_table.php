<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable()->index('bookings_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->unsignedBigInteger('vehicle_id')->nullable()->index('bookings_vehicle_id_foreign');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('SET NULL');
            $table->unsignedBigInteger('enterprise_id')->nullable()->index('bookings_enterprise_id_foreign');
            $table->foreign('enterprise_id')->references('id')->on('enterprises')->onDelete('SET NULL');
            $table->string('address')->nullable();
            $table->string('concern')->nullable();
            $table->string('concern_type')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('status');
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
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign('bookings_user_id_foreign');
            $table->dropForeign('bookings_vehicle_id_foreign');
        });
        Schema::dropIfExists('bookings');
    }
}
