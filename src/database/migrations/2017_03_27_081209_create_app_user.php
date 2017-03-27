<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppUser extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_user', function(Blueprint $table)
        {
            // $table->increments('id');
            // $table->timestamps();

            $table->integer('user_id')->unsigned();
            $table->integer('app_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('app_id')->references('id')->on('app')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'app_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('app_user');
    }

}
