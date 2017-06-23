<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRcode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('code_user', function (Blueprint $table) {
            //
            $table->integer('user_id')->unsigned();
            $table->integer('code_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('code_id')->references('id')->on('codes')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'code_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('code_user');
    }
}
