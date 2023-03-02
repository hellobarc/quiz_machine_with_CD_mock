<?php

namespace App\Models\Mock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockInstruction extends Model
{
    use HasFactory;
    protected $fillable = [
        'mock_id',
        'mock_module_id',
        'mock_cat_id',
        'instruction',
    ];
}
