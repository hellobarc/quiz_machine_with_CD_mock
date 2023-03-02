@extends('frontend.layouts.master')
@section('title', 'Mock Module Reading')
@section('main-content')
<!-- main section start -->
@php
    $continute_sl = 1; 
@endphp
<section style="background-color: #ddd;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- content wrapper start -->
                <div class="mock_timer">
                    <div class="d-flex justify-content-center pt-2">
                        <div class="main-text mx-2">
                            <i class="fa-regular fa-clock"></i>
                            </div>
                        <div class="mx-2">
                          <p class="main-text fw-bold" id="countdown"> </p>
                        </div>
                      </div>
                </div>
                <div class="mock_reading_heading">
                    <h2 class="fw-bolder">Reading Passage {{$segment_id}}</h2>
                    @if($segment_id == 1)
                        <p class="main-text">You should spend about 20 minutes on <strong>Questions 1 – 13,</strong>which are based on Reading Passage 1 below.</p>
                    @elseif($segment_id == 2)
                        <p class="main-text">You should spend about 20 minutes on <strong>Questions 14 – 26,</strong>which are based on Reading Passage 2 below.</p>
                    @elseif($segment_id == 2)
                        <p class="main-text">You should spend about 20 minutes on <strong>Questions 27 - 40,</strong>which are based on Reading Passage 3 below.</p>
                    @else
                        <p class="main-text">You should spend about 20 minutes which are based on Reading Passage below.</p>
                    @endif
                </div>
               
                    <div class="mock_reading_passage" id="passage_width">
                        <div class="passage" >
                            <h2 class="fw-bolder">{{$mockPassage->title}}</h2>
                            <p class="main-text">{!!$mockPassage->passage!!}</p>
                        </div>
                        <!-- <div class="gutter gutter-horizontal resizer"  id="dragMe" style="width: 10px;"></div> -->
                        <div class="resizer split" id="dragMe">
                            <img src="{{asset('frontend/image/split.png')}}" alt="" class="gutter">
                        </div>
                        <div class="question">
                            <form action="{{ route('frontend.mock.module.submission') }}" method="post">
                                @csrf
                                <input type="hidden" name="mock_exercise_id" value="{{$mockExerciseId}}">
                                <input type="hidden" name="mock_id" value="{{$mock_id}}">
                                <input type="hidden" name="module_id" value="{{$module_id}}">
                                <input type="hidden" name="segment_id" value="{{$segment_id}}">
                                <input type="hidden" name="count_exercise" value="{{$countExercise}}">
                                @foreach ($data as $items)
                                    @if($items['question_type'] == 'drop-down')
                                        {{-- drop down section start --}}
                                        <div class="question_set_3">
                                            <input type="hidden" name="mock_drop_down_ques_id" value="{{$items['question_id']}}">
                                            <input type="hidden" name="mock_drop_down_question_type" value="{{$items['question_type']}}">
                                            <p>{!!$items['question_instruction']!!}</p>
                                            @if($items['sub-q'] != NULL)
                                                @foreach ($items['sub-q'] as $question)
                                                    <input type="hidden" name="mock_drop_down_sub_ques_id[]" value="{{$question->id}}">
                                                    @php
                                                        $options = json_decode($question->option_text);
                                                    @endphp
                                                    <p class="main-text" id="dropDownId_{{$question->id}}">
                                                        {{$question->text}}
                                                        <select onchange="effect({{$continute_sl}})" name="mock_drop_down_sub_ques_ans[]" id="" class="drop_down_select">
                                                            @foreach( $options as $key=>$option)
                                                                <option value="{{$key}}">{{$option}}</option>
                                                            @endforeach
                                                        </select>
                                                    </p>
                                                    <br>
                                                    @php
                                                        $continute_sl++;
                                                    @endphp
                                                @endforeach
                                            @endif
                                        </div>
                                        {{-- drop down section end --}}
                                    @elseif($items['question_type'] == 'fill-blank')
                                        {{-- fill blanks section start --}}
                                        <div class="question_set_1">
                                            <input type="hidden" name="mock_fillBlank_ques_id[]" value="{{$items['question_id']}}">
                                            <input type="hidden" name="mock_fillBlank_question_type" value="{{$items['question_type']}}">
                                            <p>{!!$items['question_instruction']!!}</p>
                                            <div class="fill_blanks main-text">
                                                @if($items['sub-q'] != NULL)
                                                   
                                                    @foreach ($items['sub-q'] as $question)
                                                        <input type="hidden" name="mock_fillBlank_sub_ques_id[]" value="{{$question->id}}">
                                                        @if($question->is_show == 'yes')
                                                            @php
                                                                $options = json_decode($question->blank_answer);
                                                                shuffle($options);
                                                            @endphp
                                                            <div class="d-flex justify-content-start fw-bold main-text" style="width: 50%;">
                                                                @foreach($options as $option)
                                                                    <p class="mx-2">{{$option}}</p>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                        <div id="fillBlankId_{{$question->id}}">
                                                            @php
                                                                $array_maker = explode("k##",$question->text);
                                                                $arr_count = count($array_maker);
                                                                // echo "<pre>";
                                                                //     print_r($array_maker);
                                                                // echo "</pre>";
                                                            @endphp 
                                                            {{-- @for ( $i=0 ; $i <= $arr_count-1; $i++ ) --}}
                                                                    @foreach($array_maker as $iteration)
                                                                @php
                                                                    $replace_content = "<input type='text' onchange='effect($continute_sl)' name='mock_fillBlank_sub_ques_ans_{$items['question_id']}[]'>";
                                                                @endphp
                                                                    {{-- <p class="main-text"> {!!str_replace('##blan', $replace_content , $array_maker[$i])!!}</p> --}}
                                                                    <p class="main-text"> {!!str_replace('##blan', $replace_content , $iteration)!!}</p>
                                                                @php
                                                                    $continute_sl++ ;
                                                                @endphp
                                                                 @if ($loop->last)
                                                                    @php
                                                                        $continute_sl-- ;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                            
                                                        </div>
                                                        <br>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        {{-- fill blanks section end --}}
                                    @elseif($items['question_type'] == 'radio')
                                        {{-- radio section start --}}
                                        <div class="question_set_3">
                                            <input type="hidden" name="mock_radio_ques_id" value="{{$items['question_id']}}">
                                            <input type="hidden" name="mock_radio_question_type" value="{{$items['question_type']}}">
                                            <p class="main-text">{!!$items['question_instruction']!!}</p>
                                            @if($items['sub-q'] != NULL)
                                                @foreach ($items['sub-q'] as $question)
                                                    <input type="hidden" name="mock_radio_sub_ques_id[]" value="{{$question->id}}">
                                                    @php
                                                        $options = json_decode($question->option_text);
                                                    @endphp
                                                    <div class="accordion" id="accordionExample">
                                                        <div class="accordion-item" id="radioId_{{$question->id}}">
                                                            <h2 class="accordion-header" id="headingOne">
                                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                    {{$question->text}}
                                                                </button>
                                                            </h2>
                                                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                                <div class="accordion-body">
                                                                    @foreach($options as $option)
                                                                        <div class="d-flex my-2">
                                                                            <div class="side-bar-font">
                                                                                <input type="radio" class="check_box" onclick="effect({{$continute_sl}})" name="mock_radio_sub_ques_ans[{{$question->id}}][]" value="{{$loop->index}}">
                                                                            </div>
                                                                            <div class="check_box_font">
                                                                                <span>&nbsp;&nbsp;{{$option}}</span>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php
                                                        $continute_sl++;
                                                    @endphp
                                                @endforeach
                                            @endif
                                        </div> 
                                        {{-- radio section end --}}
                                    @elseif($items['question_type'] == 'multiple-choice')
                                        {{-- multiple choice section start --}}
                                        <div class="question_set_3">
                                            <input type="hidden" name="mock_multiple_ques_id" value="{{$items['question_id']}}">
                                            <input type="hidden" name="mock_multiple_question_type" value="{{$items['question_type']}}">
                                            <p class="main-text">Multiple choice instructions instruction:-{!!$items['question_instruction']!!}</p>
                                            @if($items['sub-q'] != NULL)
                                                @foreach ($items['sub-q'] as $question)
                                                    <input type="hidden" name="mock_multiple_sub_ques_id[]" value="{{$question->id}}">
                                                    @php
                                                        $options = json_decode($question->option_text);
                                                    @endphp
                                                    <div class="questions_radio">
                                                        <p class="check_box_font">{{$question->text}}</p>
                                                        <div class="main-text" id="multipleChoiceId_{{$question->id}}">
                                                            <input type="hidden"  value=""  id="user_multiple_choice_{{$question->id}}" name="mock_multiple_sub_ques_ans[]" >
                                                            @foreach($options as $key=>$option)
                                                                <div  class="mltiple_choice_option option_item{{$question->id}} col-md-8 col-sm-12" id="multipleColorChange_{{$question->id}}{{$key}}" onclick="hitMultipleChoice({{$key}},{{$question->id}}), effect({{$continute_sl}})">{{$option}}</div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @php
                                                        $continute_sl++;
                                                    @endphp
                                                @endforeach
                                            @endif
                                        </div>
                                        {{-- multiple choice section end --}}
                                    @elseif($items['question_type'] == 'heading-matching')
                                        {{-- Heading Matching section start --}}
                                        <div class="question_set_2">
                                            <input type="hidden" name="mock_heading_matching_ques_id" value="{{$items['question_id']}}">
                                            <input type="hidden" name="mock_heading_matching_question_type" value="{{$items['question_type']}}">
                                            <p>{!!$items['question_instruction']!!}</p>
                                            <p class="fw-bold my-3">Drag the heading list from the left to the blanks of your right side.</p>
                                            @if($items['sub-q'] != NULL)
                                                <div class="row">
                                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                                        <div class="heading_matching_box">
                                                            <p class="main-text fw-bold mx-4">List of Heading</p>
                                                                @foreach ($items['sub-q']['q_head'] as $key_heading=>$qhead)
                                                                    <div class="mx-4">
                                                                        <span id="drag_{{$key_heading}}{{$qhead->id}}" draggable="true" ondragstart="drag(event)">{{$key_heading+1}}. {{$qhead->heading_title}}</span>
                                                                    </div>
                                                                    <br>
                                                                @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                                        <div class="fill_blanks main-text">
                                                            @foreach ($items['sub-q']['question'] as $key=>$qq)
                                                                <input type="hidden" name="mock_heading_matching_sub_ques_id[]" value="{{$qq->id}}">
                                                                <p id="headingMatchingId_{{$key}}{{$qq->id}}">
                                                                    {{$qq->text}}
                                                                    <input type="text" id="valDrop_{{$key}}{{$qq->id}}" onchange="effect({{$continute_sl}})" name="mock_heading_matching_sub_question_ans[{{$qq->id}}][]" ondrop="drop(event, {{$key}},{{$qq->id}})" ondragover="allowDrop(event)" value="">
                                                                </p>
                                                                @php
                                                                    $continute_sl++;
                                                                @endphp
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            @endif
                                        </div>
                                        {{-- Heading Matching section end --}}
                                    
                                    @elseif($items['question_type'] == 'single-check')
                                        {{-- Single Check section start --}}
                                        <div class="question_set_3">
                                            <input type="hidden" name="mock_check_ques_id[]" value="{{$items['question_id']}}">
                                            <input type="hidden" name="mock_check_question_type" value="{{$items['question_type']}}">
                                            <p class="main-text">{!!$items['question_instruction']!!}</p>
                                            @if($items['sub-q'] != NULL)
                                                <div class="table_questions">
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            @php
                                                                $count_item =  count($items['sub-q']['q_head']);
                                                                 $heading_id = [];  
                                                            @endphp
                                                            <th></th>
                                                            @foreach ($items['sub-q']['q_head'] as $key_heading=>$qhead)
                                                                <input type="hidden" name="mock_check_sub_ques_heading_id[]" value="{{$qhead->id}}">
                                                                <th>{{$qhead->heading_title}}</th>
                                                            @endforeach
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($items['sub-q']['question'] as $row_item=>$qq)
                                                            <tr>
                                                                <td>{{$qq->text}}</td>
                                                                <input type="hidden"  name="mock_check_sub_ques_ans[{{$qq->id}}][]" value="" id="checked_input_{{$row_item}}">
                                                                @for ($col = 0; $col <$count_item ; $col++)
                                                                    <td id="right_check_{{$col}}_{{$row_item}}" class="empty_box_{{$row_item}}" onclick="addClass({{$col}}, {{$row_item}}), effect({{$continute_sl}})"></td>
                                                                @endfor
                                                            </tr>
                                                            @php
                                                                $continute_sl++;
                                                            @endphp
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
                                        </div>
                                        {{-- Check section end --}}
                                    @elseif($items['question_type'] == 'true-of-nice')
                                        {{-- true of nice section start --}}
                                        <div class="question_set_2">
                                            <input type="hidden" name="mock_t_heading_matching_ques_id" value="{{$items['question_id']}}">
                                            <input type="hidden" name="mock_t_heading_matching_question_type" value="{{$items['question_type']}}">
                                            <p>{!!$items['question_instruction']!!}</p>
                                            @if($items['sub-q'] != NULL)
                                                <div class="row">
                                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                                        <div class="heading_matching_box">
                                                            <p class="main-text fw-bold mx-4">List of Heading</p>
                                                                @foreach ($items['sub-q']['t_head'] as $key_heading=>$qhead)
                                                                    <div class="mx-4">
                                                                           
                                                                        <span id="drag_{{$key_heading}}{{$qhead->id}}" draggable="true" ondragstart="drag(event)">{{$key_heading+1}}. {{$qhead->heading_title}}</span>
                                                                    </div>
                                                                    <br>
                                                                @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                                        <div class="fill_blanks main-text">
                                                            @foreach ($items['sub-q']['t_question'] as $t_key=>$qq)
                                                                
                                                                @php
                                                                //$qq = $items['sub-q']['t_question'];
                                                                    $blank_answer_arr = json_decode($qq->blank_answer);
                                                                    //print_r($blank_answer_arr);
                                                                    $count_blanks_ans_arr = count($blank_answer_arr);
                                                                    //echo $count_blanks_ans_arr;
                                                                @endphp
                                                                <input type="hidden" name="mock_t_heading_matching_sub_ques_id[]" value="{{$qq->id}}">
                                                                <p id="headingMatchingId_{{$qq->id}}">
                                                                    @for($i = 1; $i<=$count_blanks_ans_arr; $i++)
                                                                        <input type="text" id="valDrop_{{$i}}{{$qq->id}}" onchange="effect({{$continute_sl}})" name="mock_heading_matching_true_of_nice_ans[]" ondrop="drop(event, {{$i}},{{$qq->id}})" ondragover="allowDrop(event)" value="">
                                                                        <br>
                                                                        @php
                                                                            $continute_sl++;
                                                                        @endphp
                                                                    @endfor
                                                                </p>
                                                               
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            @endif
                                        </div>
                                        {{-- true of nice section end --}}
                                    @else
                                        <p>nothing</p>
                                    @endif
                                @endforeach
                                <div class="submit_button">
                                    <p>Passage {{$segment_id}}</p>
                                    <div class="next_button">
                                        <button type="submit" class="btn btn-warning btn-sm fw-bold"> Next <i class="fa-solid fa-angle-right"></i></button>
                                        {{-- <a href="{{route('frontend.mock.submission')}}" class="btn btn-warning btn-sm fw-bold">Next <i class="fa-solid fa-angle-right"></i></a> --}}
                                    </div> 
                                </div>
                            </form>
                        </div>
                    </div>
               
                        
                  
                <div class="mock_reading_indicator">
                    {{-- @for($i = 1; $i<=$countExercise; $i++) --}}
                    <h5 class="fw-bolder text-light mx-4">Total Part {{$countExercise}} || Continue Part- {{$segment_id}}</h5>
                        @for($j = 1; $j<=$totalQuestionCount; $j++)
                            <p class="indicator" id="indicator_{{$j}}">{{$j}}</p>
                        @endfor
                    {{-- @endfor --}}
                </div>
                <!-- content wrapper start -->
            </div>
        </div>
        
    </div>
</section>
<!-- main section end -->
@endsection
<script>
    var get_time = "{{$exam_time}}"
    var startingMinutes = 60;
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> --}}
<script src="{{asset('mock/js/question_js.js')}}"></script>
<script>
    
    $(document).ready(function(){ 
        var windowWidth = $(window).width();
        console.log(windowWidth/2); 
        $(".passage").css('width', windowWidth/1.7+"px");
    });
</script>