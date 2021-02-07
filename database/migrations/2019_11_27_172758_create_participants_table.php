<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->unsignedBigInteger('group_message_id')->nullable()->index('participants_group_message_id_foreign');
            $table->foreign('group_message_id')->references('id')->on('group_messages')->onDelete('SET NULL');
            $table->unsignedBigInteger('user_id')->nullable()->index('participants_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
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
        Schema::dropIfExists('participants');
    }
}
