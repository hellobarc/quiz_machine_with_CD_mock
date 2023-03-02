<?php

namespace App\Http\Controllers\Admin\Mock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mock\MockFillBlank;
use App\Models\Mock\MockRadio;
use App\Models\Mock\MockDropdown;
use App\Models\Mock\MockMultipleChoice;
use App\Models\Mock\MockHeadingMatch;
use App\Models\Mock\MockHeadingMatchQuestion;
use App\Models\Mock\MockTrueOfNice;

class MockAddQuestionController extends Controller
{
    public function addQuestion($questionType, $questionId)
    {
        if($questionType == 'fill-blank')
        {
            $fillBlanks = MockFillBlank::where('mock_question_id', $questionId)->with('mockQuestion')->get();
            return view('admin.mock.mock-question.add-question.fill-blanks', compact('questionType', 'questionId', 'fillBlanks'));
        }elseif($questionType == 'multiple-choice'){
            $multipleChoice = MockMultipleChoice::where('mock_question_id', $questionId)->with('mockQuestion')->get();
            return view('admin.mock.mock-question.add-question.multiple-choice', compact('questionType', 'questionId', 'multipleChoice'));
        }elseif($questionType == 'radio'){
            $radio = MockRadio::where('mock_question_id', $questionId)->with('mockQuestion')->get();
            return view('admin.mock.mock-question.add-question.multiple-choice', compact('questionType', 'questionId', 'radio'));
        }elseif($questionType == 'drop-down'){
            $dropDown = MockDropdown::where('mock_question_id', $questionId)->with('mockQuestion')->get();
            return view('admin.mock.mock-question.add-question.multiple-choice', compact('questionType', 'questionId', 'dropDown'));
        }elseif($questionType == 'heading-matching'){
            $headingMatching = MockHeadingMatch::where('mock_question_id', $questionId)->with('mockQuestion')->paginate(10);
            return view('admin.mock.mock-question.add-question.heading-matching', compact('questionType', 'questionId', 'headingMatching')); 
        }elseif($questionType == 'single-check'){
            $singleCheck = MockHeadingMatch::where('mock_question_id', $questionId)->with('mockQuestion')->paginate(10);
            return view('admin.mock.mock-question.add-question.heading-matching', compact('questionType', 'questionId', 'singleCheck')); 
        }elseif($questionType == 'true-of-nice'){
            $trueOfNice = MockHeadingMatch::where('mock_question_id', $questionId)->with('mockQuestion')->paginate(10);
            return view('admin.mock.mock-question.add-question.heading-matching', compact('questionType', 'questionId', 'trueOfNice')); 
        }
    }
    public function storeQuestSub(Request $request) 
    {
        $input = $request->input();
        $question_id = $input['question_id'];
        $text = $input['text'];
        $blank_answer = $input['blank_answer'];
        $is_correct = $input['is_correct'];
        $marks = $input['marks'];
        if($input['question_type'] == 'multiple-choice')
        {
            MockMultipleChoice::insert([
                'mock_question_id' => $question_id,
                'text' => $text,
                'option_text' =>  json_encode($blank_answer),
                'is_correct' => json_encode($is_correct),
                'marks' => $marks,
            ]);
        }elseif($input['question_type'] == 'radio'){
            MockRadio::insert([
                'mock_question_id' => $question_id,
                'text' => $text,
                'option_text' =>  json_encode($blank_answer),
                'is_correct' => json_encode($is_correct),
                'marks' => $marks,
            ]);
        }elseif($input['question_type'] == 'drop-down'){
            MockDropdown::insert([
                'mock_question_id' => $question_id,
                'text' => $text,
                'option_text' =>  json_encode($blank_answer),
                'is_correct' => json_encode($is_correct),
                'marks' => $marks,
            ]);
        }
        
        return redirect()->back()->with('success', 'MockQuestion Added Successfully.'); 
    }
    public function deleteQuestSub(Request $request, $id, $questionType)
    {
        if($questionType == 'multiple-choice')
        {
            $multipleChoice = MockMultipleChoice::find($id);
            if(!is_null($multipleChoice))
            {
                $multipleChoice->delete();
            }
        }
        elseif($questionType == 'radio')
        {
            $radio = MockRadio::find($id);
            if(!is_null($radio))
            {
                $radio->delete();
            }
        }
        elseif($questionType == 'drop-down')
        {
            $dropDown = MockDropdown::find($id);
            if(!is_null($dropDown))
            {
                $dropDown->delete();
            }
        }
        
        return redirect()->back()->with('success', 'Mock Question Delete Successfully.');
    }
    public function storeQuestSubFillBlank(Request $request) 
    {
        $question_id = $request->question_id;
        $instruction = $request->instruction;
        $text = $request->text;
        $marks = $request->marks;
        $answer = explode(',', $request->blank_answer);
        $is_show = $request->is_show;

        MockFillBlank::insert([
            'mock_question_id' => $question_id,
            'text' => $text,
            'blank_answer' => json_encode($answer),
            'instruction' => $instruction,
            'marks' => $marks,
            'is_show'=>$is_show,
        ]);
        return redirect()->back()->with('success', 'Mock Fill blanks Added Successfully.');

    }
    public function deleteQuestSubFillBlank(Request $request, $id)
    {
        $fillBlanks = MockFillBlank::find($id);
    	if(!is_null($fillBlanks))
    	{
    		$fillBlanks->delete();
   		}
        return redirect()->back()->with('success', 'Fill in the blank Delete Successfully.');
    }
    public function storeQuestSubheadingmatch(Request $request)
    {
        $question_id = $request->question_id;
        $heading_title = $request->heading_title;
        MockHeadingMatch::insert([
            'mock_question_id'=>$question_id,
            'heading_title'=>$heading_title,
        ]);
        return redirect()->back()->with('success', 'Heading Matching store Successfully.');
    }
    public function deleteQuestSubHeadingMatch(Request $request, $id)
    {
        $headingMatching = MockHeadingMatch::find($id);
        
    	if(!is_null($headingMatching))
    	{
    		$headingMatching->delete();
            $headingMatchSubQuestion = MockHeadingMatchQuestion::where('blank_answer', $id)->delete();
   		}
        return redirect()->back()->with('success', 'Heading Match title Deleted Successfully.');
    }
    public function headingMatchingSubQuestion($question_id)
    {
        $mockHeadingMatch = MockHeadingMatchQuestion::where('mock_question_id', $question_id)->with('mockQuestion')->paginate(10);
        $mockHeadingTitle = MockHeadingMatch::where('mock_question_id', $question_id)->get();
        return view('admin.mock.mock-question.add-question.heading-mat-sub-quest', compact('question_id','mockHeadingTitle', 'mockHeadingMatch'));
    }
    public function storeHeadingMatchSubQuestion(Request $request)
    {
        $mock_question_id = $request->question_id;
        $text = $request->text;
        $blank_answer = $request->blank_answer;
        $marks = $request->marks;
        MockHeadingMatchQuestion::insert([
            'mock_question_id' =>$mock_question_id,
            'text' =>$text,
            'blank_answer' =>$blank_answer,
            'marks' =>$marks,
        ]);
        return redirect()->back()->with('success', 'Heading Match Sub Question added Successfully.');
        
    }
    public function deleteHeadingMatchSubQuestion(Request $request, $id)
    {
        $headingMatchSubQuestion = MockHeadingMatchQuestion::find($id);
    	if(!is_null($headingMatchSubQuestion))
    	{
    		$headingMatchSubQuestion->delete();
   		}
        return redirect()->back()->with('success', 'Heading Match Sub Question Deleted Successfully.');
    }
    public function headingMatchingTrueOfNice($question_id)
    {
        $mockHeadingMatch = MockTrueOfNice::where('mock_question_id', $question_id)->with('mockQuestion')->paginate(10);
        $mockHeadingTitle = MockHeadingMatch::where('mock_question_id', $question_id)->get();
        return view('admin.mock.mock-question.add-question.heading-mat-true-of-nice', compact('question_id','mockHeadingTitle', 'mockHeadingMatch'));
    }
    public function storeHeadingMatchTrueOfNice(Request $request)
    {
        $mock_question_id = $request->question_id;
        $blank_answer = $request->blank_answer;
        $marks = $request->marks;

        MockTrueOfNice::insert([
            'mock_question_id' =>$mock_question_id,
            'blank_answer' =>json_encode($blank_answer),
            'marks' =>$marks,
        ]);
        return redirect()->back()->with('success', 'Heading Match True of nice added Successfully.');
        
    }
    public function deleteHeadingMatchTrueOfNice(Request $request, $id)
    {
        $headingMatchTrueOfNice = MockTrueOfNice::find($id);
    	if(!is_null($headingMatchTrueOfNice))
    	{
    		$headingMatchTrueOfNice->delete();
   		}
        return redirect()->back()->with('success', 'Heading Match True of Nice Deleted Successfully.');
    }
    
}
