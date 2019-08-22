<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateStatusTable extends Migration
{

    public function up()
    {
        Schema::create('status', function(Blueprint $table) {
            $table->string('id');
            $table->timestamps();
            $table->string('account_id');
            $table->integer('server_id');
            $table->string('in_reply_to_id');
            $table->string('in_reply_to_account_id');
            $table->boolean('sensitive');
            $table->string('spoiler_text');
            $table->string('visibility');
            $table->string('language');
            $table->string('uri');
            $table->string('url');
            $table->integer('replies_count');
            $table->integer('reblogs_count');
            $table->integer('favourites_count');
            $table->string('content');
            //$table->reblog             interface{} `json:"reblog"`

            $table->foreign('account_id')
                ->references('id')->on('accounts')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::drop('status');
    }
}
