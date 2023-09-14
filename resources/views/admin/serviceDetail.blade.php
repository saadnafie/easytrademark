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
							<h3 class="panel-title">
							    <i class="lnr lnr-layers"></i>
							    Service Details</h3>
							<hr>
						</div>
						<div class="panel-body">

					<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"><i class="fa fa-edit" aria-hidden="true"></i> Edit Serivce</button>

						  <br><br>
						   <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"> Edit Service</h4>
        </div>
        <div class="modal-body">

       <form  action="{{route('update_service')}}" method="post">
     @csrf

      <input type="hidden" id="service_type" name="service_id" value="{{$service->id}}" required>

  <div class="form-group">
    <label for="service">Service Name (en)</label>
    <input type="text" class="form-control" id="service_type" name="service_type" value="{{$service->service_name_en}}" required>
      </div>

   <div class="form-group">
    <label for="service">Service Name (ar)</label>
    <input type="text" class="form-control" id="service_type" name="service_type_ar" value="{{$service->service_name_ar}}" required>
      </div>

	   <div class="form-group">
    <label for="service">Service Name (zh)</label>
    <input type="text" class="form-control" id="service_type" name="service_type_zh" value="{{$service->service_name_zh}}" required>
      </div>

   <div class="form-group">
    <label for="service">Service Name (tr)</label>
    <input type="text" class="form-control" id="service_type" name="service_type_tr" value="{{$service->service_name_tr}}" required>
      </div>

      <div class="form-group">
  <label for="comment">Icon Code:</label>
    <input type="text" class="form-control" id="icon_code" name="icon_code" value="{{$service->service_icon}}" required>
  </div>

    <div class="form-group">
  <label for="comment">Description (en):</label>
  <textarea class="form-control" rows="3" id="service_desc" name="service_desc"  required>{{$service->service_description_en}}</textarea>
</div>

    <div class="form-group">
  <label for="comment">Description (ar):</label>
  <textarea class="form-control" rows="3" id="service_desc" name="service_desc_ar"  required>{{$service->service_description_ar}}</textarea>
</div>

    <div class="form-group">
  <label for="comment">Description (zh):</label>
  <textarea class="form-control" rows="3" id="service_desc" name="service_desc_zh"  required>{{$service->service_description_zh}}</textarea>
</div>

    <div class="form-group">
  <label for="comment">Description (tr):</label>
  <textarea class="form-control" rows="3" id="service_desc" name="service_desc_tr"  required>{{$service->service_description_tr}}</textarea>
</div>

    <div class="form-group">
  <label for="comment">What Section (en):</label>
  <textarea class="form-control" rows="3" id="what_desc" name="what_desc"  required>{{$service->service_what_en}}</textarea>
</div>

    <div class="form-group">
  <label for="comment">What Section (ar):</label>
  <textarea class="form-control" rows="3" id="what_desc" name="what_desc_ar"  required>{{$service->service_what_ar}}</textarea>
</div>

    <div class="form-group">
  <label for="comment">What Section (zh):</label>
  <textarea class="form-control" rows="3" id="what_desc" name="what_desc_zh"  required>{{$service->service_what_zh}}</textarea>
</div>

    <div class="form-group">
  <label for="comment">What Section (tr):</label>
  <textarea class="form-control" rows="3" id="what_desc" name="what_desc_tr"  required>{{$service->service_what_tr}}</textarea>
</div>

    <div class="form-group">
  <label for="comment">Why Section (en):</label>
  <textarea class="form-control" rows="3" id="why_desc" name="why_desc"  required>{{$service->service_why_en}}</textarea>
</div>

    <div class="form-group">
  <label for="comment">Why Section (ar):</label>
  <textarea class="form-control" rows="3" id="why_desc" name="why_desc_ar"  required>{{$service->service_why_ar}}</textarea>
