<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHabitsDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();

        Schema::create('habits_days', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('hid');
            $table->date('date');
            $table->string('time', 12)->nullable();
            $table->unsignedTinyInteger('day');
            $table->boolean('check')->default(0);
            $table->timestamps();

            $table->foreign('hid')->references('id')->on('habits')
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
        Schema::dropIfExists('habits_days');
    }
}
