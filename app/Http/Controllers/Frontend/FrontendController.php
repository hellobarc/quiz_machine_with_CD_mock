<?php

namespace App\Http\Controllers\Frontend;

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

class FrontendController extends Controller
{
    public function frontendHome()
    {

        $data['meta_title'] = "Home Page";
        $data['meta_description'] = "Home Page";
        $data['bread_chrumb'] = "Home";

        $exams = Exam::get();
        $categories = Category::all();
        $levels = Level::all();
        $mock = Mock::inRandomOrder()->take(3)->get();
        return view('frontend.home', compact('exams', 'categories', 'levels', 'mock'));
    }


    public function frontendJsonExam(Request $request)
    {



        if($request->filter_var!=null){
            // ALGORITHM //
            // 1.
            $level_ids = [];
            $category_ids = [];
            $lavel_search = false;
            $category_search = false;

           // dd($request->filter_var );
            foreach($request->filter_var as $rows){
                $filter_type = $rows['filter_type'];
                $filter_id = $rows['filter_id'];
                $exam_query = Exam::query();
             //  $exam_query->where('level_id',  $filter_id );
                if($filter_type== 'level'){
                    $lavel_search = true;
                    array_push($level_ids,$filter_id);
                }

                if($filter_type== 'category'){
                    $category_search = true;
                    array_push($category_ids,$filter_id);
                }

                if( $lavel_search ){
                    $exam_query->orWhereIn('level_id', $level_ids);
                }

                if( $category_search ){
                    $exam_query->orWhereIn('category_id', $category_ids);
                }


            }


            $exams =  $exam_query->get();
        }else{
            $exams = Exam::get();
        }

        $response = [
            'success' => 200,
          //  'filter_ids' =>   $filter_ids,
            'data' =>$exams,
            // 'check' => $exams,
        ];
        return response()->json($response, 202);
    }
    public function frontendJsonSearch(Request $request)
    {
        $search = $request->search_string;
        //$converstion = implode(" ", $search);
        $searchExam =  Exam::where('title', 'LIKE', "%{$search}%")
        // ->orWhere('short_description', 'LIKE', "%{$search}%")
        // ->orWhere('instruction', 'LIKE', "%{$search}%")
        ->get();
        $response = [
            'success' => 200,
            'data' => $searchExam,
        ];
        return response()->json($response, 202);
    }


