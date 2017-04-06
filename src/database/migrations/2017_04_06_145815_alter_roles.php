<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function(Blueprint $table) {
            $table->integer('app_id')->default(0);
            $table->dropIndex('roles_name_unique');
            $table->unique(['name', 'app_id'], 'roles_name_app_unique');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function(Blueprint $table) {
            $table->dropColumn('app_id');
            $table->dropIndex('roles_name_app_unique');
            $table->unique('name');

        });
    }
}
