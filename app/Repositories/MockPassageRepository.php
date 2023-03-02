<?php

namespace App\Repositories;

use App\Interfaces\ExamRepositoryInterface;
use App\Models\Mock\MockPassage;

class MockPassageRepository implements ExamRepositoryInterface 
{
    
    public function getAll() 
    {
        return MockPassage::with('mockExercise')->get();
    }

    public function getById($Id) 
    {
        return MockPassage::findOrFail($Id);
    }

    public function delete($Id) 
    {
        MockPassage::destroy($Id);
    }

    public function create(array $Details) 
    {
        return MockPassage::create($Details);
    }

    public function update($Id, array $newDetails) 
    {
        return MockPassage::whereId($Id)->update($newDetails);
    }

    // public function getFulfilledOrders() 
    // {
    //     return Order::where('is_fulfilled', true);
    // }
}
