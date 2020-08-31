<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMindstormsIdeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mindstorms_ideas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gid');
            $table->string('idea');
            $table->char('priority');
            $table->smallInteger('urgency');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mindstorms_ideas');
    }
}
