@extends('admin.layouts.master')

@section('title', 'Create Mock Exercise')
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
													<h3 class="fw-bolder">Create Mock Exercise</h3>
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
									<form action="{{route('admin.settings.mock.exercise.store')}}" method="POST" enctype="multipart/form-data">
										@csrf
										<div class="form-group">
											<label for="name" class="mb-2">Mock Exercise Name</label>
											<input type="text" class="form-control" name="mock_exercise_name" id="mock_exercise_name" aria-describedby="emailHelp" placeholder="Enter Mock Question Title">
										</div>
										<div class="form-group">
										  <label for="name" class="mb-2">Mock Name</label>
										  <select name="mock_id" id="mock_id" class="form-control">
											<option value="">Please select a mock test</option>
											@foreach ($mocks as $rows)
												<option value="{{$rows->id}}">{{$rows->mock_name}}</option>
											@endforeach
										  </select>
										</div>
										<div class="form-group">
										  <label for="name" class="mb-2">Mock Category</label>
										  <select name="module_id" id="module_id" class="form-control">
											<option value="">Please select a mock module</option>
											@foreach ($modules as $items)
												<option value="{{$items->id}}">{{$items->name}}</option>
											@endforeach
										  </select>
										</div>
										<button type="submit" class="btn btn-primary">Submit</button>
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