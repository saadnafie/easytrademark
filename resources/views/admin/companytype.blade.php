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
							<h3 class="panel-title">Companies Types</h3>
							<hr>
						</div>
						<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Type En</th>
										<th>Type Ar</th>
										<th>Type (Zh)</th>
										<th>Type (Tr)</th>
										<!--<th>Settings</th>-->
									</tr>
								</thead>
								<tbody>
									@foreach($companytype as $index=>$value)
									<tr>
										<td>{{$index+1}}</td>
										<td>{{$value->type}}</td>
										<td>{{$value->type_ar}}</td>
										<td>{{$value->type_zh}}</td>
										<td>{{$value->type_tr}}</td>
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

