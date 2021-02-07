<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('make');
            $table->string('model');
            $table->string('year');
            $table->string('variant');
            $table->string('mileage')->nullable();
            $table->string('fuel')->nullable();
            $table->string('plate_no')->nullable();
            $table->string('engine_code')->nullable();
            $table->string('chassis_code')->nullable();
            $table->string('app_id_number')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index('vehicles_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->unsignedBigInteger('enterprise_id')->nullable()->index('vehicles_enterprise_id_foreign');
            $table->foreign('enterprise_id')->references('id')->on('enterprises')->onDelete('SET NULL');
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
        Schema::dropIfExists('vehicles');
    }
}
