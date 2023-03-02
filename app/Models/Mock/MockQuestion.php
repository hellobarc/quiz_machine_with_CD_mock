<?php

namespace App\Models\Mock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockQuestion extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'mock_question_title',
        'mock_question_type',
        'mock_exercise_id',
        'question_instruction',
    ];
    public function mock()
    {
        return $this->belongsTo(Mock::class, 'mock_id');
    }
    public function mockExercise()
    {
        return $this->belongsTo(MockExercise::class, 'mock_exercise_id');
    }
    public function mockMultipleChoice()
    {
        return $this->hasMany(MockMultipleChoice::class, 'mock_question_id');
    }
    public function mockRadio()
    {
        return $this->hasMany(MockRadio::class, 'mock_question_id');
    }
    public function mockDropDown()
    {
        return $this->hasMany(MockDropDown::class, 'mock_question_id');
    }
    public function mockFillBlank()
    {
        return $this->hasMany(MockFillBlank::class, 'mock_question_id');
    }
    public function mockHeadingQuestion()
    {
        return $this->hasMany(MockHeadingMatchQuestion::class, 'mock_question_id');
    }
    public function mockSingleCheck()
    {
        return $this->hasMany(MockHeadingMatchQuestion::class, 'mock_question_id');
    }
}
