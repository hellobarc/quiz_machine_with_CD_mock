@extends('frontend.layouts.master')
@section('title', 'Quiz Questions')
@section('main-content')
    <!-- main section start -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12 mx-auto">
                    <!-- breadcrumb section start -->
                    <div class="breadcrumb">
                        <ul>
                            <li>
                                <a href="{{route('frontend.home')}}" class="text-decoration-none text-dark">Home <i class="fa-solid fa-chevron-right"></i></a>
                            </li>
                            <li>
                                <a href="{{route('frontend.exam.info', $exams->id)}}" class="text-decoration-none text-dark">Test Info 
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            <li><a href="#" class="text-decoration-none text-dark">Quiz </a></li>
                        </ul>
                    </div>
                    <!-- breadcrumb section end -->
                    <!-- content wrapper start -->
                    <div class="content">
                        <div class="">
                            <h2 class="fw-bolder mb-3">{{$exams->title}}</h2>
                            <p>For the questions below, please choose the best option to complete the sentence or conversation.</p>
                            <div class="progress" id="progress_wrapper">
                                @php
                                $progress_bar_percentage = (($segment_id-1)*100)/$count_quizzes;
                                
                                @endphp
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{$progress_bar_percentage}}%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div class="d-flex justify-content-between mt-1">
                                <p>{{round($progress_bar_percentage)}}% completed of 100%</p>
                                <p>{{$segment_id}} set of {{$count_quizzes}}</p>
                            </div>
                            
                            <div style="text-align:right;" id="js_timer">
                                <p id="countdown" class="sub-title mt-2"></p>
                            </div>
                            <form action="{{route('frontend.exam.user.ans')}}" method="POST" enctype="multipart/form-data" id="check_form">
                            @csrf
                            
                            <input type="hidden" name="exam_id" value="{{$exams->id}}">
                            <input type="hidden" name="segment_id" value="{{$segment_id}}">
                            <input type="hidden" name="segment_quiz_type" value="{{$segment_quiz_type}}">
                            <input type="hidden" name="count_quizzes" value="{{$count_quizzes}}">
                                <div>
                                    <h4 class="fw-bolder mb-4">{{$segment_quiz_title}}</h4>
                                </div>
                                @if($segment_quiz_type == 'multiple-choice')
                                    @if($segment_quiz_templete == 'with_passage')
                                        {{-- quiz multiple choice start --}}
                                        {{-- for article start --}}
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                @foreach ($article as $article)
                                                    <div>
                                                        <h2 class="fw-bolder">{{$article->title}}</h2> 
                                                    </div>
                                                    <div>
                                                        <img src="{{asset('image/uploads/article/'.$article->image)}}" alt="" class="image-size">
                                                    </div>
                                                    <div class="article">
                                                        {!!$article->passage !!}
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                @if($questions != NULL)
                                                    <div class="row">
                                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12 mx-auto">
                                                            <input type="hidden" name="multiple_quiz_id" value="{{$segment_quiz}}">
                                                            <input type="hidden" name="multiple_quiz_type" value="{{$segment_quiz_type}}">
                                                            @foreach ($questions as $rows)
                                                                <input type="hidden" name="multiple_question_id[]" value="{{$rows->id}}">
                                                                @php
                                                                    $options = json_decode($rows->option_text);
                                                                @endphp
                                                                <div class="questions_radio">
                                                                    <p class="check_box_font">{{$loop->index+1}}. {{$rows->text}}</p>
                                                                    <div class="main-text">
                                                                        <input type="hidden"  value="" id="user_multiple_choice_{{$rows->id}}" name="user_multipe_ans[]" required>
                                                                        @foreach( $options as $key=>$option)
                                                                            <div  class="mltiple_choice_option option_item{{$rows->id}} col-md-12 col-sm-12" id="multipleColorChange_{{$rows->id}}{{$key}}" onclick="hitMultipleChoice({{$key}},{{$rows->id}}); countSelected(event)">{{$option}}</div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- for article end --}}
                                    @elseif($segment_quiz_templete == 'general')
                                        @if($questions != NULL)
                                            <div class="row">
                                                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                    <input type="hidden" name="multiple_quiz_id" value="{{$segment_quiz}}">
                                                    <input type="hidden" name="multiple_quiz_type" value="{{$segment_quiz_type}}">
                                                    @foreach ($questions as $rows)
                                                        <input type="hidden" name="multiple_question_id[]" value="{{$rows->id}}">
                                                        @php
                                                            $options = json_decode($rows->option_text);
                                                        @endphp
                                                        <div class="questions_radio">
                                                            <p class="check_box_font">{{$loop->index+1}}. {{$rows->text}}</p>
                                                            <div class="main-text">
                                                                <input type="hidden"  value="" id="user_multiple_choice_{{$rows->id}}" name="user_multipe_ans[]" required>
                                                                @foreach( $options as $key=>$option)
                                                                    <div  class="mltiple_choice_option option_item{{$rows->id}} col-md-8 col-sm-12" id="multipleColorChange_{{$rows->id}}{{$key}}" onclick="hitMultipleChoice({{$key}},{{$rows->id}}); countSelected(event)">{{$option}}</div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                    {{-- quiz multiple choice end --}}
                                @elseif($segment_quiz_type == 'radio')
                                    @if($segment_quiz_templete == 'with_passage')
                                        {{-- quiz radio start --}}
                                        {{-- quiz radio article start --}}
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                @foreach ($article as $article)
                                                    <div>
                                                        <h2 class="fw-bolder">{{$article->title}}</h2> 
                                                    </div>
                                                    <div>
                                                        <img src="{{asset('image/uploads/article/'.$article->image)}}" alt="" class="image-size">
                                                    </div>
                                                    <div class="article">
                                                        {!!$article->passage !!}
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                @if($questions != NULL)
                                                    <div class="row">
                                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12 mx-auto">
                                                            <p class="main-text">Choose the correct option</p>
                                                            <input type="hidden" name="radio[]" value="{{$segment_quiz}}">
                                                            <input type="hidden" name="radio_quiz_type" value="{{$segment_quiz_type}}">
                                                            @foreach ($questions as $rows)
                                                                @php
                                                                    // $countRadio = $rows->quiz_radio_count;
                                                                    $big_loop = $loop->index;
                                                                    // $total_question += $countRadio;
                                                                @endphp
                                                                <input type="hidden" name="radio_question_id[]" value="{{$rows->id}}">
                                                                @php
                                                                    $options = json_decode($rows->option_text);
                                                                @endphp
                                                                <div class="questions_radio">
                                                                <p class="check_box_font">{{$loop->index+1}}. {{$rows->text}}</p>
                                                                    @foreach( $options as $option)
                                                                        <div class="d-flex">
                                                                            <div class="side-bar-font">
                                                                                <input type="radio" class="check_box" name="radioAns[{{$rows->id}}][]" value="{{$loop->index}}" onclick="countSelected(event)" required>
                                                                            </div>
                                                                            <div class="check_box_font">
                                                                                <span>{{$option}}</span>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- quiz radio article end --}}
                                    @elseif($segment_quiz_templete == 'general')
                                        @if($questions != NULL)
                                            <div class="row">
                                                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                    <p class="main-text">Choose the correct option</p>
                                                    <input type="hidden" name="radio[]" value="{{$segment_quiz}}">
                                                    <input type="hidden" name="radio_quiz_type" value="{{$segment_quiz_type}}">
                                                    @foreach ($questions as $rows)
                                                        @php
                                                            // $countRadio = $rows->quiz_radio_count;
                                                            $big_loop = $loop->index;
                                                            // $total_question += $countRadio;
                                                        @endphp
                                                        <input type="hidden" name="radio_question_id[]" value="{{$rows->id}}">
                                                        @php
                                                            $options = json_decode($rows->option_text);
                                                        @endphp
                                                        <div class="questions_radio">
                                                        <p class="check_box_font">{{$loop->index+1}}. {{$rows->text}}</p>
                                                            @foreach( $options as $option)
                                                                <div class="d-flex">
                                                                    <div class="side-bar-font">
                                                                        <input type="radio" class="check_box" name="radioAns[{{$rows->id}}][]" value="{{$loop->index}}" onclick="countSelected(event)" required>
                                                                    </div>
                                                                    <div class="check_box_font">
                                                                        <span>{{$option}}</span>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                {{-- quiz radio end --}}
                                @elseif($segment_quiz_type == 'drop-down')
                                    {{-- quiz drop down start --}}
                                    @if($segment_quiz_templete == 'with_passage')
                                        {{-- quiz drop down article start --}}
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                @foreach ($article as $article)
                                                    <div>
                                                        <h2 class="fw-bolder">{{$article->title}}</h2> 
                                                    </div>
                                                    <div>
                                                        <img src="{{asset('image/uploads/article/'.$article->image)}}" alt="" class="image-size">
                                                    </div>
                                                    <div class="article">
                                                        {!!$article->passage !!}
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                @if($questions != NULL)
                                                    <div class="row">
                                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12 mx-auto">
                                                            <p class="main-text">Drop Down</p>
                                                            <input type="hidden" name="dropdown[]" value="{{$segment_quiz}}">
                                                            <input type="hidden" name="dropDown_quiz_type" value="{{$segment_quiz_type}}">
                                                            @foreach ($questions as $rows)
                                                                {{-- @php
                                                                    $countDropDown = $rows->drop_down_count;
                                                                    $total_question +=$countDropDown;
                                                                @endphp --}}
                                                                @php
                                                                    $options = json_decode($rows->option_text);
                                                                @endphp
                                                                <input type="hidden" name="dropDown_question_id[]" value="{{$rows->id}}">
                                                                <div class="questions_radio">
                                                                    <p class="check_box_font">{{$loop->index+1}}. {{$rows->text}}</p>
                                                                    <div class="main-text">
                                                                        <select name="user_dropDown_ans[]" id="" class="drop_down_select" onChange="countSelected(event)" required>
                                                                            @foreach( $options as $key=>$option)
                                                                                <option value="{{$key}}">{{$option}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- quiz drop down article end --}}
                                    @elseif($segment_quiz_templete == 'general')
                                        @if($questions != NULL)
                                            <div class="row">
                                                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                    <p class="main-text">Drop Down</p>
                                                    <input type="hidden" name="dropdown[]" value="{{$segment_quiz}}">
                                                    <input type="hidden" name="dropDown_quiz_type" value="{{$segment_quiz_type}}">
                                                    @foreach ($questions as $rows)
                                                        {{-- @php
                                                            $countDropDown = $rows->drop_down_count;
                                                            $total_question +=$countDropDown;
                                                        @endphp --}}
                                                        @php
                                                            $options = json_decode($rows->option_text);
                                                        @endphp
                                                        <input type="hidden" name="dropDown_question_id[]" value="{{$rows->id}}">
                                                        <div class="questions_radio">
                                                            <p class="check_box_font">{{$loop->index+1}}. {{$rows->text}}</p>
                                                            <div class="main-text">
                                                                <select name="user_dropDown_ans[]" id="" class="drop_down_select" onChange="countSelected(event)" required>
                                                                    @foreach( $options as $key=>$option)
                                                                        <option value="{{$key}}">{{$option}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                    {{-- quiz drop down end --}}
                                @elseif($segment_quiz_type == 'fill-blank')
                                    {{-- quiz fill blank start --}}
                                    {{-- fill blank fill blank article start --}}
                                    @if($segment_quiz_templete == 'with_passage')
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                @foreach ($article as $article)
                                                    <div>
                                                        <h2 class="fw-bolder">{{$article->title}}</h2> 
                                                    </div>
                                                    <div>
                                                        <img src="{{asset('image/uploads/article/'.$article->image)}}" alt="" class="image-size">
                                                    </div>
                                                    <div class="article">
                                                        {!!$article->passage !!}
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                @if($questions != NULL)
                                                    <div class="row">
                                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12 mx-auto">
                                                            <p class="main-text">Fill in the missing words</p>
                                                            <input type="hidden" name="fillblanks[]" value="{{$segment_quiz}}">
                                                            <input type="hidden" name="fillBlank_quiz_type" value="{{$segment_quiz_type}}">
                                                            @foreach ($questions as $rows)
                                                            <input type="hidden" name="fillBlank_question_id[]" value="{{$rows->id}}">
                                                                <div class="fill_blanks main-text">
                                                                    {{-- box show start --}}
                                                                    @if($rows->is_show == 'yes')
                                                                        @php
                                                                            $options = json_decode($rows->blank_answer);
                                                                            shuffle($options);
                                                                        @endphp
                                                                        <div class="d-flex justify-content-start fw-bold main-text" style="width: 50%;">
                                                                            @foreach($options as $option)
                                                                                <p class="mx-2">{{$option}}</p>
                                                                            @endforeach
                                                                        </div>
                                                                    @endif
                                                                    {{-- box show end --}}
                                                                    <p class="">{!!str_replace('##blank##','<input type="text" name="user_fillBlank_ans[]" onchange="countSelected(event)" required>', $rows->text)!!}</p>
                                                                    <br>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- fill blank fill blank article start --}}
                                    @elseif($segment_quiz_templete == 'general')
                                        @if($questions != NULL)
                                            <div class="row">
                                                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                    <p class="main-text">Fill in the missing words</p>
                                                    <input type="hidden" name="fillblanks" value="{{$segment_quiz}}">
                                                    <input type="hidden" name="fillBlank_quiz_type" value="{{$segment_quiz_type}}">
                                                    @foreach ($questions as $rows)
                                                    <input type="hidden" name="fillBlank_question_id" value="{{$rows->id}}">
                                                        <div class="fill_blanks main-text">
                                                            @if($rows->is_show == 'yes')
                                                                @php
                                                                    $options = json_decode($rows->blank_answer);
                                                                    shuffle($options);
                                                                    // $countFillBlank = count($options);
                                                                    // $total_question +=$countFillBlank;
                                                                @endphp
                                                                <div class="d-flex justify-content-start fw-bold main-text" style="width: 50%;">
                                                                    @foreach($options as $option)
                                                                    <p class="mx-2">{{$option}}</p>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                            <p class="">{!!str_replace('##blank##','<input type="text" name="user_fillBlank_ans[]" onchange="countSelected(event)">', $rows->text)!!}</p>
                                                            <br>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                    {{-- quiz fill blank end --}}
                                @endif
                                {{-- @if($segment_id == $count_quizzes)
                                        @if(auth()->user())
                                        <div class="text_right">
                                            <button type="submit" class="btn btn-warning btn-lg fw-bolder">Sumbit <i class="fa-solid fa-angle-right"></i></button>
                                        </div>
                                        @else
                                        <div class="text_right">
                                            <div id="after_login">
                                                <button type="submit" class="btn btn-warning btn-lg fw-bolder" id="checkAuth">login first<i class="fa-solid fa-angle-right"></i></button>
                                            </div>
                                        </div>
                                        @endif
                                    
                                @elseif($segment_id != $count_quizzes) --}}
                                    <div class="text_right">
                                        <button type="submit" class="btn btn-warning btn-lg fw-bolder">Next <i class="fa-solid fa-angle-right"></i></button>
                                    </div>
                                {{-- @else
                                    <p>nothing</p>
                                @endif --}}
                            </form>
                        </div>
                    </div>
                    <!-- content wrapper end --> 
                </div>
            </div>
        </div>
  </section>
 
    <!-- main section end -->
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
    var segment_id =  "{{$segment_id}}";
   
   var total_segment = "{{$count_quizzes}}";
   var get_time = "{{$exam_time}}"
</script>
<script src="{{asset('frontend/js/quiz_view.js')}}"></script>
