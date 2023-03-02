<?php

namespace App\Repositories;

use App\Interfaces\ExamRepositoryInterface;
use App\Models\Mock\MockAudio;

class MockAudioRepository implements ExamRepositoryInterface 
{
    
    public function getAll() 
    {
        return MockAudio::with('mockExercise')->get();
    }

    public function getById($Id) 
    {
        return MockAudio::findOrFail($Id);
    }

    public function delete($Id) 
    {
        MockAudio::destroy($Id);
    }

    public function create(array $Details) 
    {
        return MockAudio::create($Details);
    }

    public function update($Id, array $newDetails) 
    {
        return MockAudio::whereId($Id)->update($newDetails);
    }

    // public function getFulfilledOrders() 
    // {
    //     return Order::where('is_fulfilled', true);
    // }
}
