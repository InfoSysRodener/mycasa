<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJoborderServiceSuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('joborder_service_supplies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('qty');
            $table->string('cost');
            $table->string('type');
            $table->unsignedBigInteger('joborder_id')->nullable()->index('joborder_service_supplies_joborder_id_foreign');
            $table->foreign('joborder_id')->references('id')->on('joborders')->onDelete('SET NULL');
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
        Schema::dropIfExists('joborder_service_supplies');
    }
}
