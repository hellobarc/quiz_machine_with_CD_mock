<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMockHeadingMatchQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mock_heading_match_questions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mock_question_id');
            $table->string('text');
            $table->string('blank_answer');
            $table->integer('marks');
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
        Schema::dropIfExists('mock_heading_match_questions');
    }
}
