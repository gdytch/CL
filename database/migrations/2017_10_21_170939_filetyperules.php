<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Filetyperules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ftrules', function($table){
            $table->increments('id');
            $table->string('name');
            $table->string('extensions')->nullable();
        });

        Schema::table('activities', function($table){
            $table->foreign('ftrule_id')->references('id')->on('ftrules')->onDelete('set null');
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ftrules');
    }
}
