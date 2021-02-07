<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable()->index('ratings_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->unsignedBigInteger('joborder_id')->nullable()->index('ratings_joborder_foreign');
            $table->foreign('joborder_id')->references('id')->on('joborders')->onDelete('SET NULL');
            $table->integer('valueformoney')->nullable();
            $table->integer('politeness')->nullable();
            $table->integer('cleanliness')->nullable();
            $table->integer('technical')->nullable();
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
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropForeign('ratings_user_id_foreign');
            $table->dropForeign('ratings_joborder_id_foreign');
        });
        Schema::dropIfExists('ratings');
    }
}
