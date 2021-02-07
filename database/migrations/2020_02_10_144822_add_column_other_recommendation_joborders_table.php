<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOtherRecommendationJobordersTable extends Migration
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
//            $table->string('other_recommendation')->nullable()->after('recommendations');
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
//            $table->dropColumn('other_recommendation');
        });
    }
}