    public function frontendExamInfo($test_id)
    {
        $data['meta_title'] = "Home Page";
        $data['meta_description'] = "Home Page";
        $data['bread_chrumb'] = "Home";

        $exams = Exam::where('id', $test_id)->first();
        $quizzes = Quiz::withCount(['multipleChoice'])->where('exam_id', $test_id)->get();
        return view('frontend.test-info', compact('quizzes', 'exams'));
    }
    // segment quiz start
    public function quizSegement1(Request $request, $exam_id, $segment_id)
    {
        $exams = Exam::where('id', $exam_id)->first();
        $quizzes = Quiz::where('exam_id', $exams->id)->get();
        $count_quizzes = count($quizzes);
        $current_time = time();
        if(!(Session::has('exam_session'))){
            $value = $current_time.'.'.rand(1000, 9999);
            Session::put('exam_session', $value);
        }
        
        $getSession = Session::get('exam_session');
        $session_time = explode('.', $getSession);
        
        $exam_time = date("i",($current_time-$session_time[0]));

        if($segment_id <= $count_quizzes ){
            $segment_quiz = $quizzes[$segment_id-1]->id;
            $segment_quiz_type = $quizzes[$segment_id-1]->quiz_type;
            $segment_quiz_templete = $quizzes[$segment_id-1]->templete;
            $segment_quiz_title = $quizzes[$segment_id-1]->title;
            $article = Article::where('quiz_id', $segment_quiz)->get();
            if($segment_quiz_type == 'multiple-choice'){
                $questions = MultipleChoice::where('quiz_id', $segment_quiz)->get();
            }elseif($segment_quiz_type == 'radio'){
                $questions = QuizRadio::where('quiz_id', $segment_quiz)->get();
            }elseif($segment_quiz_type == 'drop-down'){
                $questions = QuizDropdown::where('quiz_id', $segment_quiz)->get();
            }elseif($segment_quiz_type == 'fill-blank'){
                $questions = FillBlank::where('quiz_id', $segment_quiz)->get();
            }

        }else{
            echo "Segment not found";
        }
        //dd($questions);
        return view('frontend.segment_exam', compact('exams','segment_quiz_type', 'questions', 'segment_quiz', 'segment_id', 'count_quizzes', 'segment_quiz_templete', 'article', 'segment_quiz_title', 'exam_time'));

    }
    // segment quiz end
// Exam start // Timer added by Tarique // $test_id is Exam ID
    public function frontendExamStart(Request $request,$test_id)
    {
        $exams = Exam::where('id', $test_id)->with('category')->first();
        $time_limit = $exams->time_limit;
        $time = time();

        $session = $request->session()->get('session');
        $participiant_check = ParticipantLog::where('session', $session)->where('status','started')->latest()->first();

       // dd( $participiant_check);

        if($participiant_check==null){
            $this->startExamSession($request,$test_id);
        }else{
            $participiant_check->start_time;
            $time_different =  $time - $participiant_check->start_time;
            $time_round = round(($time_different / 60));
            $time_limit -=  $time_round;

            if(  $time_round > $time_limit ){
                $this->startExamSession($request,$test_id);
            }

        }
       
            $quizRadio = Quiz::withCount(['quizRadio'])->where('exam_id', $test_id)->where('status', 'active')->where('quiz_type', 'radio')->with('quizRadio')->get();
            $multipleChoice = Quiz::withCount(['multipleChoice'])->where('exam_id', $test_id)->where('status', 'active')->where('quiz_type', 'multiple-choice')->with('multipleChoice')->get();
            $fillBlank = Quiz::where('exam_id', $test_id)->where('status', 'active')->where('quiz_type', 'fill-blank')->with('fillBlank')->get();
            $dropDown = Quiz::withCount(['dropDown'])->where('exam_id', $test_id)->where('status', 'active')->where('quiz_type', 'drop-down')->with('dropDown')->get();
       
      //  dd($quizRadio);
        return view('frontend.start-exam', compact('test_id','exams', 'quizRadio', 'multipleChoice', 'fillBlank', 'dropDown','time_limit'));

    }


    private function startExamSession(Request $request,$test_id){
        $time = time();
        if(Auth::user()){
            $user_id = Auth::user()->id;
        }else{
            $user_id = 0;
        }

        $session = $time .'-'. rand(1000,9999);

        $request->session()->put('start_time',  $time);
        ParticipantLog::create(
                                [
                                    'user_id'=> $user_id,
                                    'exam_id'=>$test_id,
                                    'session'=> $session ,
                                    'start_time'=>$time,
                                    'end_time'=>0,
                                    'status'=>'started'
                                ]
                             );
        $request->session()->put('session', $session);
    }

    private function completeExamSession(Request $request,$test_id){

        $time = time();
        if(Auth::user()){
            $user_id = Auth::user()->id;

            $session = $request->session()->get('session');
            ParticipantLog::where('session',$session)->update(
                                    [
                                        'user_id'=> $user_id,
                                        'end_time'=>$time,
                                        'status'=>'completed'
                                    ]
                                 );
        }

    }



    public function frontendExamChecked(Request $request, $test_id)
    {

        $data['meta_title'] = "Home Page";
        $data['meta_description'] = "Home Page";
        $data['bread_chrumb'] = "Home";

        $user_id = Auth::user()->id;
        $exam_log = ExamLog::where('user_id', $user_id)->where('exam_id',$test_id)->first();

        $exam_log_id = $exam_log->id;
        
        // $test_id = $request->test_id;
        $submittedAns = [];
        $quiz_id = [];
        $exams = Exam::where('id', $test_id)->with('category')->first();
        //if category not equal reading
        if($exams->category != 'Reading'){
        $quizRadio = Quiz::where('exam_id', $test_id)->where('status', 'active')->where('quiz_type', 'radio')->with('quizRadio')->get();
        $multipleChoice = Quiz::where('exam_id', $test_id)->where('status', 'active')->where('quiz_type', 'multiple-choice')->with('multipleChoice')->get();
        $fillBlank = Quiz::where('exam_id', $test_id)->where('status', 'active')->where('quiz_type', 'fill-blank')->with('fillBlank')->get();
        
        $dropDown = Quiz::where('exam_id', $test_id)->where('status', 'active')->where('quiz_type', 'drop-down')->with('dropDown')->get();

        $radioExamSubmission = ExamSubmission::where('exam_log_id', $exam_log_id)->where('exam_id', $test_id)->where('quiz_type', 'radio')->get();
        $multipleChoiceExamSubmission = ExamSubmission::where('exam_log_id', $exam_log_id)->where('exam_id', $test_id)->where('quiz_type', 'multiple-choice')->get();
        $dropDownExamSubmission = ExamSubmission::where('exam_log_id', $exam_log_id)->where('exam_id', $test_id)->where('quiz_type', 'drop-down')->get();
        $fillBlankExamSubmission = ExamSubmission::where('exam_log_id', $exam_log_id)->where('exam_id', $test_id)->where('quiz_type', 'fill-blank')->get();

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
            $countOption = count($totalOption);
            $result = $rows->is_correct;
        }

        $question = $totalQuestion + $countOption;
        $marks = $obtainMarks + $result;

        }


