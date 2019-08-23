<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreatePollOptionsTable
 * @see https://docs.joinmastodon.org/api/entities/#poll-option
 */
class CreatePollOptionsTable extends Migration
{

    public function up()
    {
        Schema::create('poll_options', function(Blueprint $table) {
            $table->increments('local_id');
            $table->integer('poll_id');
            $table->timestamps();

            $table->string('title');
			$table->integer('votes_count')->nullable();

            $table->foreign('poll_id')
                ->references('local_id')->on('polls')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::drop('poll_options');
    }
}
