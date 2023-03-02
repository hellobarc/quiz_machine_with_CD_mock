<?php

namespace App\Models\Mock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockTrueOfNice extends Model
{
    use HasFactory;
    protected $fillable = [
        'mock_question_id',
        'blank_answer',
        'marks',
        
    ];
    public function mockQuestion()
    {
        return $this->belongsTo(MockQuestion::class, 'mock_question_id');
    }
}
