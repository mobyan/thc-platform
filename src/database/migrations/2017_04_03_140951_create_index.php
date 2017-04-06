<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('device_data', function (Blueprint $table) {
            $table->index(['device_id', 'ts'], 'device_id_ts');
        });    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('device_data', function (Blueprint $table) {
            $table->dropIndex('device_id_ts');
        }); 
    }
}
