<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStationAddAvatarUrl extends Migration
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
            $table->string('avatar_url')->default('/image/noimage.jpg');
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
            $table->dropColumn('avatar_url');
        });
    }
}
