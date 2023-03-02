<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mock\{
    Mock,
    MockModule,
    MockExercise,
    MockPassage,
    MockQuestion,
    MockFillBlank,
    MockDropDown,
    MockMultipleChoice,
    MockRadio,
    MockHeadingMatch,
    MockHeadingMatchQuestion,
    MockSubmission,
    MockSubmissionLog,
};
use Session;
use Auth;
class SubmittedMockController extends Controller
{
    public function moduleInfo($mock_id)
    {
        $user_id = Auth::user()->id;
        $mock = Mock::find($mock_id);
        $mockModule = MockModule::all();
        $submittedModule = MockSubmissionLog::where('user_id', $user_id)->where('mock_id', $mock_id)->get();
        return view('frontend.user.submitted-mock.module-info', compact('mock', 'mockModule', 'submittedModule'));
    }
}
