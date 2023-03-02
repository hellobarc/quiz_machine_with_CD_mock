@extends('admin.layouts.master')

@section('title', 'Manage Mock Listening')
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
													<h3 class="fw-bolder">All Mock Listening</h3>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body">
								@include('admin.partials.flash-message')
								<div class="d-flex justify-content-end mb-3">
									<a href="{{route('admin.settings.mock.audio.create')}}" class="btn btn-success btn-sm"><i class="fa-solid fa-plus"></i></i> Add New</a>
								</div>
								<table class="table table-bordered table-striped">
									<thead>
										<th>SL No</th>
										<th>Mock Exercise</th>
										<th>Mock Listening Title</th>
										<th>Mock Listening</th>
										<th>Action</th>
									</thead>
									<tbody>
										@foreach ($allData as $rows)
										<tr>
											<td>{{$loop->index + 1}}</td>
											<td>{{$rows->mockExercise->mock_exercise_name}}</td>
											<td>{{$rows->title}}</td>
											<td>
												<audio controls>
													<source src="{{ asset('file/uploads/mock-audio/'.$rows->audio) }}" type="audio/mpeg">
												</audio>
											</td>
											<td>
												<a href="{{route('admin.settings.mock.audio.edit', $rows->id)}}" class="btn btn-success btn-sm">Edit</a>
												<a href="{{route('admin.settings.mock.audio.delete', $rows->id)}}" class="btn btn-danger btn-sm">Delete</a>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
								{{-- Pagination --}}
								{{-- <div class="d-flex justify-content-end">
									{!! $allData->links() !!}
								</div> --}}
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