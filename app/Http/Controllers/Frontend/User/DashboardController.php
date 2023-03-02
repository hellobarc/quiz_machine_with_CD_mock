<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Category;
use App\Models\Level;
use App\Models\Quiz;
use App\Models\QuizRadio;
use App\Models\ExamSubmission;
use App\Models\MultipleChoice;
use App\Models\FillBlank;
use App\Models\QuizDropdown;
use App\Models\ParticipantLog;
use App\Models\ExamLog;
use App\Models\Article;
use App\Models\Mock\Mock;
use App\Models\Mock\MockSubmissionLog;
use Auth;
use Session;

class DashboardController extends Controller
{
    public function userDashboard()
    {
        $data['meta_title'] = "Home Page";
        $data['meta_description'] = "Home Page";
        $data['bread_chrumb'] = "Home";

        $course_data = [];


        $user_id = Auth::user()->id;
        $exam_log = ExamLog::where('user_id', $user_id)->first();
        $exam_log_id = $exam_log->id;
        $result = ExamSubmission::where('exam_log_id', $exam_log_id)->with('exam')->groupBy('exam_id')->get();
        $exam_started_time = explode('.', $exam_log->session);
        $exam_finishing_time = $exam_log->exam_finishing_time;
        $exam_last_finshing_time = date("i:s",($exam_finishing_time - $exam_started_time[0]));
        foreach($result as $row)
        {
            $test_id = $row->exam->id;
            $level_id = $row->exam->level_id;
            $exam_title = $row->exam->title;
            $exam_thumbnail = $row->exam->thumbnail;
            $exam_time = $row->exam->time_limit;
            $category_id = $row->exam->category_id;
            $level = Level::find($level_id);
            $category = Category::find($category_id);


            //mark calculation
            $totalQuestion = ExamSubmission::where('exam_log_id', $exam_log_id)->where('exam_id', $test_id)
                                            ->where('quiz_type', '!=', 'fill-blank')
                                            ->count();
            $obtainMarks = ExamSubmission::where('exam_log_id', $exam_log_id)->where('exam_id', $test_id)
                                        ->where('quiz_type', '!=', 'fill-blank')
                                        ->where('is_correct', '=', 'yes')
                                        ->count();

            //$totalFillBlanksCount = ExamSubmission::where('exam_log_id', 1)->where('exam_id', $test_id)->where('quiz_type', 'fill-blank')->count();
            $totalFillBlanks = ExamSubmission::where('exam_log_id', $exam_log_id)->where('exam_id', $test_id)->where('quiz_type', 'fill-blank')->get();
            $countOption = 0;
            $result = 0;
            foreach($totalFillBlanks as $rows){
                $totalOption = json_decode($rows->answered_text);
                $countOption += count($totalOption);
                $result += $rows->is_correct;
            }

            $question = $totalQuestion + $countOption;
            $marks = $obtainMarks + $result;

            $course_data[] = array(
                'exam_id' =>$test_id,
                'level_title' =>$level->name,
                'category_title' =>$category->name,
                'exam_title' =>$exam_title,
                'exam_thumbnail' =>$exam_thumbnail,
                'exam_time' =>$exam_time,
                'exam_total_question' =>$question,
                'exam_total_marks' =>$marks,
                'exam_finishing_time'=>$exam_last_finshing_time,
            );

        }
        
       $submitted_mock = MockSubmissionLog::where('user_id', $user_id)->get();
     
       $mock = [];
       foreach($submitted_mock as $rows){
        $submitted_mock_id = $rows->mock_id;
        $mock = Mock::where('id', $submitted_mock_id)->get();
       }
        return view('frontend.user.dashboard')->with(['mydata'=>$course_data,'meta'=>$data, 'submitted_mock'=>$mock]);

    }
}