</div>

    <div class="form-group">
  <label for="comment">Why Section (zh):</label>
  <textarea class="form-control" rows="3" id="why_desc" name="why_desc_zh"  required>{{$service->service_why_zh}}</textarea>
</div>

    <div class="form-group">
  <label for="comment">Why Section (tr):</label>
  <textarea class="form-control" rows="3" id="why_desc" name="why_desc_tr"  required>{{$service->service_why_tr}}</textarea>
</div>


    <div class="form-group">
  <label for="comment">When Section (en):</label>
  <textarea class="form-control" rows="3" id="when_desc" name="when_desc"  required>{{$service->service_when_en}}</textarea>
</div>

    <div class="form-group">
  <label for="comment">When Section (ar):</label>
  <textarea class="form-control" rows="3" id="when_desc" name="when_desc_ar"  required>{{$service->service_when_ar}}</textarea>
</div>

    <div class="form-group">
  <label for="comment">When Section (zh):</label>
  <textarea class="form-control" rows="3" id="when_desc" name="when_desc_zh"  required>{{$service->service_when_zh}}</textarea>
</div>

    <div class="form-group">
  <label for="comment">When Section (tr):</label>
  <textarea class="form-control" rows="3" id="when_desc" name="when_desc_tr"  required>{{$service->service_when_tr}}</textarea>
</div>

    <div class="form-group">
  <label for="comment">How Section (en):</label>
  <textarea class="form-control" rows="3" id="how_desc" name="how_desc"  required>{{$service->service_how_en}}</textarea>
</div>

<div class="form-group">
  <label for="comment">How Section (ar):</label>
  <textarea class="form-control" rows="3" id="how_desc" name="how_desc_ar"  required>{{$service->service_how_ar}}</textarea>
</div>

<div class="form-group">
  <label for="comment">How Section (zh):</label>
  <textarea class="form-control" rows="3" id="how_desc" name="how_desc_zh"  required>{{$service->service_how_zh}}</textarea>
</div>

<div class="form-group">
  <label for="comment">How Section (tr):</label>
  <textarea class="form-control" rows="3" id="how_desc" name="how_desc_tr"  required>{{$service->service_how_tr}}</textarea>
