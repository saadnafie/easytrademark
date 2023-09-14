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
                        <h3 class="panel-title">Document Templates</h3>
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
                                        <form action="{{route('add_new_doctemplate')}}" method="post"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-group">
                                                <label for="service">Documnet Title<span
                                                        style="color:red">*</span></label>
                                                <input type="text" class="form-control" id="title" name="title"
                                                       required>
                                            </div>

                                            <div class="form-group">
                                                <label for="service">Document File<span
                                                        style="color:red">*</span></label>
                                                <input type="file" class="form-control" name="doctemp" required>
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
                                                    <label><input type="checkbox" name="services[]"
                                                                  value="{{$service_data->id}}"> {{$service_data->service_name}}
                                                    </label><br>
                                                @endforeach
                                            </div>

                                            <button type="submit" class="btn btn-info"> Add Data</button>
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
                                    <th>File</th>
                                    <th>Settings</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($doctemplates as $index=>$value)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{$value->country->country_name}}</td>
                                        <td>
                                            {{$value->service->service_name}}<br>
                                        </td>
                                        <td>{{$value->document->doc_title}}</td>
                                        <td>
                                            <a href="{{ url('public/resource_center/document_template/') }}/{{$value->document->doc_file}}"
                                               download>Download File</a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                    data-target="#myModaledit{{$index+1}}"><i class="fa fa-edit"
                                                                                              aria-hidden="true"></i>
                                            </button>

                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#myModaldelete{{$index+1}}"><i class="fa fa-trash"
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
                                                            <h4 class="modal-title"> Edit Data</h4>
                                                        </div>
                                                        <div class="modal-body">

                                                            <form action="{{route('update_doc_template')}}"
                                                                  method="post">
                                                                @csrf

                                                                <input type="hidden" id="id" name="id"
                                                                       value="{{$value->document->id}}" required>

                                                                <div class="form-group">
                                                                    <label for="service">Documnet Title<span
                                                                            style="color:red">*</span></label>
                                                                    <input type="text" class="form-control" id="title"
                                                                           name="title"
                                                                           value="{{$value->document->doc_title}}"
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

                                            <!-- Modal delete-->
                                            <div class="modal fade" id="myModaldelete{{$index+1}}" role="dialog">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header"
                                                             style=" background-color: darkred; color: white; ">
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    style="color: white;">&times;
                                                            </button>
                                                            <h4 class="modal-title"> Confirm Delete!</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <center>
                                                                <img src="{{url('public/img/delete_icon.jpg')}}"
                                                                     width="200px"/><br>

                                                                <a href="{{url('adminpanel/delete_doc_template')}}/{{$value->id}}/{{$value->document->id}}"
                                                                   class="btn btn-danger">Yes</a>

                                                                <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal">No
                                                                </button>
                                                            </center>
                                                        </div>
                                                        <div class="modal-footer">

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
