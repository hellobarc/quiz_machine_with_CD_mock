@extends('frontend.layouts.master')
@section('title', 'Quiz Machine')
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
                            <a href="#" class="text-decoration-none text-dark">Home <i class="fa-solid fa-chevron-right"></i></a>
                        </li>
                        <li>
                            <a href="#" class="text-decoration-none text-dark">Test Info 
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        </li>
                        <li><a href="#" class="text-decoration-none text-dark">Quiz </a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- breadcrumb section end -->
          <!-- content wrapper start -->
          <div class="content">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h5 class="fw-bold">Welcome {{auth()->user()->name}}</h5>
                    
                </div>
            </div>
            <div class="row">
                <h6 class="fw-bold text-center">Your Completed Test</h6>
                @if(!empty($mydata)) 
                    @foreach ($mydata as $items)
                        <div class="col-xl-3 col-lg-3 col-md-3 col-md-4 col-sm-12 col-xs-12">
                            <div class="test-border">
                                <div class="exam_img">
                                    <img src="{{asset('image/uploads/exam/original_thumbnail/'.$items['exam_thumbnail'])}}" alt="" class="image-size">
                                </div>
                                <div class="mt-2">
                                    <h2 class="px-3 py-2">{{$items['exam_title']}}</h2>
                                </div>
                                <div>
                                    <p class="px-3 main-text"><span class="exam_time">{{$items['exam_time']}}</span> Minutes Long Test</p>
                                    <p class="px-3 main-text">Your finishing exam time<span class="exam_time">{{$items['exam_finishing_time']}}</span> Minutes</p>
                                </div>
                                <div>
                                    <p class="px-4 main-text">You have got <strong>{{$items['exam_total_marks']}} out {{$items['exam_total_question']}}</strong> correct answer.</p>
                                </div>
                                <div class="pb-4 text-center">
                                    <a href="#" class="btn test-start-button">Learn more</a> 
                                </div>
                            </div>
                        </div> 
                    @endforeach
                @else
                    <p>You do not have any completed test</p>
                @endif
                
            </div>
            <div class="row">
                <h6 class="fw-bold text-center">Your Completed Mock</h6>
                @if(!empty($submitted_mock))
                    @foreach ($submitted_mock as $rows)
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
                                    <a href="{{route('frontend.user.mock.module.info', $rows->id)}}" class="btn test-start-button">See More ></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>You do not have any completed mock</p>
                @endif
            </div>
        </div>
        <!-- content wrapper end --> 
      </div>
  </section>
    <!-- main section end -->
    
@endsection
