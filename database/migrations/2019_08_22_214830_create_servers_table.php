<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateServersTable extends Migration
{
    public function up()
    {
        Schema::create('servers', function(Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('domain');
            $table->timestamp('last_scraped_at')->nullable();
            $table->string('since_id')->nullable();
        });
    }

    public function down()
    {
        Schema::drop('servers');
    }
}
