<?php

namespace App\Models\Mock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockModule extends Model
{
    use HasFactory;
    protected $fillable = [
       'name',
    ];
}
