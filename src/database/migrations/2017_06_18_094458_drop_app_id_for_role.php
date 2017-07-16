<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropAppIdForRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            //
            //$table->dropIndex('roles_name_app_unique');
            //$table->dropColumn('app_id');
            //$table->integer('code_id')->default(0);
            //$table->unique(['name','code_id'], 'roles_name_code_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            //
            $table->dropIndex('roles_name_code_unique');
            $table->dropColumn('code_id');
            $table->integer('app_id')->default(0);
            $table->unique(['name', 'app_id'], 'roles_name_app_unique');
        });
    }
}
