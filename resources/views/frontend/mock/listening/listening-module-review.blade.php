@extends('frontend.layouts.master')
@section('title', 'Listening Module Review')
@section('main-content')
    <!-- main section start -->
    <section>
      <div class="container">
         <!-- breadcrumb section start -->
         <div class="row">
            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12 mx-auto">
                <div class="breadcrumb">
                    <ul>
                        <li>
                            <a href="{{route('frontend.home')}}" class="text-decoration-none text-dark">Home ></a>
                        </li>
                        <li>
                            <a href="{{route('frontend.mock.module.info', ['mock_id'=>$mock_id])}}" class="text-decoration-none text-dark"> Mock Info > </a>
                        </li>
                        <li>
                            <a href="#" class="text-decoration-none text-dark"> Instruction ></a>
                        </li>
                        <li>
                            <a href="#" class="text-decoration-none text-dark"> Exam ></a>
                        </li>
                        <li>
                            <a href="{{route('frontend.mock.module.result', ['mock_id'=>$mock_id, 'module_id'=>$module_id])}}" class="text-decoration-none text-dark"> Result ></a>
                        </li>
                        <li>
                            <a href="#" class="text-decoration-none text-dark"> Review</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- breadcrumb section end -->
          <!-- content wrapper start -->
          <div class="row">
              <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12 mx-auto">
          <div class="reading_review">
                    <h3 class="fw-bolder text-light"><i class="fa-solid fa-book-open-reader"></i> Exam Review and Explaination</h3>
                    <div class="question">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>Section {{$segment_id}} Listening track</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <audio controls>
                                            <source src="{{asset('file/uploads/mock-audio/'. $mockAudio->audio)}}" type="audio/mpeg">
                                        </audio>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <input type="hidden" name="mock_exercise_id" value="{{$mockExerciseId}}">
                        <input type="hidden" name="mock_id" value="{{$mock_id}}">
                        <input type="hidden" name="module_id" value="{{$module_id}}">
                        <input type="hidden" name="segment_id" value="{{$segment_id}}">
                        <input type="hidden" name="count_exercise" value="{{$countExercise}}">
                        @php
                            $increment_segment = $segment_id + 1;
                        @endphp
                        @foreach ($data as $items)
                            @if($items['question_type'] == 'fill-blank')
                                {{-- fill blanks section start --}}
                                <div class="question_set_1">
                                    <p>{!!$items['question_instruction']!!}</p>
                                    <div class="fill_blanks main-text">
                                        @if($items['sub-q'] != NULL)
                                            @foreach ($items['sub-q'] as $question)
                                                @if($question->is_show == 'yes')
                                                    @php
                                                        $options = json_decode($question->blank_answer);
                                                        shuffle($options);
                                                        print_r($options);
                                                    @endphp
                                                    <div class="d-flex justify-content-start fw-bold main-text" style="width: 50%;">
                                                        @foreach($options as $option)
                                                            <p class="mx-2">{{$option}}</p>
                                                        @endforeach
                                                    </div>
                                                @endif
                                                @php
                                                    $options = json_decode($question->blank_answer);
                                                    $submitted_ans = json_decode($items['submitted_fill_blank'][$loop->index]['answered_text']);
                                                    
                                                        $raw_content = explode('##blank##',$question->text);
                                                        $processed_content = '';
                                                        foreach ($raw_content as $key => $value) {
                                                            if($key==0 ){
                                                                    $processed_content .=$value;
                                                            }else{
                                                                    $show_ans = '';
                                                                    if(strpos($options[$key-1], '/')){
                                                                        $explode_correct_ans = explode('/', $options[$key-1]);
                                                                        $convert_arr = array_map('strtolower', $explode_correct_ans);
                                                                        if(in_array(strtolower($submitted_ans[$key-1]), $convert_arr)){
                                                                            $show_ans = $submitted_ans[$key-1] . '<i class="fa-solid fa-check right_radio mx-2"></i>';
                                                                        }else{
                                                                        $show_ans = $options[$key-1] . '<i class="fa-solid fa-check right_radio mx-2"></i>';
                                                                    
                                                                            if(strtolower($options[$key-1]) != strtolower($submitted_ans[$key-1])){
                                                                                $show_ans = '<span style="border-bottom: 2px solid red; color:red">'.$submitted_ans[$key-1].'<i class="fa-solid fa-xmark wrong_radio mx-2"></i>'.'</span>'."&emsp; " .$options[$key-1]. '<i class="fa-solid fa-check right_radio mx-2"></i>';
                                                                            }
                                                                        }
                                                                    }else{
                                                                        $show_ans = $options[$key-1] . '<i class="fa-solid fa-check right_radio mx-2"></i>';
                                                                    
                                                                            if(strtolower($options[$key-1]) != strtolower($submitted_ans[$key-1])){
                                                                                $show_ans = '<span style="border-bottom: 2px solid red; color:red">'.$submitted_ans[$key-1].'<i class="fa-solid fa-xmark wrong_radio mx-2"></i>'.'</span>'."&emsp; " .$options[$key-1]. '<i class="fa-solid fa-check right_radio mx-2"></i>';
                                                                            }
                                                                        }

                                                                $processed_content .= '<span>' . '<span style="border-bottom: 2px solid #00c437; color:#00c437">'.$show_ans.'</span>'.' '.    $value .'</span>';

                                                            }
                                                        }
                                                @endphp
                                                    {!!$processed_content!!}
                                                <br>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                {{-- fill blanks section end --}}
                            @elseif($items['question_type'] == 'drop-down')
                                {{-- drop down section start --}}
                                <div class="question_set_3">
                                    <p>{!!$items['question_instruction']!!}</p>
                                    @if($items['sub-q'] != NULL)
                                        @foreach ($items['sub-q'] as $question)
                                            @php
                                                $options = json_decode($question->option_text);
                                                $correct_ans = json_decode($question->is_correct)  ;
                                                $dropDown_submitted_ans = json_decode($items['submitted_drop_down'][$loop->index]['submitted_ans']);
                                                
                                            @endphp
                                            <p class="main-text">
                                                {{$question->text}}
                                                <select name="" id="" class="drop_down_select">
                                                    @foreach( $options as $key=>$option)
                                                        @if( $key == $dropDown_submitted_ans )
                                                            <option selected="selected">{{$option}}</option>
                                                        @else
                                                            <option value="">{{$option}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @foreach( $options as $key=>$option)
                                                    @if($correct_ans[0] != $dropDown_submitted_ans)
                                                        @if($key == $correct_ans[0])
                                                            <span class="right_drop" >{{$option}} <i class="fa-solid fa-check right_radio mx-2"></i></span>
                                                        @endif
                                                    @elseif($correct_ans[0] == $dropDown_submitted_ans)
                                                        <i class="fa-solid fa-check right_radio mx-2"></i>
                                                    @endif
                                                    @endforeach
                                            </p>
                                            <br>
                                        @endforeach
                                    @endif
                                </div>
                                {{-- drop down section end --}}
                            @elseif($items['question_type'] == 'heading-matching')
                                {{-- Heading Matching section start --}}
                                <div class="question_set_2">
                                    <p>{!!$items['question_instruction']!!}</p>
                                    @if($items['sub-q'] != NULL)
                                        <div class="heading_matching_box">
                                            <p class="main-text fw-bold mx-4">List of Heading</p>
                                            <ul>
                                                
                                                @foreach ($items['sub-q']['q_head'] as $key_heading=>$qhead)    
                                                    <li>{{$qhead->heading_title}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="fill_blanks main-text mt-5">
                                            @foreach ($items['sub-q']['question'] as $key=>$qq)
                                                @php
                                                    
                                                    //$answer = $items['sub-q']['q_head'][$loop->index]->heading_title;
                                                    $answer = $qq->mockHeadingMatching->heading_title;
                                                    $submitted_ans = $items['submitted_heading_match'][$loop->index]['answered_text'];
                                                    //print_r($answer);
                                                @endphp
                                                <p>
                                                    {{$qq->text}}
                                                    @if($answer == $submitted_ans)
                                                        <span style="border-bottom: 2px solid #00c437; color:#00c437">{{$submitted_ans}} <i class="fa-solid fa-check right_radio mx-1"></span>
                                                    @else
                                                        <span style="border-bottom: 2px solid red; color:red">{{$submitted_ans}} <i class="fa-solid fa-xmark wrong_radio mx-1"></i></span>
                                                        <span style="border-bottom: 2px solid #00c437; color:#00c437">{{$answer}} <i class="fa-solid fa-check right_radio mx-1"></i></span>
                                                    @endif
                                                    {{-- <input type="text" value="{{$submitted_ans}}"> --}}
                                                </p>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                {{-- Heading Matching section end --}}
                            
                            @elseif($items['question_type'] == 'single-check')
                                {{-- Single Check section start --}}
                                <div class="question_set_3">
                                    <p class="main-text">{!!$items['question_instruction']!!}</p>
                                    @if($items['sub-q'] != NULL)
                                        <div class="table_questions">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    @php
                                                        $count_item =  count($items['sub-q']['q_head']);  
                                                    @endphp
                                                    <th></th>
                                                    @foreach ($items['sub-q']['q_head'] as $key_heading=>$qhead)
                                                        <th>{{$qhead->heading_title}}</th>
                                                    @endforeach
                                                </thead>
                                                <tbody>
                                                    @foreach ($items['sub-q']['question'] as $row_item=>$qq)
                                                    @php
                                                        $options = $qq->blank_answer;
                                                        $heading_question_id = $qq->id;
                                                        $heading_title = $qq->mockHeadingMatching->heading_title;
                                                        $answer = $items['sub-q']['q_head'][$loop->index]->heading_title;
                                                        $heading_id = $items['sub-q']['q_head'][$loop->index]->id;
                                                        $submitted_ans = json_decode($items['submitted_single_check'][$loop->index]['submitted_ans']);
                                                        //$submitted_ans_array = $submitted_ans[$row_item];
                                                        echo "submitted answer";
                                                        print_r($submitted_ans);
                                                        echo "<br>";
                                                        echo "default answer" .$heading_title ;
                                                    @endphp
                                                    <tr>
                                                        <td>{{$qq->text}} <strong class="right_radio">({{$heading_title}})</strong></td>
                                                        @for ($col = 0; $col <$count_item ; $col++)
                                                            <td id="right_td_{{$col}}_{{$row_item}}" class="empty_boxxx_{{$row_item}}">
                                                                @if($options == $heading_id)
                                                                {{-- <i class="fa-solid fa-check right_radio"></i> --}}
                                                                {{-- {{$heading_id}} == {{$heading_question_id}} == {{$options}}  --}}
                                                                
                                                                    
                                                                @endif
                                                            </td>
                                                        @endfor
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                                {{-- Check section end --}}
                            
                            @elseif($items['question_type'] == 'radio')
                                <div class="question_set_3">
                                    <p class="main-text">{!!$items['question_instruction']!!}</p>
                                    @if($items['sub-q'] != NULL)
                                        @foreach ($items['sub-q'] as $question)
                                            @php
                                                $options = json_decode($question->option_text);
                                                $correct_ans = json_decode($question->is_correct);
                                                $submitted_ans = json_decode($items['submitted_radio'][$loop->index]['submitted_ans']);
                                            @endphp
                                            <div class="accordion" id="accordionExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                            {{$question->text}}
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            @foreach($options as $key=>$option)
                                                            <div class="d-flex my-2">
                                                                @if(in_array( $loop->index ,$correct_ans))
                                                                    <div class="side-bar-font">
                                                                        <input type="radio" class="check_box" checked="checked">
                                                                    </div>
                                                                    <div class="check_box_font">
                                                                        <span class="right_radio">
                                                                            {{$option}}
                                                                                <i class="fa-solid fa-check right_radio"></i>
                                                                        </span>
                                                                    </div>
                                                                @else
                                                                    <div class="side-bar-font">
                                                                        <input type="radio" class="check_box">
                                                                    </div>
                                                                    <div class="check_box_font">
                                                                        @if($correct_ans != $submitted_ans[0])
                                                                            @if($key == $submitted_ans[0])
                                                                                <span class="wrong_radio">
                                                                                    {{$option}}
                                                                                        <i class="fa-solid fa-xmark wrong_radio"></i>
                                                                                </span>
                                                                            @else
                                                                                <span class="">
                                                                                    {{$option}}
                
                                                                                </span>
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div> 
                            
                            @elseif($items['question_type'] == 'multiple-choice')
                                <div class="question_set_3">
                                    @if($items['sub-q'] != NULL)
                                        @foreach ($items['sub-q'] as $question)
                                            <input type="hidden" name="mock_multiple_sub_ques_id[]" value="{{$question->id}}">
                                            @php
                                                $options = json_decode($question->option_text);
                                                $correct_ans = json_decode($question->is_correct)  ;
                                                $submitted_ans = json_decode($items['submitted_multiple_choice'][$loop->index]['submitted_ans']);
                                            @endphp
                                            <div class="questions_radio">
                                                <p class="check_box_font">{{$loop->index+1}}. {{$question->text}}</p>
                                                <div class="main-text">
                                                    @foreach( $options as $key=>$option)
                                                        <div class="d-flex">
                                                            @if(in_array( $loop->index ,$correct_ans ))
                                                                <div>
                                                                    <p class="mltiple_choice_option_correct_result ">{{$option}}</p>
                                                                </div>
                                                                <div>
                                                                    <i class="fa-solid fa-check right_radio mx-2"></i>
                                                                </div>
                                                            @else
                                                                <div>
                                                                    @if($correct_ans != $submitted_ans[0])
                                                                        @if($key == $submitted_ans[0])
                                                                            <div class="d-flex">
                                                                                <p class="mltiple_choice_option_wrong">{{$option}}</p>
                                                                                <p class="multiple_choice_cross"><i class="fa-solid fa-xmark"></i></p>
                                                                            </div>
                                                                        @else
                                                                            <p class="mltiple_choice_option_result">{{$option}}</p>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            @elseif($items['question_type'] == 'true-of-nice')
                                {{-- True of Nice section start --}}
                                <div class="question_set_2">
                                    <p>{!!$items['question_instruction']!!}</p>
                                    @if($items['sub-q'] != NULL)
                                        <div class="heading_matching_box">
                                            <p class="main-text fw-bold mx-4">List of Heading</p>
                                            <ul>
                                                
                                                @foreach ($items['sub-q']['q_head_t'] as $key_heading=>$qhead)    
                                                    <li>{{$qhead->heading_title}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="fill_blanks main-text mt-5">
                                            @foreach ($items['sub-q']['t_ans'] as $key=>$qq)
                                                @php
                                                    
                                                    //$answer = $items['sub-q']['q_head'][$loop->index]->heading_title;
                                                    $t_answer = json_decode($qq->blank_answer);
                                                    $submitted_ans_t = json_decode($items['submitted_true_of_nice'][$loop->index]['submitted_ans']);
                                                    $correct_t = ' ';
                                                    foreach ($submitted_ans_t as $user_ans) {
                                                        if(in_array($user_ans, $t_answer)){
                                                                $correct_t .= '<span style="border-bottom: 2px solid #00c437; color:#00c437">'.$user_ans. '<i class="fa-solid fa-check right_radio mx-1">'.'</i>'.'</span>'."<br>";
                                                        }else{
                                                            $correct_t .= '<span style="border-bottom: 2px solid red; color:red">'.$user_ans. '<i class="fa-solid fa-xmark wrong_radio mx-1">'.'</i>'.'</span>'."<br>";
                                                        }
                                                    }
                                
                                                @endphp
                                                <p>
                                                {!!$correct_t!!} 
                                                    {{-- {{$qq->text}}
                                                    @if($answer == $submitted_ans)
                                                        <span style="border-bottom: 2px solid #00c437; color:#00c437">{{$submitted_ans}} <i class="fa-solid fa-check right_radio mx-1"></i></span>
                                                    @else
                                                        <span style="border-bottom: 2px solid red; color:red">{{$submitted_ans}} <i class="fa-solid fa-xmark wrong_radio mx-1"></i></span>
                                                        <span style="border-bottom: 2px solid #00c437; color:#00c437">{{$answer}} <i class="fa-solid fa-check right_radio mx-1"></i></span>
                                                    @endif --}}
                                                    {{-- <input type="text" value="{{$submitted_ans}}"> --}}
                                                </p>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                {{-- True of Nice section end --}}
                            @endif
                        @endforeach
                        <div class="listening_submit_button">
                            <p>Section {{$segment_id}}</p>
                            <div class="mt-2 mx-4">
                                @if($segment_id < $countExercise)
                                    
                                <a href="{{route('frontend.mock.module.review', ['mock_id'=>$mock_id, 'module_id'=>$module_id, 'segment_id'=>$increment_segment])}}" class="btn btn-warning btn-sm fw-bold">Next <i class="fa-solid fa-angle-right"></i></a>
                                @else
                                @endif
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content wrapper end --> 
      </div>
  </section>
    <!-- main section end -->
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="{{asset('mock/js/question_js.js')}}"></script>
<script>
    
    $(document).ready(function(){ 
        var windowWidth = $(window).width();
        console.log(windowWidth/2); 
        $(".passage").css('width', windowWidth/1.7+"px");
    });
</script>