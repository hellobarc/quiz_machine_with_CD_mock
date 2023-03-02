<?php

namespace App\Repositories;

use App\Interfaces\MockExerciseRepositoryInterface;
use App\Models\Mock\MockExercise;

class MockExerciseRepository implements MockExerciseRepositoryInterface 
{
    
    public function getAll() 
    {
        return MockExercise::with('mock', 'module')->get();
    }

    public function delete($Id) 
    {
       return MockExercise::destroy($Id);
    }

    public function create(array $Details) 
    {
        return MockExercise::create($Details);
    }

}
