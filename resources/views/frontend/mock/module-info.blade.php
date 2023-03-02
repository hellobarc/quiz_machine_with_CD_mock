@extends('frontend.layouts.master')
@section('title', 'Mock Info')
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
                            <a href="#" class="text-decoration-none text-dark">Mock Info</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- breadcrumb section end -->
          <!-- content wrapper start -->
        <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12 mx-auto">
                <div class="content">
                    <h2 class="fw-bolder mb-3">{{$mock->mock_name}}</h2>
                    <p class="main-text">{{$mock->description}}</p>
                    <p class="sub-title">About Test</p>
                    <!-- quiz content collapse start-->
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                          <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed main-text fw-bold collapse_color" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                              <span class="mx-3"><i class="fa-solid fa-list-ul"></i> </span>  Instruction
                            </button>
                          </h2>
                          <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                              {{$mock->instruction}}
                            </div>
                          </div>
                        </div>
                    </div>
                    <!-- quiz content collapse end-->
                    <p class="sub-title mt-4">Modules</p>
                    <!--Module start -->
                    @foreach ($mockModule as $rows)
                        <div class="modules_list">
                            <div class="d-flex">
                                <div class="main-text">
                                    @if(strtolower($rows->name) == 'listening')
                                        <i class="fa-solid fa-headphones-simple"></i>
                                    @elseif(strtolower($rows->name) == 'reading')
                                        <i class="fa-solid fa-book-open"></i>
                                    @elseif(strtolower($rows->name) == 'writing')
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    @elseif(strtolower($rows->name) == 'speaking')
                                        <i class="fa-solid fa-microphone"></i>
                                    @endif
                                </div>
                                <div class="mx-3">
                                <p class="main-text fw-bold">{{$rows->name}}</p>
                                </div>
                            </div>
                            <div>
                                @if($count_submit_data !== 0)
                                    @foreach ($submittedModule as $items)
                                        @if($rows->id == $items->module_id)
                                            <a href="{{route('frontend.mock.module.result', ['mock_id'=>$mock->id, 'module_id'=>$rows->id])}}" class="btn btn-success btn-sm fw-bold">View Result</a>
                                        @elseif($rows->id !== $items->module_id)
                                            <a href="{{route('frontend.mock.module.instruction', ['mock_id'=>$mock->id, 'module_id'=>$rows->id])}}" class="btn btn-warning btn-sm fw-bold">Start Now</a>
                                        @endif
                                    @endforeach
                                @elseif($count_submit_data == 0)
                                    <a href="{{route('frontend.mock.module.instruction', ['mock_id'=>$mock->id, 'module_id'=>$rows->id])}}" class="btn btn-warning btn-sm fw-bold">Start Now</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    <!-- Module end -->
                </div>
            </div>
        </div>
        <!-- content wrapper end --> 
      </div>
  </section>
    <!-- main section end -->
@endsection
