<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreatePollsTable extends Migration
{
    public function up()
    {
        Schema::create('polls', function(Blueprint $table) {
            $table->integer('id');
            $table->string('status_id');
            $table->timestamps();
            $table->timestamp('expires_at');
            $table->boolean('expired');
            $table->boolean('multiple');
            $table->integer('votes_count');

            $table->foreign('status_id')
                ->references('id')->on('status')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::drop('polls');
    }
}
