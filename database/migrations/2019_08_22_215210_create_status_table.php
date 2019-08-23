<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateStatusTable
 * @see https://docs.joinmastodon.org/api/entities/#status
 */
class CreateStatusTable extends Migration
{

    public function up()
    {
        Schema::create('status', function(Blueprint $table) {
            // Local properties
            $table->increments('local_id');
            $table->integer('account_id');
            $table->integer('server_id');
            $table->timestamps();

            // Api properties
            $table->string('id');
            $table->string('in_reply_to_id')->nullable();
            $table->string('in_reply_to_account_id')->nullable();
            $table->boolean('sensitive');
            $table->text('spoiler_text');
            $table->string('visibility');
            $table->string('language')->nullable();
            $table->boolean('pinned')->nullable();
            $table->text('uri');
            $table->text('url');
            $table->integer('replies_count');
            $table->integer('reblogs_count');
            $table->integer('favourites_count');
            $table->text('content');
            //$table->reblog             interface{} `json:"reblog"`

            // Relationships
            $table->foreign('server_id')
                ->references('local_id')->on('servers')
                ->onDelete('cascade');

            $table->foreign('account_id')
                ->references('local_id')->on('accounts')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::drop('status');
    }
}
