<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMockSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mock_submissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('mock_submission_log_id');
            $table->bigInteger('mock_question_id');
            $table->bigInteger('mock_sub_question_id');
            $table->bigInteger('mock_exercise_id');
            $table->string('question_type');
            $table->string('answered_text')->nullable();
            $table->string('submitted_ans')->nullable();
            $table->string('is_correct')->nullable();
            $table->integer('obtained_mark')->nullable();
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
        Schema::dropIfExists('mock_submissions');
    }
}
