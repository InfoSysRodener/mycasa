<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserEnterpriseControlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_enterprise_controls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_control_id')->nullable()->index('user_enterprise_controls_user_control_id_foreign');
            $table->foreign('user_control_id')->references('id')->on('user_controls')->onDelete('SET NULL');
            $table->unsignedBigInteger('enterprise_id')->nullable()->index('user_enterprise_controls_enterprise_id_foreign');
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
        Schema::dropIfExists('user_enterprise_controls');
    }
}
