<?php

namespace App\Models\Mock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockHeadingMatch extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'mock_question_id',
        'heading_title',
        'is_show',
    ];
    public function mockQuestion()
    {
        return $this->belongsTo(MockQuestion::class, 'mock_question_id');
    }
}
