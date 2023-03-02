@extends('admin.layouts.master')

@section('title', 'Add Question')
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
													<h3 class="fw-bolder">Heading Match True of Nice</h3>
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
                                            <form action="{{route('admin.settings.mock.heading-match.store.true-of-nice')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="question_id" value="{{$question_id}}">
                                                <div class="form-group">
                                                    <label for="name" class="mb-2">Select any three answers</label>
                                                    <select name="blank_answer[]" id="" class="form-control js-example-basic-multiple" multiple="multiple">
                                                        <option value="">Plesase select a answer</option>
                                                        @foreach ($mockHeadingTitle as $rows)
                                                            <option value="{{$rows->heading_title}}">{{$rows->heading_title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class="mb-2">Marks</label>
                                                    <input type="text" class="form-control" name="marks" placeholder="Write heading questing marks">
                                                </div>
                                                
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
								    </div>
								</div>
                               
                                <div class="row">
                                    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12 mx-auto">
                                        <div class="mt-4 text-center">
                                            <h3 class="fw-bolder">All Heading Sub Question</h3>
                                        </div>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <th>SL No</th>
                                                <th>Mock Question Name</th>
                                                {{-- <th>Question Text</th> --}}
                                                <th>Marks</th>
                                                <th>Action</th>
                                            </thead>
                                           
                                            <tbody>
                                                @foreach ($mockHeadingMatch as $items)
                                                    <tr>
                                                        <td>{{$loop->index+1}}</td>
                                                        <td>{{$items->mockQuestion->mock_question_title}}</td>
                                                        {{-- <td>{{$items->}}</td> --}}
                                                        <td>{{$items->marks}}</td>
                                                        <td>
                                                            <a href="{{route('admin.settings.mock.heading-match.delete.true-of-nice', ['id'=>$items->id])}}" class="btn btn-danger btn-sm">Delete</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{-- Pagination --}}
                                        <div class="d-flex justify-content-end">
                                            {!! $mockHeadingMatch->links() !!}
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>