        $this->completeExamSession($request,$test_id);


        //dd($marks);
        return view('frontend.exam-checked', compact('exams', 'quizRadio', 'multipleChoice', 'fillBlank', 'dropDown', 'radioExamSubmission', 'multipleChoiceExamSubmission', 'dropDownExamSubmission', 'fillBlankExamSubmission', 'question', 'marks'));

    }
    public function frontendExamUserAns(Request $request)
    {

        $data['meta_title'] = "Exam x...";
        $data['meta_description'] = "Home Page";
        $data['bread_chrumb'] = "Home";

        $data = $request->input();
       //dd($data);
        $exam_id = $data['exam_id'];
        $segment_quiz_type = $data['segment_quiz_type'];
        $segment_id = $data['segment_id'];
        $count_quiz = $data['count_quizzes'];
        

        if($segment_quiz_type == 'multiple-choice'){
            $multiples = $data['multiple_quiz_id'];
            $multiplesAns = $data['user_multipe_ans'];
            $multipleQuestionId = $data['multiple_question_id'];
            $multiple_quiz_type = $data['multiple_quiz_type'];

            foreach($multiplesAns as $key => $multipleBlanksAns){ // 15 tme
                $question_id = $multipleQuestionId[$key];

                    $allMultipleChoice = MultipleChoice::find($question_id);
                    $quiz_id =$allMultipleChoice->quiz_id;
                    $correct_array = json_decode($allMultipleChoice->is_correct);
                    $question_marks = $allMultipleChoice->marks;
                    if( in_array( $multipleBlanksAns, $correct_array )  ){
                        $iscorrect= 'yes';
                        $obtainMarks = $question_marks;
                    }else{
                        $iscorrect= 'no';
                        $obtainMarks = NULL;
                    }
                    $array = ['quiz_id'=>$quiz_id,'exam_id'=>$exam_id, 'question_id'=> $question_id, 'fillblankans'=> NULL, 'submitted_ans'=>$multipleBlanksAns, 'quiz_type' => $multiple_quiz_type, 'is_correct'=>  $iscorrect, 'obtained_marks' =>$obtainMarks];
                    $this->examCreate($array);

            }
        }elseif($segment_quiz_type == 'radio'){
            $radios_input = $data['radio'] ;
            $radiosAns = $data['radioAns'];
            $radioQuestionId = $data['radio_question_id'];
            $radio_quiz_type = $data['radio_quiz_type'];

            foreach($radiosAns as $quiz_radio_id=>$rAns){ // how many question 
                $submitted_ans_index = $rAns[0]; // Its a seril of Radio button
                $quiz_radio_db = QuizRadio::find($quiz_radio_id);

                $quiz_id            =  $quiz_radio_db->quiz_id;
                $is_correct_arr     = json_decode($quiz_radio_db->is_correct);
                $question_marks = $quiz_radio_db->marks;
                 if( in_array( $submitted_ans_index, $is_correct_arr )  ){
                    $is_correct = "yes";
                    $obtainMarks = $question_marks;
                 }else{
                    $is_correct = "no";
                    $obtainMarks = NULL;
                 }

                 $array = ['quiz_id'=>$quiz_id,'exam_id'=>$exam_id,'question_id'=>$quiz_radio_id, 'fillblankans'=>  NULL, 'submitted_ans'=>$submitted_ans_index, 'quiz_type' => $radio_quiz_type, 'is_correct'=>$is_correct, 'obtained_marks'=>$obtainMarks];
                 $this->examCreate($array);
                
            }
        }elseif($segment_quiz_type == 'drop-down'){
            $dropdowns = $data['dropdown'];
            $dropdownsAns = $data['user_dropDown_ans'];
            $dropdownQuestionId = $data['dropDown_question_id'];
            $dropDown_quiz_type = $data['dropDown_quiz_type'];

            foreach($dropdownsAns as $key=>$values){
                $question_id = $dropdownQuestionId[$key];
                foreach($dropdowns as $index=>$dropdown){


                    $dropDownInfo = QuizDropdown::find($question_id);
                    $correct_array = json_decode($dropDownInfo->is_correct);
                    $question_marks = $dropDownInfo->marks;
                    if($correct_array[0] == $values){
                        $is_correct = 'yes';
                        $obtainMarks = $question_marks;
                    }else{
                        $is_correct = 'no';
                        $obtainMarks = NULL;
                    }
                    $array = ['quiz_id'=>$dropdown,'exam_id'=>$exam_id, 'question_id'=>$question_id, 'fillblankans'=> NULL, 'submitted_ans'=>$values, 'quiz_type' => $dropDown_quiz_type, 'is_correct'=>$is_correct, 'obtained_marks'=> $obtainMarks];
                    $this->examCreate($array);
                }
            }
        }elseif($segment_quiz_type == 'fill-blank'){
            $fillblanks = isset($data['fillblanks'])?$data['fillblanks']:null;
            $fillblankQuestionId = isset($data['fillBlank_question_id'])?$data['fillBlank_question_id']:null;
            $fillBlank_quiz_type = isset($data['fillBlank_quiz_type'])?$data['fillBlank_quiz_type']:null;
            $fillblankArr = $data['user_fillBlank_ans'];
            $fillblankJson = json_encode(isset($data['user_fillBlank_ans'])?$data['user_fillBlank_ans']:null);

            $fill_correct = 0;
            // foreach($fillblanks as $index=>$fillblank){
                // $question_id = $fillblankQuestionId[$index];

                $fillBlankInfo = FillBlank::find($fillblankQuestionId);
                $correct_array = json_decode($fillBlankInfo->blank_answer);
                $question_marks = $fillBlankInfo->marks;
                foreach($correct_array as $key=>$values){
                    if($fillblankArr[$key] == null){
                        echo "Fill the all field";
                    }else{
                        $pos = strpos(" ".strtolower($values),strtolower($fillblankArr[$key]));
                    
                        if($pos!=null)
                        {
                            $fill_correct +=1;
                        }
                    }
                    
                    
                }

                $array = ['quiz_id'=>$fillblanks,'exam_id'=>$exam_id, 'question_id'=>$fillblankQuestionId, 'fillblankans'=> $fillblankJson, 'submitted_ans'=>NULL, 'quiz_type' => $fillBlank_quiz_type, 'is_correct'=>  $fill_correct, 'obtained_marks'=> $fill_correct  ];
                $this->examCreate($array);
            // }
        }
        if($segment_id < $count_quiz){
            return redirect()->route('frontend.exam.start', ['exam_id'=>$exam_id, 'segment_id'=> $segment_id+1]);
        }elseif($segment_id == $count_quiz){
            // $time = time();
            // $user_id = Auth::user()->id;
            // $examLog = ExamLog::UpdateOrCreate(
            //     [
            //         'exam_id'=> $exam_id,
            //     ],
            //     [
            //         'user_id'=> $user_id,
            //         'status'=>'completed',
            //         'exam_finishing_time'=>$time,
            //     ]
            // );
           
            // $deleteSession = session()->forget('exam_session');
            // return redirect()->route('frontend.exam.checked', ['test_id'=>$exam_id]);
            if(Auth::user()){

                return redirect()->route('frontend.exam.result', ['exam_id'=>$exam_id]);
            }else{

                return redirect()->route('frontend.user.authentication', ['exam_id'=>$exam_id]);
            }
        }else{
            echo 'Over ... segment finshied';
        }
    }

    private function examCreate($array)
    {
        //$user_id = Auth::user()->id;
        $getSession = Session::get('exam_session');
        $examLog = ExamLog::firstOrCreate([
            'exam_id'=> $array['exam_id'],
            'session'=>$getSession,
            'status'=>'started',
        ]);
        ExamSubmission::create([
            'exam_log_id'=> $examLog->id,
            'quiz_id'=> $array['quiz_id'],
            'question_id'=> $array['question_id'],
            'quiz_type'=> $array['quiz_type'],
            'exam_id'=>  $array['exam_id'],
            'submitted_ans'=> json_encode($array['submitted_ans']), // ans_id
            'answered_text'=> $array['fillblankans'], // fill ans
            'is_correct'=> $array['is_correct'], // fill ans
            'obtained_marks'=> $array['obtained_marks'], // fill ans
        ]);
    }

    public function result(Request $request, $test_id)
    {
        $data['meta_title'] = "Cong ...";
        $data['meta_description'] = "Home Page";
        $data['bread_chrumb'] = "Home";

        $user_id = Auth::user()->id;

            $time = time();
            
            $examLog = ExamLog::UpdateOrCreate(
                [
                    'exam_id'=> $test_id,
                ],
                [
                    'user_id'=> $user_id,
                    'status'=>'completed',
                    'exam_finishing_time'=>$time,
                ]
            );
           
            $deleteSession = session()->forget('exam_session');

        $exam_loges = ExamLog::where('user_id', $user_id)->first();
        $exam_log_id = $exam_loges->id;
        $exams = Exam::where('id', $test_id)->first();
        //mark calculation

        $quizess = Quiz::where('exam_id', $test_id)->get();
        $totalQuizMarks = 0;
        foreach($quizess as $quiz){
            $quizMarks = $quiz->marks;
            $totalQuizMarks += $quizMarks;
        }
        $obtainMarks = ExamSubmission::where('exam_id', $test_id)->sum('obtained_marks');
        $percentage = ($obtainMarks*100)/$totalQuizMarks;
        $round_percentage = number_format(round($percentage), 0);
        return view('frontend.result', compact('exams', 'totalQuizMarks', 'obtainMarks', 'round_percentage'));
    }

    public function congratulation(Request $request, $test_id)
    {
        $user_id = Auth::user()->id;
        $exam_loges = ExamLog::where('user_id', $user_id)->first();
        $exam_log_id = $exam_loges->id;
        $exam_started_time = explode('.', $exam_loges->session);
        $exam_finishing_time = $exam_loges->exam_finishing_time;
        $exam_time = date("i:s",($exam_finishing_time - $exam_started_time[0]));

        $exams = Exam::where('id', $test_id)->first();
        //correct question calculate
        $total_question_without_fill_blank = ExamSubmission::where('exam_log_id', $exam_log_id)->where('exam_id', $test_id)
                                        ->where('quiz_type', '!=', 'fill-blank')
                                        ->count();
        $correctQuestion = ExamSubmission::where('exam_log_id', $exam_log_id)->where('exam_id', $test_id)
                                        ->where('quiz_type', '!=', 'fill-blank')
                                        ->where('is_correct', '=', 'yes')
                                        ->count();

        //$totalFillBlanksCount = ExamSubmission::where('exam_log_id', 1)->where('exam_id', $test_id)->where('quiz_type', 'fill-blank')->count();
        $totalFillBlanks = ExamSubmission::where('exam_log_id', $exam_log_id)->where('exam_id', $test_id)->where('quiz_type', 'fill-blank')->get();
        $countOption = 0;
        $fillBlanksresult = 0;

        foreach($totalFillBlanks as $rows){
        $totalOption = json_decode($rows->answered_text);
        $countOption += count($totalOption);
        $fillBlanksresult += $rows->is_correct;
        }

        $question = $total_question_without_fill_blank + $countOption;
        $totalCorrectQuestion = $correctQuestion + $fillBlanksresult;
       
        return view('frontend.congratulation', compact('exams', 'question', 'totalCorrectQuestion', 'exam_time'));
    }
    public function checkAuthentication(Request $request)
    {
        if(Auth::check()){
            $check = true;
        }else{
            $check = false;
        }

        $response = [
            'success' => 200,
            'is_login' => $check,
        ];
        return response()->json($response, 202);
    }

    
    
}
