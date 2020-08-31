<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoalsTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();

        Schema::create('goals_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('gid');
            $table->unsignedBigInteger('vid');
            $table->date('start');
            $table->date('deadline');
            $table->string('task');
            $table->string('type', 40)->default('task');
            $table->string('priority', 4);
            $table->unsignedTinyInteger('urgency');
            $table->string('status', 40)->default('Not Started');
            $table->timestamps();

            $table->foreign('gid')->references('id')->on('goals')
                ->onDelete('cascade');

            $table->foreign('vid')->references('id')->on('vendors');                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goals_tasks');
    }
}
