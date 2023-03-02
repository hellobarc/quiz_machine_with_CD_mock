@extends('admin.layouts.master')

@section('title', 'Add Listening')
@section('main-content')
    <!-- Content Wrapper. Contains page content -->
  	<div class="content-wrapper">
		<div class="container-full">
			<!-- Main content -->
			<section class="content">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="card">
							<div class="card-header">
								<div class="box bg-primary-light mb-0">
									<div class="box-body d-flex px-0">
										<div class="flex-grow-1 px-30 flex-grow-1 bg-img dask-bg bg-none-md" style="background-position: right bottom; background-size: auto 100%; background-image: url({{asset('ed_admin/images/svg-icon/color-svg/custom-1.svg')}})">
											<div class="row">
												<div class="col-12 col-xl-7">
													<h3 class="fw-bolder">Add Listening</h3>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12 mx-auto">
                                        {{-- <div class="d-flex justify-content-end mb-3">
                                            <a href="#" class="btn btn-success btn-sm"><i class="fa-solid fa-plus"></i></i> Add Option</a>
                                        </div> --}}
                                        <div>
                                            @include('admin.partials.flash-message')
                                            <form action="{{route('admin.settings.quiz.store-listening')}}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="quiz_id" value="{{$quizId}}">
                                                {{-- <input type="hidden" name="quiz_type" value="{{$quizType}}"> --}}
                                                <div class="form-group">
                                                    <label for="title" class="mb-2">Passage Title</label>
                                                    <input type="text" class="form-control" name="title" placeholder="Write passage title">
                                                </div>
                                                <div class="form-group">
                                                    <label for="audio" class="mb-2">Listening File</label>
                                                    <input type="file" class="form-control" name="audio" id="audio">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
								    </div>
								</div>
                                <div class="row">
                                    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12 mx-auto">
                                        <div class="mt-4 text-center">
                                            <h3 class="fw-bolder">All Passage</h3>
                                        </div>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <th>SL No</th>
                                                <th>Quiz Name</th>
                                                <th>Listening Title</th>
                                                <th>Audio Track</th>
                                                <th>Action</th>
                                            </thead>
                                           
                                            <tbody>
                                                @foreach ($listening as $items)
                                                    <tr>
                                                        <td>{{$loop->index+1}}</td>
                                                        <td>{{$items->quiz->title}}</td>
                                                        <td>{{$items->title}}</td>
                                                        <td>
                                                            <audio controls>
                                                                <source src="{{asset('listening/uploads/'.$items->audio)}}" type="audio/mpeg">
                                                                Your browser does not support the audio element.
                                                              </audio>
                                                        </td>
                                                        <td>
                                                            <a href="{{route('admin.settings.quiz.delete-listening', $items->id)}}" class="btn btn-danger btn-sm">Delete</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
							</div>
						</div>							
					</div>
				</div>
			</section>
			<!-- /.content -->
		</div>
  	</div>
  <!-- /.content-wrapper -->
@endsection
