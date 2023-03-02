<?php

namespace App\Http\Controllers\Admin\Mock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\SaveManageMockRequest;
use App\Interfaces\ManageMockRepositoryInterface;
use App\Http\Resources\ManageMockResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Models\Mock\Mock;

use Image;
use File;

class ManageMockController extends Controller
{
    private ManageMockRepositoryInterface $manageMockRepository;

    public function __construct(ManageMockRepositoryInterface $manageMockRepository) 
    {
        $this->manageMockRepository = $manageMockRepository;
    }
    public function mock()
    {
       $getData = $this->manageMockRepository->getAll();
 
       $allData = ManageMockResource::collection($getData);
        return view('admin.mock.manage-mock', compact('getData'));
    }
    public function createMock()
    {
        return view('admin.mock.create-mock');
    }
    public function storeMock(SaveManageMockRequest $request)
    {
        $mockDetails = $request->only([
            'mock_name',
            'description',
            'instruction',
            'mock_category',
        ]);

        $image = $request->file('thumbnail');
        $img = time().'.'.$image->getClientOriginalExtension();
        $location = public_path('image/uploads/mock/thumbnail/' .$img);
        $imgFile = Image::make($image)->save($location);

        $mockDetails['thumbnail'] = $img;

        $getData = $this->manageMockRepository->create($mockDetails);

        return redirect()->route('admin.settings.mock')->with('success', 'Mock Created Successfully.');
    }
    public function editMock(Request $request)
    {
        $mockId = $request->route('id');
        $data = $this->manageMockRepository->getById($mockId);
        $mock = Mock::all();
        return view('admin.mock.edit-mock', compact('data', 'mock'));
    }
    public function updateMock(Request $request)
    {
        $mockId = $request->route('id');
        $find_id = Mock::where('id', $mockId)->first();
        if (File::exists('image/uploads/mock/thumbnail/'.$find_id->thumbnail)) {
            File::delete('image/uploads/mock/thumbnail/'.$find_id->thumbnail);
        }
        $mockDetails = $request->only([
            'mock_name',
            'description',
            'instruction',
            'mock_category',
        ]);

        $image = $request->file('thumbnail');
        $img = time().'.'.$image->getClientOriginalExtension();
        $location = public_path('image/uploads/mock/thumbnail/' .$img);
        $imgFile = Image::make($image)->save($location);

        $mockDetails['thumbnail'] = $img;

        $getData = $this->manageMockRepository->update($mockId, $mockDetails);

        return redirect()->route('admin.settings.mock')->with('success', 'Mock Update Successfully.');
    }
    public function deleteMock(Request $request) 
    {
        $mockId = $request->route('id');
        $find_id = Mock::where('id', $mockId)->first();
        if (File::exists('image/uploads/mock/thumbnail/'.$find_id->thumbnail)) {
            File::delete('image/uploads/mock/thumbnail/'.$find_id->thumbnail);
        }
        $this->manageMockRepository->delete($mockId);

        return redirect()->route('admin.settings.mock')->with('success', 'Mock Delete Successfully.');
    }
}
