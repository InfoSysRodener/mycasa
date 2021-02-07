<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnEnterpriseIdOnJobordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('joborders', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('enterprise_id')->nullable()->index('joborders_enterprise_id_foreign');
            $table->foreign('enterprise_id')->references('id')->on('enterprises')->onDelete('SET NULL');

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
            //
            $table->dropColumn(['enterprise_id']);
        });
    }
}
