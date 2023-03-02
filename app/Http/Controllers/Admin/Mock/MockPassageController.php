<?php

namespace App\Http\Controllers\Admin\Mock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\SaveMockPassageRequest;
use App\Interfaces\ExamRepositoryInterface;
use App\Http\Resources\MockPassageResource;
use App\Repositories\MockPassageRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Models\Mock\MockExercise;
use App\Models\Mock\MockQuestion;
use App\Models\Mock\MockPassage;
use Image;
use File;
class MockPassageController extends Controller
{
    private ExamRepositoryInterface $mockPassageRepository;

    public function __construct(MockPassageRepository $mockPassageRepository) 
    {
        $this->mockPassageRepository = $mockPassageRepository;
    }
    public function mockPassage()
    {
       $getData = $this->mockPassageRepository->getAll();
       //dd($getData);
       $allData = MockPassageResource::collection($getData);
        return view('admin.mock.mock-passage.manage-mock-passages', compact('allData'));
    }
    public function createMockPassage()
    {
        $mockExercise = MockExercise::all();
        return view('admin.mock.mock-passage.create-mock-passage', compact('mockExercise'));
    }
    public function storeMockPassage(SaveMockPassageRequest $request)
    {
        $mockPassageDetails = $request->only([
            'mock_exercise_id',
            'title',
            'passage',
        ]);

        // $image = $request->file('image');
        // $img = time().'.'.$image->getClientOriginalExtension();
        // $location = public_path('image/uploads/mock/passage/' .$img);
        // $imgFile = Image::make($image)->save($location);

        // $mockPassageDetails['image'] = $img;

        $getData = $this->mockPassageRepository->create($mockPassageDetails);

        return redirect()->route('admin.settings.mock.passage')->with('success', 'Mock Passage Created Successfully.');
    }
    public function editMockPassage(Request $request)
    {
        $mockId = $request->route('id');
        $data = $this->mockPassageRepository->getById($mockId);
        $mockQuestions = MockQuestion::find($mockId);
        $mockExercises = MockExercise::all();
        return view('admin.mock.mock-passage.edit-mock-passage', compact('data','mockQuestions', 'mockExercises'));
    }
    public function updateMockPassage(Request $request)
    {
        $mockId = $request->route('id');
        
        // $find_id = MockPassage::find($mockId);
        // if (File::exists('image/uploads/mock/passage/'.$find_id->image)) {
        //     File::delete('image/uploads/mock/passage/'.$find_id->image);
        // }
        $mockPassageDetails = $request->only([
            'mock_exercise_id',
            'title',
            'passage',
        ]);

        // $image = $request->file('image');
        // $img = time().'.'.$image->getClientOriginalExtension();
        // $location = public_path('image/uploads/mock/passage/' .$img);
        // $imgFile = Image::make($image)->save($location);

        // $mockPassageDetails['image'] = $img;

        $getData = $this->mockPassageRepository->update($mockId, $mockPassageDetails);

        return redirect()->route('admin.settings.mock.passage')->with('success', 'Mock Passage Update Successfully.');
    }
    public function deleteMockPassage(Request $request) 
    {
        $mockId = $request->route('id');
        // $find_id = MockPassage::where('id', $mockId)->first();
        // if (File::exists('image/uploads/mock/passage/'.$find_id->image)) {
        //     File::delete('image/uploads/mock/passage/'.$find_id->image);
        // }
        
        $this->mockPassageRepository->delete($mockId);

        return redirect()->route('admin.settings.mock.passage')->with('success', 'Mock Passage Deleted Successfully.');
    }

}
