@extends('frontend.layouts.master')
@section('title', 'Quiz Machine')
@section('main-content')
    <!-- main section start -->
    <section class="home_bannar">
        <div class="container">
            <div class="row">
                @include('frontend.partials.flash-message')
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12"></div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="">
                        <form class="form-inline">
                           <div class="d-flex">
                            <input type="search" class="form-control mr-sm-2" placeholder="Search" aria-label="Search" name="search" id="search">
                            <button class="btn btn-warning my-2 my-sm-0" type="submit" id="search_button"><i class="fa-solid fa-magnifying-glass-plus"></i></button>
                           </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="mt-5">
                        <h1 class="h1_text">Prepare for your English exam</h1>
                        <p class="main-text">Test your English skills with our quick online test!</p>
                    </div>
                    <div class="my-5">
                        <a href="{{route('level.test')}}" class="btn large-button">Assess your level</a>
                    </div>
                </div>
            </div>
            

        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <!-- left-side bar start -->
                <div class="col-xl-3 col-lg-3 col-md-3 col-md-3 col-sm-3 col-xs-3">
                    <div class="home_filter_modal" id="filter_modal">
                        <p><i class="fa-solid fa-filter"></i> Filter</p>
                    </div>
                    <div class="filter_main">
                        <div class="left_side_filter">
                            <div class="d-flex justify-content-between fw-bold navbar-font" style="cursor: pointer">
                                <div><p><i class="fa-solid fa-filter"></i> Filter</p></div>
                                <div><p>Clear All</p></div>
                            </div>

                            <div class="mt-4">
                                <p class="navbar-font">Levels</p>
                            </div>
                            @foreach ($levels as $level)
                                <div class="d-flex">
                                    <div class="side-bar-font d-block">
                                        <input type="checkbox" class="check_box" value="{{$level->id}}" onclick="showExam(this,'level',this.value)">
                                    </div>
                                    <div class="check_box_font mt-2">
                                        <span>{{$level->name}}</span>
                                    </div>
                                </div>
                            @endforeach
                            <div class="filter_empty_div"></div>
                            <div class="mt-4">
                                <p class="navbar-font">Subject</p>
                            </div>
                            @foreach ($categories as $category)
                                <div class="d-flex">
                                    <div class="side-bar-font">
                                        <input type="checkbox" class="check_box" value="{{$category->id}}" onclick="showExam(this,'category',this.value)">
                                    </div>
                                    <div class="check_box_font mt-2">
                                        <span>{{$category->name}}</span>
                                    </div>
                                </div>
                            @endforeach
                            <div class="filter_empty_div"></div>
                            <div class="mt-4">
                                <p class="navbar-font">Time</p>
                            </div>
                            <div class="d-flex">
                                <div class="side-bar-font">
                                    <input type="checkbox" class="check_box" value="" onclick="">
                                </div>
                                <div class="check_box_font mt-2">
                                    <span>10 Minutes</span>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="side-bar-font">
                                    <input type="checkbox" class="check_box" value="" onclick="">
                                </div>
                                <div class="check_box_font mt-2">
                                    <span>25 Minutes</span>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="side-bar-font">
                                    <input type="checkbox" class="check_box" value="" onclick="">
                                </div>
                                <div class="check_box_font mt-2">
                                    <span>50 Minutes</span>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="side-bar-font">
                                    <input type="checkbox" class="check_box" value="" onclick="">
                                </div>
                                <div class="check_box_font mt-2">
                                    <span>100 Minutes</span>
                                </div>
                            </div>
                            <div class="filter_empty_div"></div>
                            <div class="mt-4">
                                <p class="navbar-font">Age</p>
                            </div>
                            <div class="d-flex">
                                <div class="side-bar-font">
                                    <input type="checkbox" class="check_box" value="" onclick="">
                                </div>
                                <div class="check_box_font mt-2">
                                    <span>Kids</span>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="side-bar-font">
                                    <input type="checkbox" class="check_box" value="" onclick="">
                                </div>
                                <div class="check_box_font mt-2">
                                    <span>Junior</span>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="side-bar-font">
                                    <input type="checkbox" class="check_box" value="" onclick="">
                                </div>
                                <div class="check_box_font mt-2">
                                    <span>Adult</span>
                                </div>
                            </div>
                            <div class="filter_empty_div"></div>
                        </div>
                    </div>
                </div>
                <!-- left-side bar end -->
                <div class="col-xl-9 col-lg-9 col-md-9 col-md-9 col-sm-12 col-xs-12">
                    <!-- service section start -->
                    <div class="service">
                        <div class="mt-5">
                            <h3 class="fw-bolder">What would you like to practise today?</h3>
                        </div>
                        {{-- quiz rows start --}}
                        <div class="row" id="exam_grid"></div>
                        {{-- quiz rows end --}}
                        {{-- mock services start --}}
                        <div class="mt-5">
                            <h3 class="fw-bolder">Mock Test</h3>
                        </div>
                        <div class="row">
                            @foreach ($mock as $rows)
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
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
                                            @if(auth()->user())
                                                <a href="{{route('frontend.mock.module.info', $rows->id)}}" class="btn test-start-button">Start Test</a>
                                            @else
                                                <a href="{{route('frontend.mock.authentication', ['mock_id'=>$rows->id])}}" class="btn test-start-button">Start Now</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach 
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="text_right">
                                    <a href="{{route('frontend.mock.category')}}" class="btn btn-success btn-sm">More ></a>
                                </div>
                            </div>
                        </div>
                        {{-- mock services end --}}
                    </div>
                    <!-- service section end -->
                   
                </div>
                {{-- filter modal start --}}
                <div class="modal fade" id="filter-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title fw-bolder" id="exampleModalLabel">Find Out Test</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <div class="left_side_filter">
                                <div class="d-flex justify-content-between fw-bold navbar-font" style="cursor: pointer">
                                    <div><p><i class="fa-solid fa-filter"></i> Filter</p></div>
                                    <div><p>Clear All</p></div>
                                </div>
    
                                <div class="mt-4">
                                    <p class="navbar-font">Levels</p>
                                </div>
                                @foreach ($levels as $level)
                                    <div class="d-flex">
                                        <div class="side-bar-font d-block">
                                            <input type="checkbox" class="check_box" value="{{$level->id}}" onclick="showExam(this,'level',this.value)">
                                        </div>
                                        <div class="check_box_font mt-2">
                                            <span>{{$level->name}}</span>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="filter_empty_div"></div>
                                <div class="mt-4">
                                    <p class="navbar-font">Subject</p>
                                </div>
                                @foreach ($categories as $category)
                                    <div class="d-flex">
                                        <div class="side-bar-font">
                                            <input type="checkbox" class="check_box" value="{{$category->id}}" onclick="showExam(this,'category',this.value)">
                                        </div>
                                        <div class="check_box_font mt-2">
                                            <span>{{$category->name}}</span>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="filter_empty_div"></div>
                                <div class="mt-4">
                                    <p class="navbar-font">Time</p>
                                </div>
                                <div class="d-flex">
                                    <div class="side-bar-font">
                                        <input type="checkbox" class="check_box" value="" onclick="">
                                    </div>
                                    <div class="check_box_font mt-2">
                                        <span>10 Minutes</span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="side-bar-font">
                                        <input type="checkbox" class="check_box" value="" onclick="">
                                    </div>
                                    <div class="check_box_font mt-2">
                                        <span>25 Minutes</span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="side-bar-font">
                                        <input type="checkbox" class="check_box" value="" onclick="">
                                    </div>
                                    <div class="check_box_font mt-2">
                                        <span>50 Minutes</span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="side-bar-font">
                                        <input type="checkbox" class="check_box" value="" onclick="">
                                    </div>
                                    <div class="check_box_font mt-2">
                                        <span>100 Minutes</span>
                                    </div>
                                </div>
                                <div class="filter_empty_div"></div>
                                <div class="mt-4">
                                    <p class="navbar-font">Age</p>
                                </div>
                                <div class="d-flex">
                                    <div class="side-bar-font">
                                        <input type="checkbox" class="check_box" value="" onclick="">
                                    </div>
                                    <div class="check_box_font mt-2">
                                        <span>Kids</span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="side-bar-font">
                                        <input type="checkbox" class="check_box" value="" onclick="">
                                    </div>
                                    <div class="check_box_font mt-2">
                                        <span>Junior</span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="side-bar-font">
                                        <input type="checkbox" class="check_box" value="" onclick="">
                                    </div>
                                    <div class="check_box_font mt-2">
                                        <span>Adult</span>
                                    </div>
                                </div>
                                <div class="filter_empty_div"></div>
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
                {{-- filter modal end --}}
            </div>
        </div>
    </section>
    <!-- main section end -->
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        dataLoad(filter_type=null, filter_id = null);
    });


    function dataLoad(filter_var=null){

        $.ajax({
                type:'GET',
                url:"{{route('frontend.exam.show')}}",
                data:{"action":"Exam Show","filter_var":filter_var},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data){
                    let list_data =``;
                    $.each(data.data, function(i, item) {
                           list_data += `<div class="col-xl-4 col-lg-4 col-md-4 col-md-4 col-sm-12 col-xs-12">
                                        <div class="test-border">
                                            <div class="exam_img">
                                                <img src="image/uploads/exam/original_thumbnail/${item.thumbnail}" alt="" class="image-size">
                                            </div>
                                            <div class="mt-2">
                                                <h2 class="px-3 py-2">${item.title}</h2>
                                            </div>
                                            <div>
                                                <p class="px-3 main-text"><span class="exam_time">${item.time_limit}</span> Minutes Long Test</p>
                                            </div>
                                            <div>
                                                <p class="px-3 main-text">
                                                    ${item.instruction.substring(0,250)}
                                                </p>
                                            </div>
                                            <div class="pb-4 text-center">
                                                <a href="frontend/exam-info/${item.id}" class="btn test-start-button">Start Test</a>
                                            </div>
                                        </div>
                                    </div> `;

                    });

                    $("#exam_grid").html(list_data);

                },
                error: function(data){
                    console.log(data);
                }
            });
    }

  </script>
  <script>
    var filter_var = [];
    function showExam(event,filter_type,clicked_id){
        if(event.checked){
            filter_var.push({filter_type: filter_type, filter_id: clicked_id});
        }else{
            var index = filter_var.indexOf({filter_type: filter_type, filter_id: clicked_id});
            filter_var.splice(index, 1);
        }
        dataLoad(filter_var);
    }
  </script>

