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
            $table->string('email')->nullable()->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->timestamps();
        });


        Schema::create('handsets', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('app_user_id')->nullable();
            $table->string('device_type');
            $table->string('device_id')->unique()->nullable();
            $table->string('push_token')->nullable();
            $table->string('access_token')->unique();
            $table->timestamps();
        });


        Schema::create('app_social_providers', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('app_user_id')->unsigned();
            $table->string('provider_type', 10)->nullable();
            $table->string('provider_key', 128)->nullable();
            $table->string('avatar_url')->nullable();
            $table->timestamps();
        });


    }

    public function down()
    {

        Schema::drop('app_users');
        Schema::drop('handsets');
        Schema::drop('app_social_providers');


    }


}