<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateHandsetTable extends Migration
{

    public function up()
    {
        Schema::create('handsets', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('device_type');
            $table->string('device_id')->unique()->nullable();
            $table->string('push_token')->nullable();
            $table->string('access_token')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('handsets');
    }


}