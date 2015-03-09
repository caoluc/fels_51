<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('words', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->string('content', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('words');
    }
}
