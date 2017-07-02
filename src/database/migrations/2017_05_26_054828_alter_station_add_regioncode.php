<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStationAddRegioncode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('station', function (Blueprint $table) {
            //
            $table->string('code');
            $table->dropColumn('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('station', function (Blueprint $table) {
            //
            $table->dropColumn('code');
            $table->string('type');
        });
    }
}
