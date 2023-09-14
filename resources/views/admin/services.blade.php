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
                            Services List</h3>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <a href="{{url('adminpanel/addserviceform')}}" class="btn btn-info"><i class="fa fa-plus-circle"
                                                                                               aria-hidden="true"></i>&nbsp;&nbsp;Add
                            Service</a>
                        <br><br>


						    <div class="table-responsive">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Abbreviation</th>
										<th>Service Name (en)</th>
										<th>Service Name (ar)</th>
										<th>Service Name (zh)</th>
										<th>Service Name (tr)</th>
										<th>Description (en)</th>
										<th>Description (ar)</th>
										<th>Description (zh)</th>
										<th>Description (tr)</th>
										<th>Business Days</th>
										<th>Icon</th>
										<th>Status</th>
										<th>Settings</th>
									</tr>
								</thead>
	<tbody>
	    @foreach($services as $index=>$value)
		<tr>
			<td>{{$index+1}}</td>
			<td>{{$value->service_abbreviation}}</td>
			<td>{{$value->service_name_en}}</td>
			<td>{{$value->service_name_ar}}</td>
			<td>{{$value->service_name_zh}}</td>
			<td>{{$value->service_name_tr}}</td>
			<td>{{ Str::limit($value->service_description, 40) }}</td>
			<td>{{ Str::limit($value->service_description_ar, 40) }}</td>
			<td>{{ Str::limit($value->service_description_zh, 40) }}</td>
			<td>{{ Str::limit($value->service_description_tr, 40) }}</td>
			<td>{{ $value->execution_days }}</td>
			<td>{!! $value->service_icon !!}</td>
			<td>
			    @if($value->isActive == 1)
			    <span class="label label-success">Active</span>
            	@elseif($value->isActive == 0)
				<span class="label label-danger">Hidden</span>
            	@endif
			</td>
			<td>
											<a href="{{url('adminpanel/service_details')}}/{{$value->id}}"
                                               class="btn btn-info"><i class="fa fa-eye"></i></a>


                                            @if($value->isActive == 1)
                                                <a href="service_activation/{{$value->id}}/0" class="btn btn-danger">
                                                    <i class="fa fa-ban" aria-hidden="true"></i>
                                                </a>
                                            @elseif($value->isActive == 0)
                                                <a href="service_activation/{{$value->id}}/1" class="btn btn-success">
                                                    <i class="fa fa-check" aria-hidden="true"></i>
                                                </a>
                                            @endif
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
