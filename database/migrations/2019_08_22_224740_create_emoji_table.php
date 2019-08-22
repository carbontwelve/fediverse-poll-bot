<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateEmojiTable extends Migration
{

    public function up()
    {
        Schema::create('emoji', function(Blueprint $table) {
            $table->increments('id');
            $table->string('shortcode');
            $table->string('url');
            $table->string('static_url');
        });
    }

    public function down()
    {
        Schema::drop('emoji');
    }
}
