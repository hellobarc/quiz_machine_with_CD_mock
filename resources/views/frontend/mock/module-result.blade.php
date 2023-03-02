@extends('frontend.layouts.master')
@section('title', 'Mock Module Result')
@section('main-content')
    <!-- main section start -->
    <section>
      <div class="container">
         <!-- breadcrumb section start -->
         <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcrumb">
                    <ul>
                        <li>
                            <a href="{{route('frontend.home')}}" class="text-decoration-none text-dark">Home > </a>
                        </li>
                        <li>
                            <a href="#" class="text-decoration-none text-dark"> Mock Info > </a>
                        </li>
                        <li>
                            <a href="#" class="text-decoration-none text-dark"> Instruction ></a>
                        </li>
                        <li>
                            <a href="#" class="text-decoration-none text-dark"> Exam ></a>
                        </li>
                        <li>
                            <a href="#" class="text-decoration-none text-dark"> Result </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- breadcrumb section end -->
          <!-- content wrapper start -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="content">
                    <h2 class="fw-bolder">Your Exam Performance</h2>
                   <h3 class="my-4 text-center">Your Band Score: 
                        <strong>
                            @if ($percentage <= 12.5)
                                2.5
                            @elseif($percentage > 12.5 && $percentage <= 17.5)
                                3.0
                            @elseif($percentage > 17.5 && $percentage <= 22.5)
                                3.5
                            @elseif($percentage > 22.5 && $percentage <= 30)
                                4.0
                            @elseif($percentage > 30 && $percentage <= 35)
                                4.5
                            @elseif($percentage > 35 && $percentage <= 45)
                                5.0
                            @elseif($percentage > 45 && $percentage <= 55)
                                5.5
                            @elseif($percentage > 55 && $percentage <= 65)
                                6.0
                            @elseif($percentage > 65 && $percentage <= 72.5)
                                6.5
                            @elseif($percentage > 72.5 && $percentage <= 80)
                                7.0
                            @elseif($percentage > 80 && $percentage <= 85)
                                7.5
                            @elseif($percentage > 85 && $percentage <= 90)
                                8.0
                            @elseif($percentage > 90 && $percentage <= 95)
                                8.5
                            @elseif($percentage > 95)
                                9.0
                            @else
                                Nothing
                            @endif
                        /9.0
                        </strong>
                    </h3>
                    <div>
                        <div class="progress" style="height: 30px;">
                            <div class="progress-bar bg-warning text-dark fw-bold fs-6" role="progressbar" style="width: {{$percentage}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{$percentage}}% Correct</div>
                          </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="mt-4">
                                <div>
                                    <h2 class="fw-bolder">{{$totalQuestionCount}}</h2>
                                    <p class="text-secondary">Total Questions</p>
                                    <p class="text-secondary">-------------------</p>
                                </div>
                                <div>
                                    <h2 class="fw-bolder">{{$obtainedMarks}}/{{$totalMarksCount}}</h2>
                                    <p class="text-secondary">Marks</p>
                                    <p class="text-secondary">-------------------</p>
                                </div>
                                <div>
                                    <h2 class="fw-bolder">{{$mock_module_time}}</h2>
                                    <p class="text-secondary">Time Taken</p>
                                    <p class="text-secondary">-------------------</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="mt-4">
                                <div>
                                        <h2 class="fw-bolder">{{$totalCorrectQuestions}}</h2>
                                        <p class="text-secondary">Correct</p>
                                        <p class="text-secondary">-------------------</p>
                                </div>
                                <div>
                                        <h2 class="fw-bolder">{{$totalIncorrectQuestions}}</h2>
                                        <p class="text-secondary">Incorrect</p>
                                        <p class="text-secondary">-------------------</p>
                                </div>
                                <div>
                                        <h2 class="fw-bolder">0</h2>
                                        <p class="text-secondary">Unanswerd</p>
                                        <p class="text-secondary">-------------------</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="d-flex justify-content-center my-5">
                                <a href="{{route('frontend.mock.module.info', ['mock_id'=>$mock_id])}}" class="btn btn-primary btn-sm mx-5">Others Modules</a>
                                <a href="{{route('frontend.mock.module.review', ['mock_id'=>$mock_id, 'module_id'=>$module_id, 'segment_id'=>1])}}" class="btn btn-success btn-sm mx-5">Exam Review and Explainations</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h4 class="fw-bolder">How much progress can I make?</h4>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <div class="full_box">
                                <div class="box_header">
                                    <div class="inner_box_top_1" id="activeClass1">
                                        <p class="main-text">0-10 weeks</p>
                                        <h5 class="fw-bolder">Elementary</h5>
                                    </div>
                                </div>
                                <div class="box_bind_class">
                                    <div class="inner_box_middle">
                                        <p>You know a few simple words and phrases, but you have a very small vocabulary and can only communicate basic needs.</p>
                                    </div>
                                    <hr>
                                    <div class="inner_box_bottom">
                                        <p class="fw-bold">Exam levels</p>
                                        <ul>
                                            <li>CEFR A1</li>
                                            <li>TOEFL&reg; 0 - 12</li>
                                            <li>IELTS 3.5 - 4.0</li>
                                            <li>CAMBRIDGE 100 - 120</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <div class="full_box">
                                <div class="box_header">
                                    <div class="inner_box_top_2" id="activeClass2">
                                        <p class="main-text">10-20 weeks</p>
                                        <h5 class="fw-bolder">Lower Intermediate</h5>
                                    </div>
                                </div>
                                <div class="box_bind_class">
                                    <div class="inner_box_middle">
                                        <p>You can participate in simple in simple conversations, read basic texts and write simple notes and letters.</p>
                                    </div>
                                    <hr>
                                    <div class="inner_box_bottom">
                                        <p class="fw-bold">Exam levels</p>
                                        <ul>
                                            <li>CEFR A2</li>
                                            <li>TOEFL&reg; 13 - 36</li>
                                            <li>IELTS 4.0 - 4.5</li>
                                            <li>CAMBRIDGE 120 - 140 KET</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <div class="full_box">
                                <div class="box_header">
                                    <div class="inner_box_top_3" id="activeClass3">
                                        <p class="main-text">20-30 weeks</p>
                                        <h5 class="fw-bolder">Intermediate</h5>
                                    </div>
                                </div>
                                <div class="box_bind_class">
                                    <div class="inner_box_middle">
                                        <p>You can participate in coversations about famillar topics, read longer texts and write simple paragraphs.</p>
                                    </div>
                                    <hr>
                                    <div class="inner_box_bottom">
                                        <p class="fw-bold">Exam levels</p>
                                        <ul>
                                            <li>CEFR B1</li>
                                            <li>TOEFL&reg; 37 - 54</li>
                                            <li>IELTS 4.5 - 5.5</li>
                                            <li>CAMBRIDGE 140 - 160 PET</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <div class="full_box">
                                <div class="box_header">
                                    <div class="inner_box_top_4" id="activeClass4">
                                        <p class="main-text">30-40 weeks</p>
                                        <h5 class="fw-bolder">Advance Intermediate</h5>
                                    </div>
                                </div>
                                <div class="box_bind_class">
                                    <div class="inner_box_middle">
                                        <p>You can participle fully in more complex coversations, read more advancd texts and write a simple essay.</p>
                                    </div>
                                    <hr>
                                    <div class="inner_box_bottom">
                                        <p class="fw-bold">Exam levels</p>
                                        <ul>
                                            <li>CEFR B1</li>
                                            <li>TOEFL&reg; 55 - 74</li>
                                            <li>IELTS 5.5 - 7.0</li>
                                            <li>CAMBRIDGE 160 - 180 FCE</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <div class="full_box">
                                <div class="box_header">
                                    <div class="inner_box_top_5" id="activeClass5">
                                        <p class="main-text">40-50 weeks</p>
                                        <h5 class="fw-bolder">Advance</h5>
                                    </div>
                                </div>
                                <div class="box_bind_class">
                                    <div class="inner_box_middle">
                                        <p>You can handle most social and professional situations, explain complex thoughts fluently and understand the general themes of radio and TV broadcasts.</p>
                                    </div>
                                    <hr>
                                    <div class="inner_box_bottom">
                                        <p class="fw-bold">Exam levels</p>
                                        <ul>
                                            <li>CEFR C1</li>
                                            <li>TOEFL&reg; 75 - 91</li>
                                            <li>IELTS 7.0 - 7.5</li>
                                            <li>CAMBRIDGE 180 - 200 CAE</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <div class="full_box">
                                <div class="box_header">
                                    <div class="inner_box_top_6" id="activeClass6">
                                        <p class="main-text">50-60 weeks</p>
                                        <h5 class="fw-bolder">Proficiency</h5>
                                    </div>
                                </div>
                                <div class="box_bind_class">
                                    <div class="inner_box_middle">
                                        <p>You can read demanding texts and handle long, in-depth discussions. You can understand and express subtle shades of meaning. You are very close to using the language like native speaker.</p>
                                    </div>
                                    <hr>
                                    <div class="inner_box_bottom">
                                        <p class="fw-bold">Exam levels</p>
                                        <ul>
                                            <li>CEFR C2</li>
                                            <li>TOEFL&reg; 92+</li>
                                            <li>IELTS 7.5+</li>
                                            <li>CAMBRIDGE 200 CPE</li>
                                        </ul>
                                    </div>
                                </div>
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
<script>
    var percentage = "{{$percentage}}"
    $(document).ready(function(){
    if(percentage<=40){
        $("#activeClass1").removeClass('inner_box_top_1');
        $("#activeClass1").addClass('inner_box_top_1_another');
    }
    if(percentage>40 && percentage<=50){
        $("#activeClass2").removeClass('inner_box_top_2');
        $("#activeClass2").addClass('inner_box_top_2_another');
    }
    if(percentage>50 && percentage<=60){
        $("#activeClass3").removeClass('inner_box_top_3');
        $("#activeClass3").addClass('inner_box_top_3_another');
    }
    if(percentage>60 && percentage<=70){
        $("#activeClass4").removeClass('inner_box_top_4');
        $("#activeClass4").addClass('inner_box_top_4_another');
    }
    if(percentage>70 && percentage<=80){
        $("#activeClass5").removeClass('inner_box_top_5');
        $("#activeClass5").addClass('inner_box_top_5_another');
    }
    if(percentage>80 ){
        $("#activeClass6").removeClass('inner_box_top_6');
        $("#activeClass6").addClass('inner_box_top_6_another');
    }
        
    });
</script>