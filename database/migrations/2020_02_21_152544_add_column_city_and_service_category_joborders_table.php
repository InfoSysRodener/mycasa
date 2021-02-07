<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCityAndServiceCategoryJobordersTable extends Migration
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
            $table->string('city')->nullable()->after('schedule');
            $table->string('service_category')->nullable();
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
            $table->dropColumn(['city','service_category']);
        });
    }
}
