<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApply extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_apply', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();

            $table->integer('user_id')->unsigned();
            $table->integer('app_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->enum('status', ['pending', 'pass', 'unpass'])->defualt('pending');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('app_id')->references('id')->on('app')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->index(['user_id', 'app_id', 'role_id']);        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_apply');
    }

}
