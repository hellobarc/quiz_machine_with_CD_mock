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
													<h3 class="fw-bolder">
                                                        @if($questionType == 'heading-matching')
                                                            Heading Matching
                                                        @elseif($questionType == 'single-check')
                                                            Single Check
                                                        @elseif($questionType == 'true-of-nice')
                                                            True of Nice
                                                        @endif
                                                    </h3>
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
                                            <form action="{{route('admin.settings.mock.heading-match.store-question')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="question_id" value="{{$questionId}}">
                                                <input type="hidden" name="question_type" value="{{$questionType}}">
                                                <div class="form-group">
                                                    <label for="name" class="mb-2">Heading Title</label>
                                                    <input type="text" class="form-control" name="heading_title" placeholder="Write heading title">
                                                </div>
                                                
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
								    </div>
								</div>
                                <div class="row">
                                    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                        <div class="d-flex justify-content-end">
                                            @if($questionType == 'true-of-nice')
                                            <a href="{{route('admin.settings.mock.heading-match.true-of-nice', ['question_id'=>$questionId])}}" class="btn btn-success btn-sm"><i class="fa-solid fa-plus"></i> Add Answers</a>
                                            @else
                                            <a href="{{route('admin.settings.mock.heading-match.sub-question', ['question_id'=>$questionId])}}" class="btn btn-success btn-sm"><i class="fa-solid fa-plus"></i> Add Heading Sub-Question</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12 mx-auto">
                                        <div class="mt-4 text-center">
                                            <h3 class="fw-bolder">All Heading</h3>
                                        </div>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <th>SL No</th>
                                                <th>Question Name</th>
                                                <th>Heading Title</th>
                                                <th>Action</th>
                                            </thead>
                                           
                                            <tbody>
                                                @if($questionType == 'heading-matching')
                                                    @foreach ($headingMatching as $items)
                                                        <tr>
                                                            <td>{{$loop->index+1}}</td>
                                                            <td>{{$items->mockQuestion->mock_question_title}}</td>
                                                            <td>{{$items->heading_title}}</td>
                                                            <td>
                                                                <a href="{{route('admin.settings.mock.heading-match.delete-question', ['id'=>$items->id])}}" class="btn btn-danger btn-sm">Delete</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @elseif($questionType == 'single-check')
                                                    @foreach ($singleCheck as $rows)
                                                        <tr>
                                                            <td>{{$loop->index+1}}</td>
                                                            <td>{{$rows->mockQuestion->mock_question_title}}</td>
                                                            <td>{{$rows->heading_title}}</td>
                                                            <td>
                                                                <a href="{{route('admin.settings.mock.heading-match.delete-question', ['id'=>$rows->id])}}" class="btn btn-danger btn-sm">Delete</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach 
                                                @elseif($questionType == 'true-of-nice')
                                                    @foreach ($trueOfNice as $rows)
                                                        <tr>
                                                            <td>{{$loop->index+1}}</td>
                                                            <td>{{$rows->mockQuestion->mock_question_title}}</td>
                                                            <td>{{$rows->heading_title}}</td>
                                                            <td>
                                                                <a href="{{route('admin.settings.mock.heading-match.delete-question', ['id'=>$rows->id])}}" class="btn btn-danger btn-sm">Delete</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach 
                                                @endif
                                            </tbody>
                                        </table>
                                        {{-- Pagination --}}
                                        @if($questionType == 'heading-matching')
                                            <div class="d-flex justify-content-end">
                                                {!! $headingMatching->links() !!}
                                            </div>
                                        @elseif($questionType == 'single-check')
                                            <div class="d-flex justify-content-end">
                                                {!! $singleCheck->links() !!}
                                            </div>
                                        @endif
                                        
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
<script src="{{asset('mock/js/question_js.js')}}"></script>