@extends('frontend.layouts.master')
@section('title', 'Quiz Result')
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
                            <a href="{{route('frontend.home')}}" class="text-decoration-none text-dark">Home <i class="fa-solid fa-chevron-right"></i></a>
                        </li>
                        <li>
                            <a href="{{route('frontend.exam.info', $exams->id)}}" class="text-decoration-none text-dark">Test Info 
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-decoration-none text-dark">Quiz <i class="fa-solid fa-chevron-right"></i></a>
                        </li>
                        <li><a href="#" class="text-decoration-none text-dark">result </a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- breadcrumb section end -->
          <!-- content wrapper start -->
            <div class="content">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="text-left">
                            <h1 class="fw-bolder mb-3">Assessment Report</h1>
                            <p class="main-text">Congratulations on completing the english assessment. A more in depth version of this will be used if you take a course at one of our schools.</p>
                            <hr>
                            <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <p class="main-text">Your current English level is</p>
                                        @if($round_percentage<=40)
                                            <h2>Elementary</h2>
                                        @elseif($round_percentage>40 && $round_percentage<=50)
                                            <h2>Lower Intermediate</h2>
                                        @elseif($round_percentage>50 && $round_percentage<=60)
                                            <h2>Intermediate</h2>
                                        @elseif($round_percentage>60 && $round_percentage<=70)
                                            <h2>Higher Intermediate</h2>
                                        @elseif($round_percentage>70 && $round_percentage<=80)
                                            <h2>Advance</h2>
                                        @elseif($round_percentage>80 && $round_percentage<=90)
                                            <h2>Proficiency</h2>
                                        @endif
                                        <p class="main-text">You can write and speak in familiar situation a fair knowledge of grammar, but your vocabulary is limited.</p>
                                        <a href="{{route('frontend.exam.checked', ['test_id'=>$exams->id])}}" class="btn btn-warning text-dark main-text fw-bold">Check your answer</a>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                       <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mx-auto">
                                                <div class="chart_outer_box">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="chart_full_box">
                                                            <div class="chart_header">
                                                                @if($round_percentage<=40)
                                                                    <div class="chart_item_1_active">
                                                                        <img src="{{asset('frontend/image/icon-human.gif')}}" alt="" class="icon_human_1">
                                                                    </div>
                                                                @else
                                                                    <div class="chart_item_1"></div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="chart_full_box">
                                                            <div class="chart_header">
                                                                @if($round_percentage>40 && $round_percentage<=50)
                                                                <div class="chart_item_2_active">
                                                                    <img src="{{asset('frontend/image/icon-human.gif')}}" alt="" class="icon_human_2">
                                                                </div>
                                                                @else
                                                                    <div class="chart_item_2"></div>
                                                                @endif
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="chart_full_box">
                                                            <div class="chart_header">
                                                                @if($round_percentage>50 && $round_percentage<=60)
                                                                    <div class="chart_item_3_active">
                                                                        <img src="{{asset('frontend/image/icon-human.gif')}}" alt="" class="icon_human_3">
                                                                    </div>
                                                                @else
                                                                    <div class="chart_item_3"></div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="chart_full_box">
                                                            <div class="chart_header">
                                                                @if($round_percentage>60 && $round_percentage<=70)
                                                                    <div class="chart_item_4_active">
                                                                        <img src="{{asset('frontend/image/icon-human.gif')}}" alt="" class="icon_human_4">
                                                                    </div>
                                                                    
                                                                @else
                                                                    <div class="chart_item_4"></div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="chart_full_box">
                                                            <div class="chart_header">
                                                                @if($round_percentage>70 && $round_percentage<=80)
                                                                    <div class="chart_item_5_active">
                                                                        <img src="{{asset('frontend/image/icon-human.gif')}}" alt="" class="icon_human_5">
                                                                    </div>
                                                                    
                                                                @else
                                                                    <div class="chart_item_5"></div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="chart_full_box">
                                                            <div class="chart_header">
                                                                @if($round_percentage>80 && $round_percentage<=90)
                                                                    <div class="chart_item_6_active">
                                                                        <img src="{{asset('frontend/image/icon-human.gif')}}" alt="" class="icon_human_6">
                                                                    </div>
                                                                
                                                                @else
                                                                    <div class="chart_item_6"></div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                       </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content mt-3">
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
        <!-- content wrapper end --> 
      </div>
  </section>
    <!-- main section end -->
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    var percentage = "{{$round_percentage}}"
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
    if(percentage>80 && percentage<=90){
        $("#activeClass5").removeClass('inner_box_top_6');
        $("#activeClass5").addClass('inner_box_top_6_another');
    }
        
    });
</script>