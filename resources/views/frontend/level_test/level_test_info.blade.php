@extends('frontend.layouts.master')
@section('title', 'Quiz Machine')
@section('main-content')
    <!-- main section start -->
    <section>
        <div class="container">
            <div class="row">
                <!-- left-side bar start -->
                
                <!-- left-side bar end -->
                <div class="col-xl-9 col-lg-9 col-md-9 col-md-9 col-sm-12 col-xs-12 mx-auto">
                    <!-- content wrapper start -->
                    <div class="breadcrumb">
                        <ul>
                            <li><a href="#" class="text-decoration-none text-dark">Home <i class="fa-solid fa-chevron-right"></i></a></li>
                            <li><a href="#" class="text-decoration-none text-dark">Test Info </a></li>
                        </ul>
                    </div>
                    <div class="content">
                        <h2 class="fw-bolder">Do you know your level of English?</h2>
                        <p class="main-text">Test your English with our English online test. It’s quick, free and helps you to evaluate your <span class="fw-bold">current English level! </span> You can use the result to help you find content on our website that is appropriate for your English language ability.
                            <p class="main-text">The English test consists of <span class="fw-bold">25 questions</span>. Each question is in the format of multiple choice and you will have a choice of three possible answers. You will be required to read each question carefully and select the answer that you think is correct.</p>
                            <p class="main-text fw-bold">There’s no time limit, so take your time.</p>
                            
                           <p class="main-text"> This language test should take around 10 to 15 minutes, and once it’s done, you’ll receive an instant score that will give you a good idea of your English level. Remember that this online test will give you an approximate indication of your English proficiency level.</p>
                           
                            
                            <p class="main-text fw-bold">About the test:</p>
                            <p class="main-text"><i class="fa-solid fa-check text-warning"></i> 25 multiple-choice questions</p>
                            <p class="main-text"><i class="fa-solid fa-check text-warning"></i> 10 minutes</p>
                            <p class="main-text"><i class="fa-solid fa-check text-warning"></i> Quiz results aligned to CEFR levels</p>
                            <p class="main-text"><i class="fa-solid fa-check text-warning"></i> Share your score on social media</p>
                            <p class="main-text"><i class="fa-solid fa-check text-warning"></i> No fees. No sign ups. Start now!</p>
                            
                            
                               
                        <div class="row">
                            <div class="col-lg-10 col-xl-10 col-md-10 col-sm-12 col-xs-12 mx-auto">
                                <div class="d-flex justify-content-between mb-5">
                                    @foreach ($exams as $exam)
                                        <div>
                                            <p class="fs-3 mt-4 fw-bolder" style="color:#0A369D;">{{$exam->title}}</p>
                                            <div class="content_button_level_test">
                                                <a href="{{route('frontend.exam.start', $exam->id)}}" class="btn btn-warning btn-lg fw-bolder">Start Now</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <p class="main-text fw-bold">Find out if you are a Beginner, Intermediate or Advanced and improve your English with our teachers! We hope you enjoy our online English test. Best of luck!</p>
                            
                        <p class="main-text">This test is designed to assess your understanding of English grammar, vocabulary and phrasing. </p>
                        <p class="main-text">We invite you to take the English Center’s free online English level test. This MacMillan test of grammar and vocabulary has 50 questions with 4 multiple choice answers each. Each correct answer is worth one point. A perfect score of 100% correct answers = 50 points.</p>
                        <p class="main-text">01 - 15 Beginner ...................................A1</p>
                        <p class="main-text">16 - 24 Elementary ..............................A2</p>
                        <p class="main-text">25 - 32 Pre-Intermediate ....................B1</p>
                        <p class="main-text">33 - 39 Intermediate ...........................B2</p>
                        <p class="main-text">40 - 45 Upper Intermediate ...............C1</p>
                         <p class="main-text">46 - 50 Advanced ...............................C2</p>
                         <p>This level test is intended for English speakers at all levels.</p>
                         
                         
                        
                        <!-- Learn for Quiz collapse end -->
                        <!-- quiz content collapse end-->
                    </div>
                    <!-- content wrapper start -->
                </div>
            </div>

        </div>
    </section>
    <!-- main section end -->
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
