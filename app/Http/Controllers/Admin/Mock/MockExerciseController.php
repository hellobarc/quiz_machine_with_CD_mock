<?php

namespace App\Http\Controllers\Admin\Mock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\SaveMockExerciseRequest;
use App\Interfaces\MockExerciseRepositoryInterface;
use App\Http\Resources\MockExerciseResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Models\Mock\MockExercise;
use App\Models\Mock\Mock;
use App\Models\Mock\MockModule;

class MockExerciseController extends Controller
{
    private MockExerciseRepositoryInterface $mockExerciseRepository;

    public function __construct(MockExerciseRepositoryInterface $mockExerciseRepository) 
    {
        $this->mockExerciseRepository = $mockExerciseRepository;
    }
    public function mockExercise()
    {
       $getData = $this->mockExerciseRepository->getAll();
       //dd($getData);
       $allData = MockExerciseResource::collection($getData);
        return view('admin.mock.mock-exercise.manage-mock-exercise', compact('allData'));
    }
    public function createMockExercise()
    {
        $mocks = Mock::all();
        $modules = MockModule::all();
        return view('admin.mock.mock-exercise.create-mock-exercise', compact('mocks', 'modules'));
    }
    public function storeMockExercise(SaveMockExerciseRequest $request)
    {
        $mockExerciseDetails = $request->only([
            'mock_exercise_name',
            'mock_id',
            'module_id',
        ]);

        $getData = $this->mockExerciseRepository->create($mockExerciseDetails);

        return redirect()->route('admin.settings.mock.exercise')->with('success', 'Mock Exercise Created Successfully.');
    }
    
    public function deleteMockExercise(Request $request) 
    {
        $mockId = $request->route('id');
        
        $this->mockExerciseRepository->delete($mockId);

        return redirect()->route('admin.settings.mock.exercise')->with('success', 'Mock Exercise Delete Successfully.');
    }
}
