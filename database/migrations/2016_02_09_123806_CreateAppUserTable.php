<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateAppUserTable extends Migration
{

    public function up()
    {
        Schema::create('app_users', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('provider');
            $table->string('provider_token')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('avatar')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('app_users');
    }


}