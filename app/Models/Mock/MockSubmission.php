<?php

namespace App\Models\Mock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockSubmission extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'mock_submission_log_id',
        'mock_question_id',
        'mock_sub_question_id',
        'mock_exercise_id',
        'question_type',
        'answered_text',
        'submitted_ans',
        'is_correct',
        'obtained_mark',
    ];
    public function mockQuestion()
    {
        return $this->belongsTo(MockQuestion::class, 'mock_question_id');
    }
}
