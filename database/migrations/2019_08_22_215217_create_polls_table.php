<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreatePollsTable
 * @see https://docs.joinmastodon.org/api/entities/#poll
 */
class CreatePollsTable extends Migration
{
    public function up()
    {
        Schema::create('polls', function(Blueprint $table) {
            $table->increments('local_id');
            $table->integer('status_id');
            $table->timestamps();

            $table->integer('id');
            $table->timestamp('expires_at')->nullable();
            $table->boolean('expired');
            $table->boolean('multiple');
            $table->integer('votes_count');

            $table->foreign('status_id')
                ->references('local_id')->on('status')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::drop('polls');
    }
}
