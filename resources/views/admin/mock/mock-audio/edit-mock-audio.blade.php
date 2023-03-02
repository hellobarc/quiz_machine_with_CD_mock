@extends('admin.layouts.master')

@section('title', 'Edit Mock Listening')
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
													<h3 class="fw-bolder">Edit Mock Listening</h3>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12 mx-auto">
								<div>
									@include('admin.partials.flash-message')
									<form action="{{route('admin.settings.mock.audio.update', $data->id)}}" method="POST" enctype="multipart/form-data">
										@csrf
										<div class="form-group">
										  <label for="name" class="mb-2">Mock Exercise</label>
										  <select name="mock_exercise_id" id="mock_exercise_id" class="form-control">
											<option value="">Please select a mock exercise</option>
											@foreach ($mockExercises as $rows)
												<option value="{{$rows->id}}">{{$rows->mock_exercise_name}}</option>	
											@endforeach
										  </select>
										</div>
										<div class="form-group">
											<label for="name" class="mb-2">Mock Passage Title</label>
											<input type="text" class="form-control" name="title" id="title" value="{{$data->title}}" placeholder="Enter Mock Passage Title">
										</div>
										<div class="form-group">
											<label for="name" class="mb-2">Previous file</label><br>
											<audio controls>
												<source src="{{ asset('file/uploads/mock-audio/'.$data->audio) }}" type="audio/mpeg">
											</audio>
										</div>
										<div class="form-group">
											<label for="name" class="mb-2">Upload New file</label>
											<input type="file" class="form-control" name="audio">
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