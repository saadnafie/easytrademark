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
                        <h3 class="panel-title">Packages Details List</h3>
                        <hr>
                        <div class="panel panel-default">
                            <div class="panel-body"><h3><i class="lnr lnr-map"></i> Country: {{$country->country_name}}
                                </h3></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Service</th>
                                    <th>Package Title</th>
                                    <th>Government Fees</th>
                                    <th>Status</th>
                                    <th>Settings</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($packages as $index => $value)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{$value->service_package->service->service_name}}</td>
                                        <td>{{$value->service_package->package->package}} {{$value->service_package->package->package_type}}</td>
                                        <td>{{$value->fees}} $</td>
                                        <td>
                                            @if($value->isActive == 1)
                                                <span class="label label-success">Active</span>
                                            @elseif($value->isActive == 0)
                                                <span class="label label-danger">Hidden</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                    data-target="#myModaledit{{$index+1}}"><i class="fa fa-edit"
                                                                                              aria-hidden="true"></i>
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="myModaledit{{$index+1}}" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                &times;
                                                            </button>
                                                            <h4 class="modal-title"> Edit data</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{route('update_govfees')}}" method="post">
                                                                @csrf

                                                                <input type="hidden" id="id" name="id"
                                                                       value="{{ $value->id }}" required>

                                                                <div class="form-group">
                                                                    <label for="service">Government Fees<span
                                                                            style="color:red">*</span></label>
                                                                    <input type="text" class="form-control" id="govfees"
                                                                           name="govfees" value="{{$value->fees}}"
                                                                           required>
                                                                </div>

                                                                <button type="submit" class="btn btn-info"><i
                                                                        class="fa fa-edit" aria-hidden="true"></i> Edit
                                                                    Data
                                                                </button>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Close
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @if($value->isActive == 1)
                                                <a href="{{url('adminpanel/country_packages_activation')}}/{{$value->id}}/0"
                                                   class="btn btn-danger">
                                                    <i class="fa fa-ban" aria-hidden="true"></i>
                                                </a>
                                            @elseif($value->isActive == 0)
                                                <a href="{{url('adminpanel/country_packages_activation')}}/{{$value->id}}/1"
                                                   class="btn btn-success">
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
