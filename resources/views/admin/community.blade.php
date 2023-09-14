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
							<h3 class="panel-title">Community</h3>
							<hr>
						</div>
						<div class="panel-body">


	 <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i> Add </button>
                     <br><br>
                              <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"> Add </h4>
        </div>
        <div class="modal-body">

 <form  action="{{route('add_new_community')}}" method="post" enctype="multipart/form-data">
     @csrf

    <div class="form-group">
    <label for="service">Country (en)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="country" name="country"  required>
      </div>

<div class="form-group">
    <label for="service">Country (ar)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="country" name="country_ar"  required>
      </div>

	  <div class="form-group">
    <label for="service">Country (zh)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="country" name="country_zh"  required>
      </div>

 <div class="form-group">
    <label for="service">Country (tr)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="country" name="country_tr"  required>
      </div>


  <div class="form-group">
    <label for="service">Title (en)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="title" name="title"  required>
      </div>

	  <div class="form-group">
    <label for="service">Title (ar)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="title" name="title_ar" required>
      </div>

	  <div class="form-group">
    <label for="service">Title (zh)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="title" name="title_zh"  required>
      </div>

	  <div class="form-group">
    <label for="service">Title (tr)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="title" name="title_tr"  required>
      </div>

	  	   <div class="form-group">
    <label for="service">Description (en)<span style="color:red">*</span></label>
    <textarea rows="4" class="form-control" id="description" name="description" required></textarea>
      </div>

	  <div class="form-group">
    <label for="service">Description (ar)<span style="color:red">*</span></label>
    <textarea rows="4" class="form-control" id="description" name="description_ar" required></textarea>
      </div>

	  <div class="form-group">
    <label for="service">Description (zh)<span style="color:red">*</span></label>
    <textarea rows="4" class="form-control" id="description" name="description_zh" required></textarea>
      </div>

 <div class="form-group">
    <label for="service">Description (tr)<span style="color:red">*</span></label>
    <textarea rows="4" class="form-control" id="description" name="description_tr" required></textarea>
      </div>

	<div class="form-group">
    <label for="service">Logo<span style="color:red">*</span></label>
    <input type="file" class="form-control" id="logo" name="logo" required>
      </div>

     <div class="form-group">
    <label for="service">Website URL<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="website_url" name="website_url" required>
      </div>


  <button type="submit" class="btn btn-info"> Add Data</button>
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
										<th>Country_EN</th>
										<th>Country_AR</th>
										<th>Country_ZH</th>
										<th>Country_tr</th>
										<th>Title_EN</th>
										<th>Title_AR</th>
										<th>Title_ZH</th>
										<th>Title_tr</th>
										<th>Description_EN</th>
										<th>Description_AR</th>
										<th>Description_ZH</th>
										<th>Description_tr</th>
										<th>Logo <br> Link</th>
										<th>Settings</th>
									</tr>
								</thead>
								<tbody>
								@foreach($communities as $index=>$value)
									<tr>
										<td>{{$index+1}}</td>
										<td>{{$value->country}}</td>
										<td>{{$value->country_ar}}</td>
										<td>{{$value->country_zh}}</td>
										<td>{{$value->country_tr}}</td>
										<td>{{$value->title}}</td>
										<td>{{$value->title_ar}}</td>
										<td>{{$value->title_zh}}</td>
										<td>{{$value->title_tr}}</td>
										<td>{{$value->description}}</td>
										<td>{{$value->description_ar}}</td>
										<td>{{$value->description_zh}}</td>
										<td>{{$value->description_tr}}</td>
										<td><img src="{{ url('public/resource_center/community/') }}/{{$value->logo}}" width="150px">
										<br><br>{{$value->website_url}}</td>
										<td>

										<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModaledit{{$index+1}}"><i class="fa fa-edit" aria-hidden="true"></i></button>

                              <!-- Modal -->
  <div class="modal fade" id="myModaledit{{$index+1}}" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"> Edit Data</h4>
        </div>
        <div class="modal-body">

 <form  action="{{route('update_community')}}" method="post" enctype="multipart/form-data">
     @csrf

  <input type="hidden"  id="id" name="id" value="{{ $value->id }}" required>

    <div class="form-group">
    <label for="service">Country (en)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="country" name="country" value="{{$value->country}}" required>
      </div>

<div class="form-group">
    <label for="service">Country (ar)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="country" name="country_ar" value="{{$value->country_ar}}" required>
      </div>

	  <div class="form-group">
    <label for="service">Country (zh)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="country" name="country_zh" value="{{$value->country_zh}}" required>
      </div>

	  <div class="form-group">
    <label for="service">Country (tr)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="country" name="country_tr" value="{{$value->country_tr}}" required>
      </div>

  <div class="form-group">
    <label for="service">Title (en)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="title" name="title" value="{{$value->title}}" required>
      </div>

	  <div class="form-group">
    <label for="service">Title (ar)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="title" name="title_ar" value="{{$value->title_ar}}" required>
      </div>

	  <div class="form-group">
    <label for="service">Title (zh)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="title" name="title_zh" value="{{$value->title_zh}}" required>
      </div>

 <div class="form-group">
    <label for="service">Title (tr)<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="title" name="title_tr" value="{{$value->title_tr}}" required>
      </div>

	  	   <div class="form-group">
    <label for="service">Description (en)<span style="color:red">*</span></label>
    <textarea rows="4" class="form-control" id="description" name="description" required>{{$value->description}}</textarea>
      </div>

	  <div class="form-group">
    <label for="service">Description (ar)<span style="color:red">*</span></label>
    <textarea rows="4" class="form-control" id="description" name="description_ar" required>{{$value->description_ar}}</textarea>
      </div>

	  <div class="form-group">
    <label for="service">Description (zh)<span style="color:red">*</span></label>
    <textarea rows="4" class="form-control" id="description" name="description_zh" required>{{$value->description_zh}}</textarea>
      </div>

<div class="form-group">
    <label for="service">Description (tr)<span style="color:red">*</span></label>
    <textarea rows="4" class="form-control" id="description" name="description_tr" required>{{$value->description_tr}}</textarea>
      </div>

     <div class="form-group">
    <label for="service">Website URL<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="website_url" name="website_url" value="{{$value->website_url}}" required>
      </div>
    <div class="form-group">
    <label for="service">Logo<span style="color:red">*</span></label>
    <input type="file" class="form-control" id="logo" name="logo" >
     </div>

  <button type="submit" class="btn btn-info"><i class="fa fa-edit" aria-hidden="true"></i> Edit Data</button>
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

