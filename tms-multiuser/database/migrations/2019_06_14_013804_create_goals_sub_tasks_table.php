<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoalsSubTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();

        Schema::create('goals_subtasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tid');
            $table->date('start');
            $table->date('deadline');
            $table->string('subtask');
            $table->string('priority', 4);
            $table->unsignedTinyInteger('urgency');
            $table->string('status', 40)->default('Not Started');
            $table->timestamps();

            $table->foreign('tid')->references('id')->on('goals_tasks')
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
        Schema::dropIfExists('goals_subtasks');
    }
}
