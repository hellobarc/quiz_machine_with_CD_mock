<?php

namespace App\Models\Mock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'mock_cat_name',
     ];
}
