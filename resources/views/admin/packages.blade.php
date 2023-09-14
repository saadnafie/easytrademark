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
							<h3 class="panel-title"><i class="lnr lnr-dice"></i> Packages Details</h3>
							<hr>
						</div>
						<div class="panel-body">


	 <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i> Add Package</button>
                     <br><br>
                              <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"> Add New Package</h4>
        </div>
        <div class="modal-body">

 <form  action="{{route('add_new_package')}}" method="post">
     @csrf

	   <div class="form-group">
    <label for="service">Service<span style="color:red">*</span></label>
    <select class="form-control" id="service_id" name="service_id">
	@foreach($services as $value)
	<option value="{{$value->id}}">{{$value->service_name}}</option>
	@endforeach
	</select>
      </div>

 <div class="form-group">
    <label for="service">Package Title (en)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="package_title" name="package_title_en" required>
      </div>

	  <div class="form-group">
    <label for="service">Package Title (ar)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="package_title" name="package_title_ar" required>
      </div>

	  <div class="form-group">
    <label for="service">Package Title (zh)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="package_title" name="package_title_zh" required>
      </div>

	  <div class="form-group">
    <label for="service">Package Title (tr)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="package_title" name="package_title_tr" required>
      </div>

	<div class="form-group">
    <label for="service">Package Type (en)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="package_type" name="package_type_en" required>
      </div>

	  <div class="form-group">
    <label for="service">Package Type (ar)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="package_type" name="package_type_ar" required>
      </div>

	  <div class="form-group">
    <label for="service">Package Type (zh)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="package_type" name="package_type_zh" required>
      </div>

	  <div class="form-group">
    <label for="service">Package Type (tr)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="package_type" name="package_type_tr" required>
      </div>

	   <div class="form-group">
    <label for="service">Package Details (en)<span style="color:red">*</span></label>
    <textarea rows="4" class="form-control" id="package_detail" name="package_detail_en" required></textarea>
      </div>

	  <div class="form-group">
    <label for="service">Package Details (ar)<span style="color:red">*</span></label>
    <textarea rows="4" class="form-control" id="package_detail" name="package_detail_ar" required></textarea>
      </div>

	  <div class="form-group">
    <label for="service">Package Details (zh)<span style="color:red">*</span></label>
    <textarea rows="4" class="form-control" id="package_detail" name="package_detail_zh" required></textarea>
      </div>

	  <div class="form-group">
    <label for="service">Package Details (tr)<span style="color:red">*</span></label>
    <textarea rows="4" class="form-control" id="package_detail" name="package_detail_tr" required></textarea>
      </div>

     <div class="form-group">
    <label for="service">Package Fees<span style="color:red">*</span></label>
    <input type="number" class="form-control" id="package_fees" name="package_fees" required>
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


						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Service Type</th>
										<th>Package Title (en)</th>
										<th>Package Title (ar)</th>
										<th>Package Title (zh)</th>
										<th>Package Title (tr)</th>
										<th>Package Type (en)</th>
										<th>Package Type (ar)</th>
										<th>Package Type (zh)</th>
										<th>Package Type (tr)</th>
										<th>Feature (en)</th>
										<th>Feature (ar)</th>
										<th>Feature (zh)</th>
										<th>Feature (tr)</th>
										<th>Fees</th>
										<th>Settings</th>
									</tr>
								</thead>
								<tbody>
								@foreach($packages as $index=>$value)
									<tr>
										<td>{{$index+1}}</td>
										<td>{{$value->service_package->service->service_name}}</td>
										<td>{{$value->package_en}}</td>
										<td>{{$value->package_ar}}</td>
										<td>{{$value->package_zh}}</td>
										<td>{{$value->package_tr}}</td>
										<td>{{$value->package_type_en}}</td>
										<td>{{$value->package_type_ar}}</td>
										<td>{{$value->package_type_zh}}</td>
										<td>{{$value->package_type_tr}}</td>
										<td>{!! $value->package_details_en !!}</td>
										<td>{!! $value->package_details_ar !!}</td>
										<td>{!! $value->package_details_zh !!}</td>
										<td>{!! $value->package_details_tr !!}</td>
										<td>{{$value->service_package->fee}} $</td>
										<td>

										<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModaledit{{$index+1}}"><i class="fa fa-edit" aria-hidden="true"></i></button>

                              <!-- Modal -->
  <div class="modal fade" id="myModaledit{{$index+1}}" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"> Edit Service Process Steps</h4>
        </div>
        <div class="modal-body">

 <form  action="{{route('update_package')}}" method="post">
     @csrf

  <input type="hidden"  id="package_id" name="package_id" value="{{ $value->id }}" required>
  <input type="hidden"  id="ser_pack_fee_id" name="ser_pack_fee_id" value="{{ $value->service_package->id }}" required>

   <div class="form-group">
    <label for="service">Service<span style="color:red">*</span></label>
    <select class="form-control" id="service_id" name="service_id">
	@foreach($services as $value2)
	<option value="{{$value2->id}}" {{ ($value2->id == $value->service_package->service->id) ? 'selected' : '' }} >{{$value2->service_name}}</option>
	@endforeach
	</select>
      </div>

  <div class="form-group">
    <label for="service">Package Title (en)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="package_title" name="package_title_en" value="{{$value->package_en}}" required>
      </div>

	  <div class="form-group">
    <label for="service">Package Title (ar)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="package_title" name="package_title_ar" value="{{$value->package_ar}}" required>
      </div>

	  <div class="form-group">
    <label for="service">Package Title (zh)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="package_title" name="package_title_zh" value="{{$value->package_zh}}" required>
      </div>

	  <div class="form-group">
    <label for="service">Package Title (tr)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="package_title" name="package_title_tr" value="{{$value->package_tr}}" required>
      </div>

	  <div class="form-group">
    <label for="service">Package Type (en)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="package_type" name="package_type_en" value="{{$value->package_type_en}}" required>
      </div>

	  <div class="form-group">
    <label for="service">Package Type (ar)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="package_type" name="package_type_ar" value="{{$value->package_type_ar}}" required>
      </div>

	  <div class="form-group">
    <label for="service">Package Type (zh)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="package_type" name="package_type_zh" value="{{$value->package_type_zh}}" required>
      </div>

	  <div class="form-group">
    <label for="service">Package Type (tr)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="package_type" name="package_type_tr" value="{{$value->package_type_tr}}" required>
      </div>

	   <div class="form-group">
    <label for="service">Package Details (en)<span style="color:red">*</span></label>
    <textarea rows="4" class="form-control" id="package_detail" name="package_detail_en" required>{{$value->package_details_en}}</textarea>
      </div>

	  <div class="form-group">
    <label for="service">Package Details (ar)<span style="color:red">*</span></label>
    <textarea rows="4" class="form-control" id="package_detail" name="package_detail_ar" required>{{$value->package_details_ar}}</textarea>
      </div>

	  <div class="form-group">
    <label for="service">Package Details (zh)<span style="color:red">*</span></label>
    <textarea rows="4" class="form-control" id="package_detail" name="package_detail_zh" required>{{$value->package_details_zh}}</textarea>
      </div>

	  <div class="form-group">
    <label for="service">Package Details (tr)<span style="color:red">*</span></label>
    <textarea rows="4" class="form-control" id="package_detail" name="package_detail_tr" required>{{$value->package_details_tr}}</textarea>
      </div>


     <div class="form-group">
    <label for="service">Package Fees<span style="color:red">*</span></label>
    <input type="number" class="form-control" id="package_fees" name="package_fees" value="{{$value->service_package->fee}}" required>
      </div>


  <button type="submit" class="btn btn-info"><i class="fa fa-edit" aria-hidden="true"></i> Edit Package</button>
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
					</div>
					<!-- END OVERVIEW -->
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
		<div class="clearfix"></div>
		@endsection

