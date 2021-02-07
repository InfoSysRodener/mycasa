<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('thread_id',32);
            $table->text('chat')->nullable();
            $table->string('image')->nullable();
            $table->string('is_read')->default('false');
            $table->unsignedBigInteger('user_id')->nullable()->index('messages_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->unsignedBigInteger('booking_id')->nullable()->index('messages_booking_id_foreign');
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('SET NULL');
            $table->unsignedBigInteger('joborder_id')->nullable()->index('messages_joborder_id_foreign');
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
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign('messages_user_id_foreign');
            $table->dropForeign('messages_joborder_id_foreign');
            $table->dropForeign('messages_booking_id_foreign');
        });
        Schema::dropIfExists('messages');
    }
}
