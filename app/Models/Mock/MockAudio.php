<?php

namespace App\Models\Mock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockAudio extends Model
{
    use HasFactory;
    protected $fillable = [
        'mock_exercise_id',
        'title',
        'audio',
        // 'image',
    ];
    public function mockExercise()
    {
        return $this->belongsTo(MockExercise::class, 'mock_exercise_id');
    }
}
