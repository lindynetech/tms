<?php

use Illuminate\Support\Facades\Schema;
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
        Schema::enableForeignKeyConstraints();

        Schema::create('mindstorms_ideas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('gid');
            $table->string('idea');
            $table->string('priority', 4);
            $table->unsignedTinyInteger('urgency');
            $table->timestamps();

            $table->foreign('gid')->references('id')->on('mindstorms')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mindstorms_ideas');
    }
}
