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
							<h3 class="panel-title"><i class="fa fa-diamond" aria-hidden="true"></i> Classes List</h3>
							<hr>
						</div>
						<div class="panel-body">
						<div class="row">
						<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>class Number</th>
										<th>Description (en)</th>
										<th>Description (ar)</th>
										<th>Description (zh)</th>
										<th>Description (tr)</th>
										<!--<th>Settings</th>-->
									</tr>
								</thead>
								<tbody>
									@foreach($classes as $index=>$value)
									<tr>
										<td>{{$value->class}}</td>
										<td>{{$value->class_brief_en}}</td>
										<td>{{$value->class_brief_ar}}</td>
										<td>{{$value->class_brief_zh}}</td>
										<td>{{$value->class_brief_tr}}</td>
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

