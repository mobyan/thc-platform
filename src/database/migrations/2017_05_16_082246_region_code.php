<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RegionCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rcode', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('parent_code');
            $table->integer('level');
            $table->string('name');
            $table->string('merged_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rcode');
    }
}
