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
                        <h3 class="panel-title"><i class="lnr lnr-map"></i> Countries List</h3>
                        <hr>
                    </div>
                    <div class="panel-body">

                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"><i
                                class="fa fa-plus" aria-hidden="true"></i> Add Country
                        </button>
                        <br><br>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"> Add New Country</h4>
                                    </div>
                                    <div class="modal-body">

                                        <form action="{{route('add_new_country')}}" method="post">
                                            @csrf

  <div class="form-group">
    <label for="service">Country Name (en)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="country_name" name="country_name" required>
      </div>

	    <div class="form-group">
    <label for="service">Country Name (ar)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="country_name" name="country_name_ar" required>
      </div>

	    <div class="form-group">
    <label for="service">Country Name (zh)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="country_name" name="country_name_zh" required>
      </div>

	    <div class="form-group">
    <label for="service">Country Name (tr)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="country_name" name="country_name_tr" required>
      </div>


  <button type="submit" class="btn btn-info"><i class="fa fa-edit" aria-hidden="true"></i> Add</button>
  </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>



							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Country (en)</th>
										<th>Country (ar)</th>
										<th>Country (zh)</th>
										<th>Country (tr)</th>
										<th>Status</th>
										<th>Settings</th>
									</tr>
								</thead>
								<tbody>
								@foreach($countries as $index=>$value)
									<tr>
										<td>{{ $index+1 }}</td>
										<td>{{ $value->country_name_en }}</td>
										<td>{{ $value->country_name_ar }}</td>
										<td>{{ $value->country_name_zh }}</td>
										<td>{{ $value->country_name_tr }}</td>
										<td>
											@if($value->isActive == 1)
											<span class="label label-success">Active</span>
											@elseif($value->isActive == 0)
											<span class="label label-danger">Hidden</span>
											@endif
										</td>
										<td>
										<a href="{{url('adminpanel/countryfees')}}/{{$value->id}}" class="btn btn-info"><i class="fa fa-eye"></i></a>

										<a class="btn btn-info" data-toggle="modal" data-target="#myModal{{$index+1}}"><i class="fa fa-edit" aria-hidden="true"></i></a>

									   @if($value->isActive == 1)
										<a  href="country_activation/{{$value->id}}/0" class="btn btn-danger">
											<i class="fa fa-ban" aria-hidden="true"></i>
										</a>
											@elseif($value->isActive == 0)
												<a  href="country_activation/{{$value->id}}/1" class="btn btn-success">
											<i class="fa fa-check" aria-hidden="true"></i>
										</a>
											@endif

																  <!-- Modal -->
									  <div class="modal fade" id="myModal{{$index+1}}" role="dialog">
										<div class="modal-dialog">
										  <div class="modal-content">
											<div class="modal-header">
											  <button type="button" class="close" data-dismiss="modal">&times;</button>
											  <h4 class="modal-title"> Edit </h4>
											</div>
											<div class="modal-body">

										<form  action="{{route('update_country')}}" method="post">
										@csrf
										<input type="hidden" value="{{$value->id}}" name="c_id">

										<div class="form-group">
										<label for="service">Country (en)<span style="color:red">*</span></label>
										<input type="text" class="form-control" value="{{$value->country_name_en}}" id="c_name" name="c_name" required>
										  </div>

										  <div class="form-group">
										<label for="service">Country (ar)<span style="color:red">*</span></label>
										<input type="text" class="form-control" value="{{$value->country_name_ar}}" id="c_name" name="c_name_ar" required>
										  </div>

										  <div class="form-group">
										<label for="service">Country (zh)<span style="color:red">*</span></label>
										<input type="text" class="form-control" value="{{$value->country_name_zh}}" id="c_name" name="c_name_zh" required>
										  </div>

										  <div class="form-group">
										<label for="service">Country (tr)<span style="color:red">*</span></label>
										<input type="text" class="form-control" value="{{$value->country_name_tr}}" id="c_name" name="c_name_tr" required>
										  </div>

									  <button type="submit" class="btn btn-info"> Edit</button>
									  </form>
											</div>
											<div class="modal-footer">
											  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
										  </div>
										</div>
									  </div>


										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
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

