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
                        <h3 class="panel-title"><i class="fa fa-files-o" aria-hidden="true"></i> Country Required
                            Documents</h3>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"><i
                                class="fa fa-plus" aria-hidden="true"></i> Add
                        </button>
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

                                        <form action="{{route('add_new_countryreqdocs')}}" method="post"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-group">
                                                <label for="service">Documnet Title<span
                                                        style="color:red">*</span></label>
                                                <input type="text" class="form-control" id="title" name="title"
                                                       required>
                                            </div>

                                            <div class="form-group">
                                                <label for="service">Country<span style="color:red">*</span></label>
                                                <select class="form-control" id="country_id" name="country_id">
                                                    @foreach($countries as $country_data)
                                                        <option
                                                            value="{{$country_data->id}}">{{$country_data->country_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="checkbox">
                                                @foreach($services as $service_data)
                                                    @if($service_data->id == 1)

                                                    @else
                                                        <label><input type="checkbox" name="services[]"
                                                                      value="{{$service_data->id}}"> {{$service_data->service_name}}
                                                        </label><br>
                                                    @endif

                                                @endforeach
                                            </div>

                                            <br>
                                            <button type="submit" class="btn btn-info"> Add Data</button>
                                            <br>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Country</th>
                                    <th>Service</th>
                                    <th>Document Title</th>
                                    <th>Setting</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($countryreqdocs as $index=>$value)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{$value->country->country_name}}</td>
                                        <td>{{$value->service->service_name}}</td>
                                        <td>{{$value->document->document_title}}</td>
                                        <td>
                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                    data-target="#myModal{{$index+1}}"><i class="fa fa-edit"
                                                                                          aria-hidden="true"></i>
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="myModal{{$index+1}}" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                &times;
                                                            </button>
                                                            <h4 class="modal-title"> Edit </h4>
                                                        </div>
                                                        <div class="modal-body">

                                                            <form action="{{route('update_countryreqdocs')}}"
                                                                  method="post" enctype="multipart/form-data">
                                                                @csrf

                                                                <input type="hidden" value="{{$value->document->id}}"
                                                                       name="doc_id">

                                                                <div class="form-group">
                                                                    <label for="service">Documnet Title<span
                                                                            style="color:red">*</span></label>
                                                                    <input type="text" class="form-control"
                                                                           value="{{$value->document->document_title}}"
                                                                           id="title" name="title" required>
                                                                </div>

                                                                <button type="submit" class="btn btn-info"> Edit
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
