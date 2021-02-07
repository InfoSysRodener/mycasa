<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('thread_id',32);
            $table->string('title')->default('GroupChat');
            $table->unsignedBigInteger('creator_id')->nullable()->index('group_messages_user_id_foreign');
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->string('image')->nullable();
            $table->timestamps();
        });



        Schema::create('group_message_user', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->unsignedBigInteger('group_message_id')->nullable()->index('group_message_user_group_message_id_foreign');;
            $table->foreign('group_message_id')->references('id')->on('group_messages')->onDelete('CASCADE');

            $table->unsignedBigInteger('user_id')->nullable()->index('group_message_user_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');

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
        Schema::dropIfExists('group_messages');
        Schema::dropIfExists('group_message_user');
    }
}
