@extends('admin.layouts.master')

@section('title', 'Manage Mock Questions')
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
													<h3 class="fw-bolder">All Mock Questions</h3>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body">
								@include('admin.partials.flash-message')
								<div class="d-flex justify-content-end mb-3">
									<a href="{{route('admin.settings.mock.question.create')}}" class="btn btn-success btn-sm"><i class="fa-solid fa-plus"></i></i> Add New</a>
								</div>
								<table class="table table-bordered table-striped">
									<thead>
										<th>SL No</th>
										<th>Mock Question Title</th>
										<th>Mock Question Type</th>
										<th>Mock exercise</th>
										<th>Action</th>
									</thead>
									<tbody>
										@foreach ($allData as $rows)
										<tr>
											<td>{{$loop->index + 1}}</td>
											<td>{{$rows->mock_question_title}}</td>
											<td>{{$rows->mock_question_type}}</td>
											<td>{{$rows->mockExercise->mock_exercise_name}}</td>
											<td>
												<a href="{{route('admin.settings.mock.question.edit', $rows->id)}}" class="btn btn-success btn-sm">Edit</a>
												<a href="{{route('admin.settings.mock.question.delete', ['id'=>$rows->id, 'questionType'=>$rows->mock_question_type])}}" class="btn btn-danger btn-sm">Delete</a>
												<a href="{{route('admin.settings.mock.add-question', ['questionType'=>$rows->mock_question_type, 'questionId'=>$rows->id])}}" class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-plus"></i> Add Question</a>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
								{{-- Pagination --}}
								<div class="d-flex justify-content-end">
									{!! $allData->links() !!}
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