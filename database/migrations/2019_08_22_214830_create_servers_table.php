<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateServersTable extends Migration
{
    public function up()
    {
        Schema::create('servers', function(Blueprint $table) {
            $table->increments('local_id');
            $table->timestamps();

            $table->text('version');
            $table->text('title');
            $table->text('thumbnail')->nullable();
            $table->text('description');
            $table->json('poll_limits')->nullable(); // Pleroma only?
            $table->string('domain')->unique();
            $table->timestamp('last_scraped_at')->nullable();
            $table->string('since_id')->nullable();

            $table->integer('scraped')->default(0);
            $table->integer('statuses_parsed')->default(0);
            $table->integer('polls_found')->default(0);
        });
    }

    public function down()
    {
        Schema::drop('servers');
    }
}
