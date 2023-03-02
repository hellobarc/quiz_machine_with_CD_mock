@extends('frontend.layouts.master')
@section('title', 'Mock Module Instruction')
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
                            <a href="#" class="text-decoration-none text-dark"> Instruction </a>
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
                    <h2 class="fw-bolder">Instruction</h2>
                    <h3 class="my-4">
                        @if($mock->mock_category == 'AC')
                            IELTS Academic
                        @elseif($mock->mock_category == 'GT')
                            IELTS General Training
                        @endif
                        {{$mockModule->name}}    
                    </h3>
                    <p>
                        Time : 
                        @if (strtolower($mockModule->name) == 'listening')
                            30 minutes
                        @elseif (strtolower($mockModule->name) == 'reading' || strtolower($mockModule->name) == 'writing')
                            1 hour
                        @elseif (strtolower($mockModule->name) == 'speaking')
                            20 minutes
                        @endif
                    </p>
                    <div class="module_insturction">
                        <p>instructions to candidates</p>
                        <ul>
                            <li>Answer all the questions</li>
                            <li>You can change your answers at any time during the test</li>
                        </ul>
                    </div>
                    <div class="module_insturction">
                        <p>information for candidates</p>
                        <ul>
                            <li>There are 40 questions in this test</li>
                            <li>Each question carries one mark</li>
                            <li>The test clock will show you when there are 10 minutes and 5 minutes remaining</li>
                        </ul>
                    </div>
                    @if (strtolower($mockModule->name) == 'listening')
                        <div class="text_sound">
                            <p class="text-center fw-bold">Test Sound</p>
                            
                            

                            <p>Put on your headphones and click on the Play sound button to play a sample sound.</p>
                            <audio id="idAudio">
                                <source src="{{asset('file/01.mp3')}}" type="audio/mpeg">
                            </audio>
                            <div class="my-4 text-center" id="button_holder">
                                <button onclick = "playaudio()" type="button" class="btn btn-success btn-sm fw-bold">Play Audio</button>
                            </div>
                            <p><i class="fa-solid fa-circle-info"></i> If you cannot hear the sound clearly, please tell the invigilator.</p>
                            <div class="volume d-flex justify-content-start">
                                {{-- <div class="volume-indicator"></div> --}}
                                <span><i class="fa-solid fa-volume-high"></i></span>
                                <input class="volume-toggler mx-3 mt-1" min="1" max="100" id='volume_change' type="range" value="50" />
                            </div>
                        </div>
                    @endif
                    <center class="main-text my-5 fw-bold">Do not click 'Continue' until you are told to do so.</center>
                    <div class="text_right">
                        <a href="{{route('frontend.mock.module', ['mock_id'=>$mock->id, 'module_id'=>$mockModule->id, 'segment_id'=>1])}}" class="btn btn-warning fw-bold px-3 py-2">Continue</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- content wrapper end --> 
      </div>
  </section>
    <!-- main section end -->

    <script>
                  
        function playaudio() {
            var a = document.getElementById("idAudio");
            a.play();
           let  button_p = `<button onclick = "pauseaudio()" type="button" class="btn btn-warning btn-sm fw-bold">Pause Audio</button>`;
           const button_holder =  document.getElementById("button_holder");
                 button_holder.innerHTML  = button_p;
        }

        function pauseaudio() {
            var pause_audio = document.getElementById("idAudio");
            pause_audio.pause();
            let button_p = `<button onclick = "playaudio()" type="button" class="btn btn-success btn-sm fw-bold">Play Audio</button>`;
            const button_holder =  document.getElementById("button_holder");
                button_holder.innerHTML  = button_p;
        }
    
    
        const volumeIndicator = document.querySelector('.volume-indicator');
        let volumeToggler = document.querySelector('#volume_change');
    
    
        volumeToggler.addEventListener('input', (e) => {
            var audio = document.getElementById("idAudio");
            const value = e.target.value;
            const volume = value / 100;
            audio.volume = volume;
            volumeIndicator.style.width = value + '%';
        });
    
    </script>
@endsection