</div>



  <button type="submit" class="btn btn-info"><i class="fa fa-edit" aria-hidden="true"></i> Edit Service</button>
  </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

                        <div class="panel panel-default">
                            <div class="panel-heading"><i class="lnr lnr-layers"></i> Service Detail</div>
                              <div class="panel-body">

                              <table class="table table-bordered">
                                  <tr>
                                      <td>Service Name (en)</td>
                                      <td>{{$service->service_name_en}}</td>
                                  </tr>
								  <tr>
                                      <td>Service Name (ar)</td>
                                      <td>{{$service->service_name_ar}}</td>
                                  </tr>
								  <tr>
                                      <td>Service Name (zh)</td>
                                      <td>{{$service->service_name_zh}}</td>
                                  </tr>
								  <tr>
                                      <td>Service Name (tr)</td>
                                      <td>{{$service->service_name_tr}}</td>
                                  </tr>
                                  <tr>
                                      <td>Service Icon</td>
                                      <td>{!! $service->service_icon !!}</td>
                                  </tr>
                                  <tr>
                                      <td>Service Description (en)</td>
                                      <td>{{$service->service_description_en}}</td>
                                  </tr>
								  <tr>
                                      <td>Service Description (ar)</td>
                                      <td>{{$service->service_description_ar}}</td>
                                  </tr>
								  <tr>
                                      <td>Service Description (zh)</td>
                                      <td>{{$service->service_description_zh}}</td>
                                  </tr>
								  <tr>
                                      <td>Service Description (tr)</td>
                                      <td>{{$service->service_description_tr}}</td>
                                  </tr>
                                  <tr>
                                      <td>What Section (en)</td>
                                      <td>{{$service->service_what_en}}</td>
                                  </tr>
								  <tr>
                                      <td>What Section (ar)</td>
                                      <td>{{$service->service_what_ar}}</td>
                                  </tr>
								  <tr>
                                      <td>What Section (zh)</td>
                                      <td>{{$service->service_what_zh}}</td>
                                  </tr>
								  <tr>
                                      <td>What Section (tr)</td>
                                      <td>{{$service->service_what_tr}}</td>
                                  </tr>
                                  <tr>
                                      <td>Why Section (en)</td>
                                      <td>{{$service->service_why_en}}</td>
                                  </tr>
								  <tr>
                                      <td>Why Section (ar)</td>
                                      <td>{{$service->service_why_ar}}</td>
                                  </tr>
								  <tr>
                                      <td>Why Section (zh)</td>
                                      <td>{{$service->service_why_zh}}</td>
                                  </tr>
								  <tr>
                                      <td>Why Section (tr)</td>
                                      <td>{{$service->service_why_tr}}</td>
                                  </tr>
                                  <tr>
                                      <td>When Section (en)</td>
                                      <td>{{$service->service_when_en}}</td>
                                  </tr>
								  <tr>
                                      <td>When Section (ar)</td>
                                      <td>{{$service->service_when_ar}}</td>
                                  </tr>
								  <tr>
                                      <td>When Section (zh)</td>
                                      <td>{{$service->service_when_zh}}</td>
                                  </tr>
								  <tr>
                                      <td>When Section (tr)</td>
                                      <td>{{$service->service_when_tr}}</td>
                                  </tr>
                                  <tr>
                                      <td>How Section (en)</td>
                                      <td>{{$service->service_how_en}}</td>
                                  </tr>
								  <tr>
                                      <td>How Section (ar)</td>
                                      <td>{{$service->service_how_ar}}</td>
                                  </tr>
								  <tr>
                                      <td>How Section (zh)</td>
                                      <td>{{$service->service_how_zh}}</td>
                                  </tr>
								  <tr>
                                      <td>How Section (tr)</td>
                                      <td>{{$service->service_how_tr}}</td>
                                  </tr>
                              </table>






                              </div>

                            </div>



			<hr>

       <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal2"><i class="fa fa-plus" aria-hidden="true"></i> Add Service Process Steps</button>

                              						   <!-- Modal -->
  <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"> Edit Service</h4>
        </div>
        <div class="modal-body">

       <form  action="{{route('add_how_detail')}}" method="post">
     @csrf

      <input type="hidden" id="service_type" name="service_id" value="{{$service->id}}" required>

  <div class="form-group">
    <label for="service">Step Title (en)</label>
    <input type="text" class="form-control" id="step_title" name="step_title_en"  required>
      </div>

<div class="form-group">
    <label for="service">Step Title (ar)</label>
    <input type="text" class="form-control" id="step_title" name="step_title_ar"  required>
      </div>

<div class="form-group">
    <label for="service">Step Title (zh)</label>
    <input type="text" class="form-control" id="step_title" name="step_title_zh"  required>
      </div>

<div class="form-group">
    <label for="service">Step Title (tr)</label>
    <input type="text" class="form-control" id="step_title" name="step_title_tr"  required>
      </div>


    <div class="form-group">
  <label for="comment">Step Description (en)</label>
  <textarea class="form-control" rows="3" id="step_desc" name="step_desc_en"  required></textarea>
</div>

<div class="form-group">
  <label for="comment">Step Description (ar)</label>
  <textarea class="form-control" rows="3" id="step_desc" name="step_desc_ar"  required></textarea>
</div>

<div class="form-group">
  <label for="comment">Step Description (zh)</label>
  <textarea class="form-control" rows="3" id="step_desc" name="step_desc_zh"  required></textarea>
</div>

<div class="form-group">
  <label for="comment">Step Description (tr)</label>
  <textarea class="form-control" rows="3" id="step_desc" name="step_desc_tr"  required></textarea>
