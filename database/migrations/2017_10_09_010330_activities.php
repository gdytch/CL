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
            $table->string('description')->nullable();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('set null');
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
        //
    }
}
