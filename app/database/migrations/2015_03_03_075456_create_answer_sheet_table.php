<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswerSheetTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('answer_sheets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('lesson_id');
            $table->integer('word_id');
            $table->integer('answer_0');
            $table->integer('answer_1');
            $table->integer('answer_2');
            $table->integer('answer_3');
            $table->integer('user_answer_id');
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('answer_sheets');
    }
}
