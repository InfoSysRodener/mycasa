<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_informations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fullname');
            $table->string('address')->nullable();
            $table->string('gender')->nullable();
            $table->date('birthdate')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index('user_informations_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->unsignedBigInteger('enterprise_id')->nullable()->index('user_informations_enterprise_id_foreign');
            $table->foreign('enterprise_id')->references('id')->on('enterprises')->onDelete('SET NULL');
            $table->unsignedBigInteger('branch_id')->nullable()->index('user_informations_branch_id_foreign');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('SET NULL');
            $table->integer('points')->nullable();
            $table->string('profile')->nullable();
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
        Schema::table('user_informations', function (Blueprint $table) {
            $table->dropForeign('user_informations_user_id_foreign');
            $table->dropForeign('user_informations_branch_id_foreign');
            $table->dropForeign('user_informations_enterprise_id_foreign');
        });
        Schema::dropIfExists('user_informations');
    }
}
