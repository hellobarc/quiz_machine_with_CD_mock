@extends('admin.layouts.master')

@section('title', 'Edit Mock Question')
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
													<h3 class="fw-bolder">Edit Mock Question</h3>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mx-auto">
								<div>
									@include('admin.partials.flash-message')
									<form action="{{route('admin.settings.mock.question.update', $mockQuestions->id)}}" method="POST" enctype="multipart/form-data">
										@csrf
										<div class="form-group">
											<label for="name" class="mb-2">Mock Question Title</label>
											<input type="text" class="form-control" name="mock_question_title" id="mock_question_title" value="{{$mockQuestions->mock_question_title}}" placeholder="Enter Mock Question Title">
										</div>
										<div class="form-group">
										  <label for="name" class="mb-2">Mock Question Type</label>
										  <select name="mock_question_type" id="mock_question_type" class="form-control">
											<option value="">Please select a mock question type</option>
											<option value="fill-blank">Fill in the blank</option>
											<option value="multiple-choice">Multiple Choice</option>
											<option value="radio">Radio</option>
											<option value="drop-down">Drop Down</option>
											<option value="heading-matching">Heading Matching</option>
											<option value="single-check">Single Check</option>
										  </select>
										</div>
										<div class="form-group">
										  <label for="name" class="mb-2">Mock Exercise</label>
										  <select name="mock_exercise_id" id="mock_exercise_id" class="form-control">
											<option value="">Please select a mock Exercise</option>
											@foreach ($mockExercises as $rows)
												<option value="{{$rows->id}}">{{$rows->mock_exercise_name}}</option>
											@endforeach
										  </select>
										</div>
										<div class="form-group">
											<label for="question_instruction" class="mb-2">Question instruction</label>
											<textarea name="question_instruction" id="ck" cols="30" rows="5" class="form-control">{{$mockQuestions->question_instruction}}</textarea>
										</div>
										<button type="submit" class="btn btn-primary">Update</button>
									  </form>
								</div>
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