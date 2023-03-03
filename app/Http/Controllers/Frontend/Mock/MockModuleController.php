<?php

namespace App\Http\Controllers\Frontend\Mock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mock\{
                        Mock,
                        MockModule,
                        MockExercise,
                        MockPassage,
                        MockAudio,
                        MockQuestion,
                        MockFillBlank,
                        MockDropDown,
                        MockMultipleChoice,
                        MockRadio,
                        MockHeadingMatch,
                        MockHeadingMatchQuestion,
                        MockSubmission,
                        MockSubmissionLog,
                        MockTrueOfNice,
                    };
use Session;
use Auth;
class MockModuleController extends Controller
{
    public function mockCategory()
    {
        $allMock = Mock::all();
        $academicMock = Mock::where('mock_category', 'AC')->get();
        $gTMock = Mock::where('mock_category', 'GT')->get();
        return view('frontend.mock.mock-category', compact('allMock', 'academicMock', 'gTMock'));
    }
    public function moduleInfo($mock_id)
    {
        $user_id = Auth::user()->id;
        $mock = Mock::find($mock_id);
        $mockModule = MockModule::all();
        $submittedModule = MockSubmissionLog::where('user_id', $user_id)->where('mock_id', $mock_id)->get();
        $count_submit_data = count($submittedModule);
        
        return view('frontend.mock.module-info', compact('mock', 'mockModule', 'submittedModule', 'count_submit_data'));
    }
    public function mockAuthentication($mock_id)
    {
        return view('frontend.mock.authentication', compact('mock_id'));
    }
    public function mockModuleInstruction($mock_id, $module_id)
    {
        $mock = Mock::find($mock_id);
        $mockModule = MockModule::find($module_id);
        return view('frontend.mock.module-instruction', compact('mock', 'mockModule'));
    }
    public function mockModule($mock_id, $module_id, $segment_id)
    {
        $mock = Mock::find($mock_id);
        $mockModule = MockModule::find($module_id);
        $mockExercise = MockExercise::where('mock_id', $mock_id)->where('module_id', $module_id)->get();//not submitted exercise yet
        $countExercise = count($mockExercise);
        $totalQuestionCount = 0;
        $current_time = time();
       // $deleteSession = session()->forget('mock_module_session');
        if(!(Session::has('mock_module_session'))){
            $value = $current_time.'.'.rand(1000, 9999);
            Session::put('mock_module_session', $value);
        }

        $getSession = Session::get('mock_module_session');
        $session_time = explode('.', $getSession);
        
        $exam_time = date("i",($current_time-$session_time[0]));

        if($segment_id <= $countExercise){
            $mockExerciseId = $mockExercise[$segment_id-1]->id;
        
           
                $mockQuestions = MockQuestion::where('mock_exercise_id', $mockExerciseId)->get();
                
                foreach($mockQuestions as $question){
                    $question_type = $question->mock_question_type;
                    $question_instruction = $question->question_instruction;
                    $question_id = $question->id;

                    $countMultipleChoice =0;
                    $countRadio =0;
                    $countDropDown = 0;
                    $countHeadingMatchingQuestion = 0;
                    $countSingleCheck = 0;
                    $countFillBlank = 0;
                    $countHeadingMatchingTrueOfNice = 0;

                    $subQ = [];

                    if($question_type == 'fill-blank'){
                        $subQ = MockFillBlank::where('mock_question_id',  $question_id)->get();
                       
                        foreach($subQ as $fillQuestion){
                            //$fillBlankAnswer = json_decode($fillQuestion->blank_answer);
                            $countFillBlank += substr_count(($fillQuestion->text), "##blank##");
                        }
                    }elseif($question_type == 'multiple-choice'){
                        $subQ = MockMultipleChoice::where('mock_question_id',  $question_id)->get();
                        $countMultipleChoice += count($subQ);
                    }elseif($question_type == 'radio'){
                        $subQ = MockRadio::where('mock_question_id',  $question_id)->get();
                        $countRadio+= count($subQ);
                    }elseif($question_type == 'drop-down'){
                        $subQ = MockDropDown::where('mock_question_id',  $question_id)->get();
                        $countDropDown += count($subQ);
                    }elseif($question_type == 'heading-matching' || $question_type == 'single-check'){
                        $mockHeadingMatchSubQuesHeading = MockHeadingMatch::where('mock_question_id',  $question_id)->get();
                        $mockHeadingMatchSubQues = MockHeadingMatchQuestion::where('mock_question_id',  $question_id)->get();
                        $countHeadingMatchingQuestion += count($mockHeadingMatchSubQues);

                        $subQ = [
                                'q_head'=>  $mockHeadingMatchSubQuesHeading, 
                                'question'=>$mockHeadingMatchSubQues
                            ];
                    }elseif($question_type == 'true-of-nice'){
                        $mockTrueOfNiceHeadingMatch = MockHeadingMatch::where('mock_question_id',  $question_id)->get();
                        $mockTrueOfNiceDb = MockTrueOfNice::where('mock_question_id',  $question_id)->get();
                        foreach($mockTrueOfNiceDb as $niceDb){
                            $answers = json_decode($niceDb->blank_answer);
                            $countHeadingMatchingTrueOfNice += count($answers);
                        }

                        $subQ = [
                                't_head'=>  $mockTrueOfNiceHeadingMatch, 
                                't_question'=>$mockTrueOfNiceDb
                            ];
                    }
                    $totalQuestionCount += $countMultipleChoice+$countRadio+$countDropDown+$countHeadingMatchingQuestion+$countSingleCheck+$countFillBlank+$countHeadingMatchingTrueOfNice;
                    $data[] = array(
                        'question_type'=> $question_type,
                        'question_instruction'=> $question_instruction,
                        'question_id'=> $question_id,
                        'sub-q' => $subQ,
                    );
                }
                //dd($totalQuestionCount);
            if(strtolower($mockModule->name) == 'reading'){
                $mockPassage = MockPassage::where('mock_exercise_id', $mockExerciseId)->first();
                return view('frontend.mock.reading.reading-templete', compact('mockPassage','data', 'mockExerciseId', 'mock_id', 'module_id', 'segment_id', 'countExercise', 'totalQuestionCount', 'exam_time'));
            }
            if(strtolower($mockModule->name) == 'listening'){
                $mockAudio = MockAudio::where('mock_exercise_id', $mockExerciseId)->first();
                return view('frontend.mock.listening.listening-templete', compact('mockAudio','data', 'mockExerciseId', 'mock_id', 'module_id', 'segment_id', 'countExercise', 'totalQuestionCount', 'exam_time'));
            }
        }
    }
    
    
    public function mockModuleSubmission(Request $request)
    {
        $data               = $request->input();
        //dd($data);
        $mock_id            = $data['mock_id'];
        $module_id          = $data['module_id'];
        $mock_exercise_id   = $data['mock_exercise_id'];
        $segment_id         = $data['segment_id'];
        $count_exercise     = $data['count_exercise'];
       

        if(isset($data['mock_multiple_question_type'])){
            $mock_multiple_ques_id          = $data['mock_multiple_ques_id'];
            $mock_multiple_sub_ques_id      = $data['mock_multiple_sub_ques_id'];
            $mock_multiple_sub_ques_ans     = $data['mock_multiple_sub_ques_ans'];

            foreach($mock_multiple_sub_ques_ans as $key=>$answer){
                $sub_question_id        = $mock_multiple_sub_ques_id[$key];
                $allMultipleChoice      = MockMultipleChoice::find($sub_question_id);
                $multiple_choice_id     = $allMultipleChoice->mock_question_id;
                $correct_array          = json_decode($allMultipleChoice->is_correct);
                $question_marks         = $allMultipleChoice->marks;

                if( in_array( $answer, $correct_array )  ){
                    $iscorrect      = 'yes';
                    $obtainMarks    = $question_marks;
                }else{
                    $iscorrect      = 'no';
                    $obtainMarks    = 0;
                }
                $array = [
                    'mock_id'               =>$mock_id,
                    'module_id'             =>$module_id, 
                    'mock_exercise_id'      =>$mock_exercise_id, 
                    'mock_question_id'      =>$mock_multiple_ques_id, 
                    'sub_question_id'       =>$sub_question_id,
                    'fillblankans'          =>NULL, 
                    'submitted_ans'         =>$answer, 
                    'mock_question_type'    =>$data['mock_multiple_question_type'], 
                    'is_correct'            =>$iscorrect, 
                    'obtained_marks'        =>$obtainMarks
                ];
                
                $this->mockCreate($array);
            }
        }
        if(isset($data['mock_radio_question_type'])){
            $mock_radio_ques_id          = $data['mock_radio_ques_id'];
            $mock_radio_sub_ques_id      = $data['mock_radio_sub_ques_id'];
            $mock_radio_sub_ques_ans     = $data['mock_radio_sub_ques_ans'];

            foreach($mock_radio_sub_ques_ans as $question_id=>$answer){
                $submitted_ans_index        = $answer[0]; // Its a seril of Radio button
                $radio_db                   = MockRadio::find($question_id);
                $is_correct_arr             = json_decode($radio_db->is_correct);
                $question_marks             = $radio_db->marks;

                 if(in_array($submitted_ans_index, $is_correct_arr)){
                    $is_correct = "yes";
                    $obtainMarks = $question_marks;
                 }else{
                    $is_correct = "no";
                    $obtainMarks = 0;
                 }

                 $array = [
                    'mock_id'               =>$mock_id,
                    'module_id'             =>$module_id, 
                    'mock_exercise_id'      =>$mock_exercise_id, 
                    'mock_question_id'      =>$mock_radio_ques_id, 
                    'sub_question_id'       =>$question_id,
                    'fillblankans'          =>NULL, 
                    'submitted_ans'         =>$submitted_ans_index, 
                    'mock_question_type'    =>$data['mock_radio_question_type'], 
                    'is_correct'            =>$is_correct, 
                    'obtained_marks'        =>$obtainMarks
                ];
                
                $this->mockCreate($array);
            }
        }
        if(isset($data['mock_drop_down_question_type'])){
            $mock_drop_down_ques_id          = $data['mock_drop_down_ques_id'];
            $mock_drop_down_sub_ques_id      = $data['mock_drop_down_sub_ques_id'];
            $mock_drop_down_sub_ques_ans     = $data['mock_drop_down_sub_ques_ans'];

            foreach($mock_drop_down_sub_ques_ans as $key=>$answer){
                $sub_question_id   = $mock_drop_down_sub_ques_id[$key];
                $drop_down_db      = MockDropDown::find($sub_question_id);
                $correct_array     = json_decode($drop_down_db->is_correct);
                $question_marks    = $drop_down_db->marks;

                if( in_array( $answer, $correct_array )  ){
                    $iscorrect      = 'yes';
                    $obtainMarks    = $question_marks;
                }else{
                    $iscorrect      = 'no';
                    $obtainMarks    = 0;
                }
                $array = [
                    'mock_id'               =>$mock_id,
                    'module_id'             =>$module_id, 
                    'mock_exercise_id'      =>$mock_exercise_id, 
                    'mock_question_id'      =>$mock_drop_down_ques_id, 
                    'sub_question_id'       =>$sub_question_id,
                    'fillblankans'          =>NULL, 
                    'submitted_ans'         =>$answer, 
                    'mock_question_type'    =>$data['mock_drop_down_question_type'], 
                    'is_correct'            =>$iscorrect, 
                    'obtained_marks'        =>$obtainMarks
                ];
                
                $this->mockCreate($array);
            }
        }
        if(isset($data['mock_fillBlank_question_type'])){
            $mock_fillBlank_ques_ids          = $data['mock_fillBlank_ques_id'];//question id
            $sub_ques_id                    = $data['mock_fillBlank_sub_ques_id'];//sub ques id

            
            foreach($mock_fillBlank_ques_ids as $question_index=>$question_id){
                $fill_blank_db = MockFillBlank::where('mock_question_id',$question_id)->first();
                $correct_ans_array = json_decode($fill_blank_db->blank_answer);
                $question_marks = $fill_blank_db->marks;
                $ans_name                        = 'mock_fillBlank_sub_ques_ans_'.$question_id;
                $mock_fillBlank_sub_ques_ans     = $data[$ans_name]; //submitted ans
                $fillblankJson                   = json_encode($data[$ans_name]); //store submitted ans
                $fill_correct = 0;
                
                foreach($correct_ans_array as $key=>$correct_ans){
                    $submitted_ans = strtolower($mock_fillBlank_sub_ques_ans[$key]);
                    if(strpos($correct_ans, '/')){
                        $explode_correct_ans = explode('/', $correct_ans);
                        if($submitted_ans == null){
                            echo "Fill the all field";
                        }else{
                            $arr_lowercase = array_map('strtolower', $explode_correct_ans);
                            if(in_array($submitted_ans, $arr_lowercase)){
                                 $fill_correct +=1;
                            }
                        }
                    }else{
                        if($submitted_ans == null){
                            echo "Fill the all field";
                        }else{
                            
                            $strcomp              = strcmp(strtolower(trim($correct_ans, " ")),strtolower(trim($submitted_ans, " ")));
                            if($strcomp == 0){
                                $fill_correct +=1;
                            }

                        }
                    }
                }
                //dd( $arr_lowercase);
                $array = [
                    'mock_id'               =>$mock_id,
                    'module_id'             =>$module_id, 
                    'mock_exercise_id'      =>$mock_exercise_id, 
                    'mock_question_id'      =>$question_id, 
                    'sub_question_id'       =>$sub_ques_id[$question_index],
                    'fillblankans'          =>$fillblankJson, 
                    'submitted_ans'         =>NULL, 
                    'mock_question_type'    =>$data['mock_fillBlank_question_type'], 
                    'is_correct'            =>$fill_correct, 
                    'obtained_marks'        =>$fill_correct
                ];
                
                $this->mockCreate($array);
                    //print_r($correct_ans_array);
            }

        }
        if(isset($data['mock_heading_matching_question_type'])){
            $mock_heading_matching_ques_id          = $data['mock_heading_matching_ques_id'];
            $mock_heading_matching_sub_ques_id      = $data['mock_heading_matching_sub_ques_id'];
            $mock_heading_matching_sub_question_ans     = $data['mock_heading_matching_sub_question_ans'];
            $heading_sub_Ques_Json                   = json_encode($data['mock_heading_matching_sub_question_ans']);

            foreach($mock_heading_matching_sub_question_ans as $question_id=>$answer){
                $submitted_ans_index  = $answer[0];
                $db                   = MockHeadingMatchQuestion::find($question_id);
                $question_marks       = $db->marks;
                $heading_id           = $db->blank_answer;

                $heading_db           = MockHeadingMatch::find($heading_id);
                $heading_title        = $heading_db->heading_title;

                $strcomp              = strcmp($submitted_ans_index,$heading_title);
                 if($strcomp == 0){
                    $is_correct = "yes";
                    $obtainMarks = $question_marks;
                 }else{
                    $is_correct = "no";
                    $obtainMarks = 0;
                 }
                 
                 $array = [
                    'mock_id'               =>$mock_id,
                    'module_id'             =>$module_id, 
                    'mock_exercise_id'      =>$mock_exercise_id, 
                    'mock_question_id'      =>$mock_heading_matching_ques_id, 
                    'sub_question_id'       =>$question_id,
                    'fillblankans'          =>$submitted_ans_index, 
                    'submitted_ans'         =>NULL, 
                    'mock_question_type'    =>$data['mock_heading_matching_question_type'], 
                    'is_correct'            =>$is_correct, 
                    'obtained_marks'        =>$obtainMarks,
                ];
               
                $this->mockCreate($array);
            }

            
           
        }
        if(isset($data['mock_check_question_type'])){
            $mock_check_ques_id          = $data['mock_check_ques_id'];
            $mock_check_sub_ques_ans     = $data['mock_check_sub_ques_ans'];
            $mock_check_sub_ques_heading_id = $data['mock_check_sub_ques_heading_id'];
            
            $i = 1;
            foreach($mock_check_ques_id as $question_id){
                $count_head = MockHeadingMatch::where("mock_question_id",$question_id)->count();
                $head = MockHeadingMatch::where("mock_question_id",$question_id)->get();
                    foreach($mock_check_sub_ques_ans as $sub_question_id => $answer){
                        $submitted_ans_index  = $answer[0];
                        $explode_index = explode(",", $submitted_ans_index);
                        //$valueHead= $count_head-$i;
                        $submitted_title = '';
                        foreach($mock_check_sub_ques_heading_id as $index=>$sub_q_head_id){

                        
                        $i++;
                       
                        if($explode_index[0] == $index){
                            $submitted_title = $head[$index]->heading_title;
                        
                        }

                        $db                   = MockHeadingMatchQuestion::find($sub_question_id);
                        $question_marks       = $db->marks;
                        $heading_id           = $db->blank_answer;

                        $heading_db           = MockHeadingMatch::find($heading_id);
                        $heading_title        = $heading_db->heading_title;
                    }
                        if($submitted_title == $heading_title){
                            $is_correct = "yes";
                            $obtainMarks = $question_marks;
                        }else{
                            $is_correct = "no";
                            $obtainMarks = 0;
                        }
                        
                        $array = [
                            'mock_id'               =>$mock_id,
                            'module_id'             =>$module_id, 
                            'mock_exercise_id'      =>$mock_exercise_id, 
                            'mock_question_id'      =>$question_id, 
                            'sub_question_id'       =>$sub_question_id,
                            'fillblankans'          =>$submitted_title, 
                            'submitted_ans'         =>NULL, 
                            'mock_question_type'    =>$data['mock_check_question_type'], 
                            'is_correct'            =>$is_correct, 
                            'obtained_marks'        =>$obtainMarks,
                        ];
                        $this->mockCreate($array);
                    }
                }
            //dd($count_head);
        }
        if(isset($data['mock_t_heading_matching_question_type'])){
            $heading_question_id          = $data['mock_t_heading_matching_ques_id'];
            $sub_question_id      = $data['mock_t_heading_matching_sub_ques_id'];
            $sub_question_ans     = $data['mock_heading_matching_true_of_nice_ans'];
            $heading_sub_Ques_Json = json_encode($data['mock_heading_matching_true_of_nice_ans']);
            $is_correct = 0;
            
            foreach($sub_question_id as $question_id){
                
                foreach($sub_question_ans as $key=>$answer){
                
                    $db                   = MockTrueOfNice::find($question_id);
                    $question_marks       = $db->marks;
                    $heading_title_arr           = json_decode($db->blank_answer);
                    //print_r(array_map('trim', $heading_title_arr));
                     if(in_array($answer,$heading_title_arr)){
                        $is_correct += 1;
                     }
                }
                 $array = [
                        'mock_id'               =>$mock_id,
                        'module_id'             =>$module_id, 
                        'mock_exercise_id'      =>$mock_exercise_id, 
                        'mock_question_id'      =>$heading_question_id, 
                        'sub_question_id'       =>$question_id,
                        'fillblankans'          =>NULL, 
                        'submitted_ans'         =>$sub_question_ans, 
                        'mock_question_type'    =>$data['mock_t_heading_matching_question_type'], 
                        'is_correct'            =>$is_correct, 
                        'obtained_marks'        =>$is_correct,
                    ];
                
                    $this->mockCreate($array);
            }
        }
        if($segment_id < $count_exercise){
            return redirect()->route('frontend.mock.module', ['mock_id'=>$mock_id, 'module_id'=>$module_id,'segment_id'=> $segment_id+1]);
        }elseif($segment_id == $count_exercise){
            return redirect()->route('frontend.mock.module.result', ['mock_id'=>$mock_id, 'module_id'=>$module_id]);
            //return redirect()->route('frontend.mock.test');
        }else{
            echo 'Over ... segment finshied';
        }
      //return redirect()->back();
    }
    private function mockCreate($array)
    {
        $user_id = Auth::user()->id;
        $getSession = Session::get('mock_module_session');
        $mockSubmissionLog = MockSubmissionLog::firstOrCreate([
            'user_id'       => $user_id,
            'mock_id'       =>$array['mock_id'],
            'module_id'     =>$array['module_id'],
            'session_start' =>$getSession,
            'status'        =>'started',
        ]);
        MockSubmission::create([
            'mock_submission_log_id'    => $mockSubmissionLog->id,
            'mock_question_id'          => $array['mock_question_id'],
            'mock_sub_question_id'      => $array['sub_question_id'],
            'mock_exercise_id'          => $array['mock_exercise_id'],
            'question_type'             => $array['mock_question_type'],
            'answered_text'             => $array['fillblankans'], // fill ans
            'submitted_ans'             => json_encode($array['submitted_ans']), // ans_id
            'is_correct'                => $array['is_correct'], // fill ans
            'obtained_mark'            => $array['obtained_marks'], // fill ans
        ]);
    }
    public function test() {
        dd('ache');
    }
    public function mockModuleResult(Request $request, $mock_id, $module_id)
    {
        //echo('page ache');
        $user_id = Auth::user()->id;

        $time = time();
            
        $examLog = MockSubmissionLog::UpdateOrCreate(
            [
                'mock_id'=> $mock_id,
                'module_id'=> $module_id,
            ],
            [
                'user_id'=> $user_id,
                'status'=>'completed',
                'module_finishing_time'=>$time,
            ]);
           
        $deleteSession = session()->forget('mock_module_session');

        $mockSubmissionLogDB = MockSubmissionLog::where('user_id', $user_id)->where('mock_id', $mock_id)->where('module_id', $module_id)->first();
        $submittedMockModule = $mockSubmissionLogDB->module_id;
        $mockLogId = $mockSubmissionLogDB->id;

        $mock_module_started_time = explode('.', $mockSubmissionLogDB->session_start);
        $mock_module_finishing_time = $mockSubmissionLogDB->module_finishing_time;
        $mock_module_time = date("i:s",($mock_module_finishing_time - $mock_module_started_time[0]));

        $mockExcersieDB = MockExercise::where('module_id', $submittedMockModule)->get();
        $totalQuestionCount = 0;
        $totalMarksCount = 0;

        foreach($mockExcersieDB as $rows){
            $exerciseId = $rows->id;
            $mockQuestionDB = MockQuestion::where('mock_exercise_id', $exerciseId)->get();

            $multipleChoice_marks = 0;
            $radio_marks = 0;
            $dropDown_marks = 0;
            $headingMatching_marks = 0;
            $singleCheck_marks = 0;
            $fillBlank_marks = 0;
            $trueOfNice_marks = 0;
            foreach($mockQuestionDB as $question){
                $questionType = $question->mock_question_type;
                $questionId = $question->id;
             
                $countMultipleChoice =0;
                $countRadio =0;
                $countDropDown = 0;
                $countHeadingMatchingQuestion = 0;
                $countSingleCheck = 0;
                $countFillBlank = 0;
                $countTrueOfNice = 0;

                if($questionType == 'multiple-choice'){
                    $multipleChoiceDB =         MockMultipleChoice::where('mock_question_id', $questionId)->get();
                    $countMultipleChoice += count($multipleChoiceDB);
                    $multipleChoice_marks +=         $multipleChoiceDB->sum('marks');
                    
                }
                elseif($questionType == 'radio'){
                    $radioDB =                  MockRadio::where('mock_question_id', $questionId)->get();
                    $countRadio+= count($radioDB);
                    $radio_marks +=         $radioDB->sum('marks');
                    
                }
                elseif($questionType == 'drop-down'){
                    $dropDownDB =               MockDropDown::where('mock_question_id', $questionId)->get();
                    $countDropDown += count($dropDownDB);
                    $dropDown_marks +=         $dropDownDB->sum('marks');
                    
                }
                elseif($questionType == 'heading-matching'){
                    $headingMatchQuestionDB =   MockHeadingMatchQuestion::where('mock_question_id', $questionId)->get();
                    $countHeadingMatchingQuestion += count($headingMatchQuestionDB);
                    $headingMatching_marks +=         $headingMatchQuestionDB->sum('marks');
                    
                }
                elseif($questionType == 'single-check'){
                    $singleCheckQuestionDB =    MockHeadingMatchQuestion::where('mock_question_id', $questionId)->get();
                    $countSingleCheck += count($singleCheckQuestionDB);
                    $singleCheck_marks +=         $singleCheckQuestionDB->sum('marks');
                    
                }
                elseif($questionType == 'fill-blank'){
                    $fillBlankQuestionDB =      MockFillBlank::where('mock_question_id', $questionId)->get();
                    foreach($fillBlankQuestionDB as $fillQuestion){
                        $fillBlankAnswer = json_decode($fillQuestion->blank_answer);
                        $countFillBlank += count($fillBlankAnswer);
                        $fillBlank_marks +=         $fillBlankQuestionDB->sum('marks');
                    }
                }
                elseif($questionType == 'true-of-nice'){
                    $trueOfNiceQuestionDB = MockTrueOfNice::where('mock_question_id', $questionId)->get();
                    foreach($trueOfNiceQuestionDB as $question){
                        $questionAnswer = json_decode($question->blank_answer);
                        $countTrueOfNice += count($questionAnswer);
                        $trueOfNice_marks +=         $trueOfNiceQuestionDB->sum('marks');
                    }
                }
                
                $totalQuestionCount += $countMultipleChoice+$countRadio+$countDropDown+$countHeadingMatchingQuestion+$countSingleCheck+$countFillBlank+$countTrueOfNice;
                
            }
            $MarksCount = $multipleChoice_marks+$radio_marks+$dropDown_marks+ $headingMatching_marks+$singleCheck_marks+$fillBlank_marks+$trueOfNice_marks;
            $totalMarksCount+=$MarksCount;
        }
       
        $mockSubmissionDB = MockSubmission::where('mock_submission_log_id', $mockLogId)->get();
        $obtainedMarks = MockSubmission::where('mock_submission_log_id', $mockLogId)->sum('obtained_mark');
        $correctQuestions = MockSubmission::where('mock_submission_log_id', $mockLogId)->where('is_correct', '=', 'yes')->where('question_type', '!=', 'fill-blank')->count();
        $correctFillBlank = 0;
        $correctTrueOfNice = 0;
        foreach($mockSubmissionDB as $questionSubmitted){
            //$obtainedMarks = $questionSubmitted->sum('obtained_mark');
            $QuestionType = $questionSubmitted->question_type;
            if($QuestionType == 'fill-blank'){
                $is_correct = $questionSubmitted->is_correct;
                $correctFillBlank+=$is_correct;
            }
            elseif($QuestionType == 'true-of-nice'){
                $is_correct = $questionSubmitted->is_correct;
                $correctTrueOfNice+=$is_correct;
            }
            
        }
        $totalCorrectQuestions = $correctQuestions+$correctFillBlank+$correctTrueOfNice;
        $totalIncorrectQuestions = $totalQuestionCount - $totalCorrectQuestions;
        $percentage = ($obtainedMarks*100)/$totalMarksCount;
        
        return view('frontend.mock.module-result', compact('mock_id','module_id','totalQuestionCount', 'totalCorrectQuestions', 'obtainedMarks', 'totalIncorrectQuestions', 'totalMarksCount', 'percentage', 'mock_module_time'));
    }
    public function mockModuleReview($mock_id, $module_id, $segment_id)
    {
        $mock = Mock::find($mock_id);
        $mockModule = MockModule::find($module_id);
        $mockExercise = MockExercise::where('mock_id', $mock_id)->where('module_id', $module_id)->get();//not submitted exercise yet
        $countExercise = count($mockExercise);
       
        $user_id = Auth::user()->id;
        $mockSubmissionLog = MockSubmissionLog::where('mock_id', $mock_id)->where('module_id', $module_id)->where('user_id', $user_id)->first();
        $mockSubmissionLogId = $mockSubmissionLog->id;

        if($segment_id <= $countExercise){
            $mockExerciseId = $mockExercise[$segment_id-1]->id;
        
            
                
                $mockQuestions = MockQuestion::where('mock_exercise_id', $mockExerciseId)->get();
                
                foreach($mockQuestions as $question){
                    $question_type = $question->mock_question_type;
                    $question_instruction = $question->question_instruction;
                    $question_id = $question->id;
                    

                    $subQ = [];

                    if($question_type == 'fill-blank'){
                        $subQ = MockFillBlank::where('mock_question_id',  $question_id)->get();
                    }elseif($question_type == 'multiple-choice'){
                        $subQ = MockMultipleChoice::where('mock_question_id',  $question_id)->get();
                    }elseif($question_type == 'radio'){
                        $subQ = MockRadio::where('mock_question_id',  $question_id)->get();
                    }elseif($question_type == 'drop-down'){
                        $subQ = MockDropDown::where('mock_question_id',  $question_id)->get();
                    }elseif($question_type == 'heading-matching' || $question_type == 'single-check'){
                        $mockHeadingMatchSubQuesHeading = MockHeadingMatch::where('mock_question_id',  $question_id)->get();
                        $mockHeadingMatchSubQues = MockHeadingMatchQuestion::where('mock_question_id',  $question_id)->with('mockHeadingMatching')->get();

                        $subQ = [
                                'q_head'=>  $mockHeadingMatchSubQuesHeading, 
                                'question'=>$mockHeadingMatchSubQues
                            ];
                    }elseif($question_type == 'true-of-nice'){
                        $mockHeadingMatchSubQuesHeadingTrue = MockHeadingMatch::where('mock_question_id',  $question_id)->get();
                        $mockTrueOfNiceAns = MockTrueOfNice::where('mock_question_id',  $question_id)->get();

                        $subQ = [
                                'q_head_t'=>  $mockHeadingMatchSubQuesHeadingTrue, 
                                't_ans'=>$mockTrueOfNiceAns
                            ];
                    }
                    
                    $mockSubmissionFillBlankDB = MockSubmission::where('mock_submission_log_id', $mockSubmissionLogId)->where('question_type', 'fill-blank')->where('mock_question_id', $question_id)->get();
                    $mockSubmissionMultipleChoiceDB = MockSubmission::where('mock_submission_log_id', $mockSubmissionLogId)->where('question_type', 'multiple-choice')->where('mock_question_id', $question_id)->get();
                    $mockSubmissionRadioDB = MockSubmission::where('mock_submission_log_id', $mockSubmissionLogId)->where('question_type', 'radio')->where('mock_question_id', $question_id)->get();
                    $mockSubmissionDropDownDB = MockSubmission::where('mock_submission_log_id', $mockSubmissionLogId)->where('question_type', 'drop-down')->where('mock_question_id', $question_id)->get();
                    $mockSubmissionHeadingMatchingDB = MockSubmission::where('mock_submission_log_id', $mockSubmissionLogId)->where('question_type', 'heading-matching')->where('mock_question_id', $question_id)->get();
                    $mockSubmissionSingleCheckDB = MockSubmission::where('mock_submission_log_id', $mockSubmissionLogId)->where('question_type', 'single-check')->where('mock_question_id', $question_id)->get(); 
                    $mockSubmissionTrueOfNiceDB = MockSubmission::where('mock_submission_log_id', $mockSubmissionLogId)->where('question_type', 'true-of-nice')->where('mock_question_id', $question_id)->get(); 
                    $data[] = array(
                        'question_type'=> $question_type,
                        'question_instruction'=> $question_instruction,
                        'question_id'=> $question_id,
                        'submitted_fill_blank'=> $mockSubmissionFillBlankDB,
                        'submitted_multiple_choice'=> $mockSubmissionMultipleChoiceDB,
                        'submitted_radio'=> $mockSubmissionRadioDB,
                        'submitted_drop_down'=> $mockSubmissionDropDownDB,
                        'submitted_heading_match'=> $mockSubmissionHeadingMatchingDB,
                        'submitted_single_check'=> $mockSubmissionSingleCheckDB,
                        'submitted_true_of_nice'=> $mockSubmissionTrueOfNiceDB,
                        'sub-q' => $subQ,
                        
                    );
                }
                
                if(strtolower($mockModule->name) == 'reading'){
                    $mockPassage = MockPassage::where('mock_exercise_id', $mockExerciseId)->first();
                    return view('frontend.mock.reading.reading-module-review', compact('mockPassage','data', 'mockExerciseId', 'mock_id', 'module_id', 'segment_id', 'countExercise'));
                }
                if(strtolower($mockModule->name) == 'listening'){
                    $mockAudio = MockAudio::where('mock_exercise_id', $mockExerciseId)->first();
                    return view('frontend.mock.listening.listening-module-review', compact('mockAudio','data', 'mockExerciseId', 'mock_id', 'module_id', 'segment_id', 'countExercise'));
                }
        }
         
    }
}