</div>


     <div class="form-group">
    <label for="service">Step URL</label>
    <input type="text" class="form-control" id="step_url" name="step_url"  required>
      </div>



  <button type="submit" class="btn btn-info"><i class="fa fa-plus" aria-hidden="true"></i> Add Step</button>
  </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


	<br><br>

	<table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Step Title (en)</th>
		<th>Step Title (ar)</th>
		<th>Step Title (zh)</th>
		<th>Step Title (tr)</th>
        <th>Step Description (en)</th>
		<th>Step Description (ar)</th>
		<th>Step Description (zh)</th>
		<th>Step Description (tr)</th>
        <th>Step URL</th>
        <th>Settings</th>
      </tr>
    </thead>
    <tbody>
        @foreach($service->how_details as $index=>$value)
      <tr>
        <td>{{$index+1}}</td>
        <td>{{ $value->title_en }}</td>
		<td>{{ $value->title_ar }}</td>
		<td>{{ $value->title_zh }}</td>
		<td>{{ $value->title_tr }}</td>
        <td>{!! $value->content_en !!}</td>
		<td>{!! $value->content_ar !!}</td>
		<td>{!! $value->content_zh !!}</td>
		<td>{!! $value->content_tr !!}</td>
        <td>{{ $value->detail_url }}</td>
        <th>

                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModaledit{{$index+1}}"><i class="fa fa-edit" aria-hidden="true"></i></button>

               <a href="{{url('adminpanel/delete_how_detail')}}/{{$value->id}}" class="btn btn-danger" ><i class="fa fa-trash" aria-hidden="true"></i></a>

                              <!-- Modal -->
  <div class="modal fade" id="myModaledit{{$index+1}}" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"> Edit Service Process Steps</h4>
        </div>
        <div class="modal-body">

       <form  action="{{route('update_how_detail')}}" method="post">
     @csrf

 <input type="hidden" id="step_id" name="step_id" value="{{$value->id}}" required>

  <div class="form-group">
    <label for="service">Step Title (en)</label>
    <input type="text" class="form-control" id="step_title" name="step_title"  value="{{$value->title_en}}" required>
      </div>

<div class="form-group">
    <label for="service">Step Title (ar)</label>
    <input type="text" class="form-control" id="step_title" name="step_title_ar"  value="{{$value->title_ar}}" required>
      </div>

<div class="form-group">
    <label for="service">Step Title (zh)</label>
    <input type="text" class="form-control" id="step_title" name="step_title_zh"  value="{{$value->title_zh}}" required>
      </div>

<div class="form-group">
    <label for="service">Step Title (tr)</label>
    <input type="text" class="form-control" id="step_title" name="step_title_tr"  value="{{$value->title_tr}}" required>
      </div>


    <div class="form-group">
  <label for="comment">Step Description (en)</label>
  <textarea class="form-control" rows="3" id="step_desc" name="step_desc"  required>{{ $value->content_en }}</textarea>
</div>


    <div class="form-group">
  <label for="comment">Step Description (ar)</label>
  <textarea class="form-control" rows="3" id="step_desc" name="step_desc_ar"  required>{{ $value->content_ar }}</textarea>
</div>


    <div class="form-group">
  <label for="comment">Step Description (zh)</label>
  <textarea class="form-control" rows="3" id="step_desc" name="step_desc_zh"  required>{{ $value->content_zh }}</textarea>
</div>


    <div class="form-group">
  <label for="comment">Step Description (tr)</label>
  <textarea class="form-control" rows="3" id="step_desc" name="step_desc_tr"  required>{{ $value->content_tr }}</textarea>
</div>


     <div class="form-group">
    <label for="service">Step URL</label>
    <input type="text" class="form-control" id="step_url" name="step_url"  value="{{$value->detail_url}}" required>
      </div>



  <button type="submit" class="btn btn-info"><i class="fa fa-edit" aria-hidden="true"></i> Edit Step</button>
  </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

       </th>
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

