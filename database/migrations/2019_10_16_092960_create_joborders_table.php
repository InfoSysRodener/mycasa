<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('joborders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->datetime('requested_at')->nullable();
            $table->datetime('completed_at')->nullable();
            $table->string('concern')->nullable();
            $table->string('assessment')->nullable();
            $table->string('solution')->nullable();
            $table->string('discount')->nullable();
            $table->string('total')->nullable();
            $table->unsignedBigInteger('issued_by')->nullable()->index('joborders_issued_id_foreign');
            $table->foreign('issued_by')->references('id')->on('users')->onDelete('SET NULL');
            $table->unsignedBigInteger('user_id')->nullable()->index('joborders_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->unsignedBigInteger('vehicle_id')->nullable()->index('joborders_vehicle_id_foreign');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('SET NULL');
            $table->datetime('check_up')->nullable();
            $table->text('recommendations')->nullable();
            $table->string('mileage')->nullable();
            $table->unsignedBigInteger('booking_id')->nullable()->index('joborders_booking_id_foreign');
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('SET NULL');
            $table->unsignedBigInteger('branch_id')->nullable()->index('joborders_branch_id_foreign');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('SET NULL');
            $table->string('image')->nullable();
            $table->string('status');
            $table->string('concern_type')->nullable();
            $table->datetime('schedule')->nullable();
            $table->string('location')->nullable();
            $table->string('feedback')->nullable();
            $table->string('client_signature')->nullable();
            $table->string('technician_signature')->nullable();
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
        Schema::table('joborders', function (Blueprint $table) {
            $table->dropForeign('joborders_issued_by_foreign');
            $table->dropForeign('joborders_user_id_foreign');
            $table->dropForeign('joborders_vehicle_id_foreign');
            $table->dropForeign('joborders_booking_id_foreign');
            $table->dropForeign('joborders_branch_id_foreign');
        });
        Schema::dropIfExists('joborders');
    }
}
