<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateEmojiTable extends Migration
{

    public function up()
    {
        Schema::create('emoji', function(Blueprint $table) {
            $table->increments('local_id');
            $table->integer('server_id');

            $table->string('shortcode');
            $table->string('url');
            $table->string('static_url');

            $table->foreign('server_id')
                ->references('local_id')->on('servers')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::drop('emoji');
    }
}
