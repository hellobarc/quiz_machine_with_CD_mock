<?php

namespace App\Models\Mock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockExercise extends Model
{
    use HasFactory;
    protected $fillable = [
        'mock_exercise_name',
        'mock_id',
        'module_id',
    ];
    public function mock()
    {
        return $this->belongsTo(Mock::class, 'mock_id');
    }
    public function module()
    {
        return $this->belongsTo(MockModule::class, 'module_id');
    }
}
