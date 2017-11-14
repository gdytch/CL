<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Exam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('exam_paper', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('number_of_test');
            $table->integer('perfect_score');
        });
        Schema::create('exams', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('exam_paper_id')->nullable()->unsigned();
            $table->integer('section_id')->nullable()->unsigned();
            $table->boolean('active')->default(false);
            $table->boolean('generated_papers')->default(false);
            $table->timestamps();
            $table->foreign('exam_paper_id')->references('id')->on('exam_paper')->onDelete('set null');
        });
        Schema::create('exam_test', function(Blueprint $table){
            $table->increments('id');
            $table->integer('exam_paper_id')->nullable()->unsigned();
            $table->string('name');
            $table->string('test_type');
            $table->integer('number_of_items');
            $table->string('description')->nullable();
            $table->foreign('exam_paper_id')->references('id')->on('exam_paper')->onDelete('cascade');

        });
        Schema::create('exam_item', function(Blueprint $table){
            $table->increments('id');
            $table->integer('exam_paper_id')->unsigned()->nullable();
            $table->integer('exam_test_id')->unsigned()->nullable();
            $table->string('correct_answer');
            $table->string('question');
            $table->integer('points');
            $table->foreign('exam_paper_id')->references('id')->on('exam_paper')->onDelete('cascade');
            $table->foreign('exam_test_id')->references('id')->on('exam_test')->onDelete('cascade');

        });
        Schema::create('exam_entry', function(Blueprint $table){
            $table->increments('id');
            $table->integer('student_id')->nullable()->unsigned();
            $table->date('date')->nullable();
            $table->integer('score')->nullable()->default(0);
            $table->integer('exam_id')->nullable()->unsigned();
            $table->boolean('active')->default(true);
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('set null');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');

        });
        Schema::create('exam_answer', function(Blueprint $table){
            $table->increments('id');
            $table->string('answer')->nullable();
            $table->integer('exam_entry_id')->nullable()->unsigned();
            $table->integer('exam_item_id')->nullable()->unsigned();
            $table->boolean('correct');
            $table->foreign('exam_entry_id')->references('id')->on('exam_entry')->onDelete('cascade');
            $table->foreign('exam_item_id')->references('id')->on('exam_item')->onDelete('cascade');

        });
        Schema::create('exam_item_choices', function(Blueprint $table){
            $table->increments('id');
            $table->string('choice');
            $table->integer('exam_item_id')->nullable()->unsigned();
            $table->foreign('exam_item_id')->references('id')->on('exam_item')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam');
        Schema::dropIfExists('exam_paper');
        Schema::dropIfExists('exam_item');
        Schema::dropIfExists('exam_answer');
        Schema::dropIfExists('exam_item_choices');
        Schema::dropIfExists('exam_test');
        Schema::dropIfExists('exam_entry');

    }
}