<script>
    $(document).ready(function(){

        $("#search_button").click(function(e){
            e.preventDefault();
            return false;
        });

        $(document).on('keyup', '#search', function(e){
            e.preventDefault();

            let search_string = $('#search').val();

            $.ajax({
                url:"{{ route('frontend.exam.search') }}",
                method:'GET',
                data:{search_string:search_string},
                dataType:'json',
                success:function(data)
                {
                    let list_data =``;
                    $.each(data.data, function(i, item) {
                           list_data += `<div class="col-xl-4 col-lg-4 col-md-4 col-md-4 col-sm-12 col-xs-12">
                                        <div class="test-border">
                                            <div class="exam_img">
                                                <img src="image/uploads/exam/original_thumbnail/${item.thumbnail}" alt="" class="image-size">
                                            </div>
                                            <div class="mt-2">
                                                <h2 class="px-3 py-2">${item.title}</h2>
                                            </div>
                                            <div>
                                                <p class="px-3 main-text"><span class="exam_time">${item.time_limit}</span> Minutes Long Test</p>
                                            </div>
                                            <div>
                                                <p class="px-3 main-text">
                                                    ${item.instruction.substring(250)}
                                                </p>
                                            </div>
                                            <div class="pb-4 text-center">
                                                <a href="frontend/exam-info/${item.id}" class="btn test-start-button">Start Test</a>
                                            </div>
                                        </div>
                                    </div> `;

                    });

                    $("#exam_grid").html(list_data);
                },
                error: function(data){
                    console.log(data);
                }
            });
        });
    });
</script>
<script>
    const rangeInputs = document.querySelectorAll('input[type="range"]')
const numberInput = document.querySelector('input[type="number"]')

function handleInputChange(e) {
  let target = e.target
  if (e.target.type !== 'range') {
    target = document.getElementById('range')
  } 
  const min = target.min
  const max = target.max
  const val = target.value
  
  target.style.backgroundSize = (val - min) * 100 / (max - min) + '% 100%'
}

rangeInputs.forEach(input => {
  input.addEventListener('input', handleInputChange)
})

numberInput.addEventListener('input', handleInputChange)
</script>
<script>
    $(document).ready(function(){



  $("#filter_modal").click(function(){
    $("#filter-modal").modal('show');

  });
});
</script>