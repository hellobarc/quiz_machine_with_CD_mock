<?php

namespace App\Models\Mock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockHeadingMatchQuestion extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'mock_question_id',
        'text',
        'blank_answer',
        'marks',
    ];
    public function mockQuestion()
    {
        return $this->belongsTo(MockQuestion::class, 'mock_question_id');
    }
    public function mockHeadingMatching()
    {
        return $this->belongsTo(MockHeadingMatch::class, 'blank_answer');
    }
    
}
