<?php

namespace App\Http\Controllers\Admin\Mock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\SaveMockAudioRequest;
use App\Interfaces\ExamRepositoryInterface;
use App\Http\Resources\MockAudioResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Models\Mock\MockExercise;
use App\Models\Mock\MockQuestion;
use App\Models\Mock\MockAudio;
use App\Models\Mock\MockModule;
use Image;
use File;
class MockAudioController extends Controller
{
    private ExamRepositoryInterface $mockAudioRepository;

    public function __construct(ExamRepositoryInterface $mockAudioRepository) 
    {
        $this->mockAudioRepository = $mockAudioRepository;
    }
    public function mockAudio()
    {
       $getData = $this->mockAudioRepository->getAll();
       $allData = MockAudioResource::collection($getData);
        return view('admin.mock.mock-audio.manage-mock-audio', compact('allData'));
    }
    public function createMockAudio()
    {
        //$lowerCase = strtolower('Listening');
        $mockModule = MockModule::where('name', 'Listening')->first();
        $mockExercise = MockExercise::where('module_id', $mockModule->id)->get();
        return view('admin.mock.mock-audio.create-mock-audio', compact('mockExercise'));
    }
    public function storeMockAudio(SaveMockAudioRequest $request)
    {
        $mockAudioDetails = $request->only([
            'mock_exercise_id',
            'title',
        ]);

        $file = $request->file('audio');
        $fileName = time().'.'.$file->getClientOriginalExtension();
        $file->move('file/uploads/mock-audio/', $fileName);

        $mockAudioDetails['audio'] = $fileName;

        $getData = $this->mockAudioRepository->create($mockAudioDetails);

        return redirect()->route('admin.settings.mock.audio')->with('success', 'Mock Listenting Created Successfully.');
    }
    public function editMockAudio(Request $request)
    {
        $mockId = $request->route('id');
        $data = $this->mockAudioRepository->getById($mockId);
        $mockQuestions = MockQuestion::find($mockId);
        $mockModule = MockModule::where('name', 'Listening')->first();
        $mockExercises = MockExercise::where('module_id', $mockModule->id)->get();
        return view('admin.mock.mock-audio.edit-mock-audio', compact('data','mockQuestions', 'mockExercises'));
    }
    public function updateMockAudio(Request $request)
    {
        $mockId = $request->route('id');
        
        $find_id = MockAudio::find($mockId);
        if (File::exists('file/uploads/mock-audio/'.$find_id->audio)) {
            File::delete('file/uploads/mock-audio/'.$find_id->audio);
        }
        $mockAudioDetails = $request->only([
            'mock_exercise_id',
            'title',
        ]);

        $file = $request->file('audio');
        $fileName = time().'.'.$file->getClientOriginalExtension();
        $file->move('file/uploads/mock-audio/', $fileName);

        $mockAudioDetails['audio'] = $fileName;

        $getData = $this->mockAudioRepository->update($mockId, $mockAudioDetails);

        return redirect()->route('admin.settings.mock.audio')->with('success', 'Mock Listening Update Successfully.');
    }
    public function deleteMockAudio(Request $request) 
    {
        $mockId = $request->route('id');
        $find_id = MockAudio::find($mockId);
        if (File::exists('file/uploads/mock-audio/'.$find_id->audio)) {
            File::delete('file/uploads/mock-audio/'.$find_id->audio);
        }
        
        $this->mockAudioRepository->delete($mockId);

        return redirect()->route('admin.settings.mock.audio')->with('success', 'Mock Listening Deleted Successfully.');
    }

}
