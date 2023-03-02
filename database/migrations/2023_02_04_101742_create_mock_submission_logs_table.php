<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMockSubmissionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mock_submission_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('mock_id');
            $table->integer('module_id');
            $table->enum('status', ['started', 'completed']);
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
        Schema::dropIfExists('mock_submission_logs');
    }
}
