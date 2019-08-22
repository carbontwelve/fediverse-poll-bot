<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{

    public function up()
    {
        Schema::create('accounts', function(Blueprint $table) {
            $table->string('id');
            $table->timestamps();
            $table->integer('server_id');
            $table->string('username');
            $table->string('acct');
            $table->string('display_name');
            $table->boolean('locked');
            $table->boolean('bot');
            $table->string('note');
            $table->string('url');
            $table->string('avatar');
            $table->string('avatar_static');
            $table->string('header');
            $table->string('header_static');
            $table->integer('followers_count');
            $table->integer('following_count');
            $table->integer('statuses_count');

            $table->foreign('server_id')
                ->references('id')->on('servers')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::drop('accounts');
    }
}
