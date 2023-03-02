<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMockQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mock_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mock_question_title');
            $table->enum('mock_question_type', ['fill-blank', 'multiple-choice', 'radio', 'drop-down', 'heading-matching', 'drag-drop', 'single-check', 'true-of-nice']);
            $table->integer('mock_exercise_id');
            $table->text('question_instruction');
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
        Schema::dropIfExists('mock_questions');
    }
}
