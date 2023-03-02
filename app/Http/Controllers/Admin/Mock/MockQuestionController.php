<?php

namespace App\Http\Controllers\Admin\Mock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\SaveMockQuestionsRequest;
use App\Models\Mock\MockExercise;
use App\Models\Mock\MockQuestion;
use App\Models\Mock\MockFillBlank;
use App\Models\Mock\MockMultipleChoice;
use App\Models\Mock\MockRadio;
use App\Models\Mock\MockDropDown;
use App\Models\Mock\MockHeadingMatch;
use App\Models\Mock\MockHeadingMatchQuestion;

class MockQuestionController extends Controller
{
    public function mockQuestions()
    {
       $allData = MockQuestion::with('mockExercise')->orderBy('id', 'desc')->paginate(10);
       
        return view('admin.mock.mock-question.manage-mock-questions', compact('allData'));
    }
    public function createMockQuestion()
    {
        $mockExercise = MockExercise::all();
        return view('admin.mock.mock-question.create-mock-question', compact('mockExercise'));
    }
    public function storeMockQuestion(SaveMockQuestionsRequest $request)
    {
        $mock_question_title = $request->mock_question_title;
        $mock_question_type = $request->mock_question_type;
        $mock_exercise_id = $request->mock_exercise_id;
        $question_instruction = $request->question_instruction;

        MockQuestion::insert([
            'mock_question_title'=> $mock_question_title,
            'mock_question_type'=>$mock_question_type,
            'mock_exercise_id'=>$mock_exercise_id,
            'question_instruction'=>$question_instruction,
        ]);
        return redirect()->route('admin.settings.mock.questions')->with('success', 'Mock Question Created Successfully.');
    }
    public function editMockQuestion(Request $request, $id)
    {
        $mockQuestions = MockQuestion::find($id);
        $mockExercises = MockExercise::all();
        return view('admin.mock.mock-question.edit-mock-question', compact('mockQuestions', 'mockExercises'));
    }
    public function updateMockQuestion(Request $request, $id)
    {
        $mock_question_title = $request->mock_question_title;
        $mock_question_type = $request->mock_question_type;
        $mock_exercise_id = $request->mock_exercise_id;
        $question_instruction = $request->question_instruction;

        MockQuestion::updateOrCreate([
                'id'=>$id
            ],
        [
            'mock_question_title'=> $mock_question_title,
            'mock_question_type'=>$mock_question_type,
            'mock_exercise_id'=>$mock_exercise_id,
            'question_instruction'=>$question_instruction,
        ]);

        return redirect()->route('admin.settings.mock.questions')->with('success', 'Mock Questions Update Successfully.');
    }
    public function deleteMockQuestion(Request $request, $id, $questionType) 
    {
        $mockQuestion = MockQuestion::find($id);
            if(!is_null($mockQuestion))
            {
                if($questionType == 'fill-blank'){
                   $questionsSub =  MockFillBlank::where('mock_question_id', $id)->delete();
                }elseif($questionType == 'multiple-choice'){
                    $questionsSub =  MockMultipleChoice::where('mock_question_id', $id)->delete();
                }elseif($questionType == 'radio'){
                    $questionsSub =  MockRadio::where('mock_question_id', $id)->delete();
                }elseif($questionType == 'drop-down'){
                    $questionsSub =  MockDropDown::where('mock_question_id', $id)->delete();
                }elseif($questionType =='single-check' || $questionType =='heading-matching' || $questionType =='true-of-nice'){
                    $questionsSubHeading =  MockHeadingMatch::where('mock_question_id', $id)->delete();
                    $questionsSubHeadingQuestion =  MockHeadingMatchQuestion::where('mock_question_id', $id)->delete();
                }
                $mockQuestion->delete();
            }

        return redirect()->route('admin.settings.mock.questions')->with('success', 'Mock Question Delete Successfully.');
    }
}
