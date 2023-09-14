@extends('admin.layouts.header')

@section('content')
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Applicants Occupations</h3>
							<hr>
						</div>
						<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Occupation (En)</th>
										<th>Occupation (Ar)</th>
										<th>Occupation (Zh)</th>
										<th>Occupation (tr)</th>
										<!--<th>Settings</th>-->
									</tr>
								</thead>
								<tbody>
									@foreach($applicantccupation as $index=>$value)
									<tr>
										<td>{{$index+1}}</td>
										<td>{{$value->occupation}}</td>
										<td>{{$value->occupation_ar}}</td>
										<td>{{$value->occupation_zh}}</td>
										<td>{{$value->occupation_tr}}</td>
										<!--<td>
										<button type="button" class="btn btn-info"><i class="fa fa-edit"></i></button>
										<button type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
										</td>-->
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						</div>
					</div>
					<!-- END OVERVIEW -->
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
		<div class="clearfix"></div>
		@endsection

