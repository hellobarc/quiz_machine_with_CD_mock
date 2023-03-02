@extends('frontend.layouts.master')
@section('title', 'Mock Category')
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
                            <a href="{{route('frontend.home')}}" class="text-decoration-none text-dark">Home ></a>
                        </li>
                        <li>
                            <a href="#" class="text-decoration-none text-dark">Mock Category</a>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </div>
        <!-- breadcrumb section end -->
          <!-- content wrapper start -->
          <div class="content">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="">
                        <h2 class="fw-bolder mb-3">All Mock</h2>
                    </div>
                    <div class="mock_category_list">
                        <ul>
                            <li id="all_mock">ALL</li>
                            <li id="academic">Academic</li>
                            <li id="gt">General Training</li>
                            <li id="writing_assess">Writing Assessment</li>
                            <li id="speaking_assess">Speaking Assessment</li>
                        </ul>
                    </div>
                    <div class="mock_all">
                        @foreach ($allMock as $rows)
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <div class="test-border">
                                        <div>
                                            <img src="{{asset('image/uploads/mock/thumbnail/'.$rows->thumbnail)}}" alt="" class="image-size">
                                        </div>
                                        <div class="mt-2">
                                            <h2 class="px-3 py-2">{{$rows->mock_name}}</h2>
                                        </div>
                                        <div>
                                            <p class="px-3 main-text">{{$rows->description}}</p>
                                        </div>
                                        <div class="pb-4 text-center">
                                            <a href="{{route('frontend.mock.module.info', $rows->id)}}" class="btn test-start-button">Start Test</a> 
                                        </div>
                                    </div>
                                </div>
                            @endforeach 
                    </div>
                    <div class="mock_academic">
                        @foreach ($academicMock as $rows)
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <div class="test-border">
                                        <div>
                                            <img src="{{asset('image/uploads/mock/thumbnail/'.$rows->thumbnail)}}" alt="" class="image-size">
                                        </div>
                                        <div class="mt-2">
                                            <h2 class="px-3 py-2">{{$rows->mock_name}}</h2>
                                        </div>
                                        <div>
                                            <p class="px-3 main-text">{{$rows->description}}</p>
                                        </div>
                                        <div class="pb-4 text-center">
                                            <a href="{{route('frontend.mock.module.info', $rows->id)}}" class="btn test-start-button">Start Test</a> 
                                        </div>
                                    </div>
                                </div>
                        @endforeach 
                    </div>
                    <div class="mock_gt">
                        @foreach ($gTMock as $rows)
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <div class="test-border">
                                        <div>
                                            <img src="{{asset('image/uploads/mock/thumbnail/'.$rows->thumbnail)}}" alt="" class="image-size">
                                        </div>
                                        <div class="mt-2">
                                            <h2 class="px-3 py-2">{{$rows->mock_name}}</h2>
                                        </div>
                                        <div>
                                            <p class="px-3 main-text">{{$rows->description}}</p>
                                        </div>
                                        <div class="pb-4 text-center">
                                            <a href="{{route('frontend.mock.module.info', $rows->id)}}" class="btn test-start-button">Start Test</a> 
                                        </div>
                                    </div>
                                </div>
                        @endforeach 
                    </div>
                    <div class="mock_writing_assess">
                        <p>writing</p>
                    </div>
                    <div class="mock_speaking_assess">
                        <p>speaking</p>
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
    $(document).ready(function(){
        $(".mock_academic").hide();
        $(".mock_gt").hide();
        $(".mock_writing_assess").hide();
        $(".mock_speaking_assess").hide();
        $("#all_mock").addClass('authentication_list_li_active');
        $("#academic").click(function(){
            $(".mock_all").hide();
            $(".mock_academic").show();
            $(".mock_gt").hide();
            $(".mock_writing_assess").hide();
            $(".mock_speaking_assess").hide();
            $("#all_mock").removeClass('authentication_list_li_active');
            $("#academic").addClass('authentication_list_li_active');
            $("#gt").removeClass('authentication_list_li_active');
            $("#writing_assess").removeClass('authentication_list_li_active');
            $("#speaking_assess").removeClass('authentication_list_li_active');
        });
        $("#gt").click(function(){
            $(".mock_all").hide();
            $(".mock_academic").hide();
            $(".mock_gt").show();
            $(".mock_writing_assess").hide();
            $(".mock_speaking_assess").hide();
            $("#all_mock").removeClass('authentication_list_li_active');
            $("#academic").removeClass('authentication_list_li_active');
            $("#gt").addClass('authentication_list_li_active');
            $("#writing_assess").removeClass('authentication_list_li_active');
            $("#speaking_assess").removeClass('authentication_list_li_active');
        });
        $("#writing_assess").click(function(){
            $(".mock_all").hide();
            $(".mock_academic").hide();
            $(".mock_gt").hide();
            $(".mock_writing_assess").show();
            $(".mock_speaking_assess").hide();
            $("#all_mock").removeClass('authentication_list_li_active');
            $("#academic").removeClass('authentication_list_li_active');
            $("#gt").removeClass('authentication_list_li_active');
            $("#writing_assess").addClass('authentication_list_li_active');
            $("#speaking_assess").removeClass('authentication_list_li_active');
        });
        $("#speaking_assess").click(function(){
            $(".mock_all").hide();
            $(".mock_academic").hide();
            $(".mock_gt").hide();
            $(".mock_writing_assess").hide();
            $(".mock_speaking_assess").show();
            $("#all_mock").removeClass('authentication_list_li_active');
            $("#academic").removeClass('authentication_list_li_active');
            $("#gt").removeClass('authentication_list_li_active');
            $("#writing_assess").removeClass('authentication_list_li_active');
            $("#speaking_assess").addClass('authentication_list_li_active');
        });
        $("#all_mock").click(function(){
            $(".mock_all").show();
            $(".mock_academic").hide();
            $(".mock_gt").hide();
            $(".mock_writing_assess").hide();
            $(".mock_speaking_assess").hide();
            $("#all_mock").addClass('authentication_list_li_active');
            $("#academic").removeClass('authentication_list_li_active');
            $("#gt").removeClass('authentication_list_li_active');
            $("#writing_assess").removeClass('authentication_list_li_active');
            $("#speaking_assess").removeClass('authentication_list_li_active');
        });
    });
</script>