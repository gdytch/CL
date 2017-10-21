<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Activities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function($table){
            $table->increments('id');
            $table->string('name');
            $table->integer('section_id')->unsigned()->nullable();
            $table->date('date')->nullable();
            $table->boolean('submission')->nullable()->default(true);
            $table->string('description')->nullable();
            $table->integer('ftrule_id')->unsigned()->nullable();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
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
        Schema::dropIfExists('activities');
        //
    }
}
