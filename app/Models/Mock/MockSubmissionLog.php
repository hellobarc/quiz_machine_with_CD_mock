<?php

namespace App\Models\Mock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockSubmissionLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'mock_id',
        'module_id',
        'status',
        'session_start',
        'module_finishing_time',
        
    ];
    public function mockModule()
    {
        return $this->belongsTo(MockModule::class, 'module_id');
    }
}
