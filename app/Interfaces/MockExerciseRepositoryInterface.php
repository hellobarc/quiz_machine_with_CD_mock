<?php

namespace App\Interfaces;

interface MockExerciseRepositoryInterface 
{
    public function getAll();
    //public function getById($Id);
    public function delete($Id);
    public function create(array $Details);
    //public function update($Id, array $newDetails);
    // public function getFulfilled();
}
