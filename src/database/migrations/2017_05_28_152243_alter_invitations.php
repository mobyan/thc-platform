<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterInvitations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_invitations', function (Blueprint $table) {
            //
            $table->integer('app_id')->unsigned();
            $table->string('regioncode');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_invitations', function (Blueprint $table) {
            //
            $table->dropColumn('app_id');
            $table->dropColumn('regioncode');
            $table->dropColumn('deleted_at');
        });
    }
}
