<?php

namespace App\Models\Mock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mock extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'mock_name',
        'thumbnail',
        'description',
        'instruction',
        'mock_category',
    ];
    
}
