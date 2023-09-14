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
                        <h3 class="panel-title"><i class="fa fa-commenting-o" aria-hidden="true"></i> Trademark Response
                        </h3>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Service</th>
                                            <th>Trademark Response</th>
                                            <th>Settings</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($tmresponse as $index=>$value)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$value->service->service_name}}</td>
                                                <td>{{$value->response_msg}}</td>
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
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal">&times;
                                                                    </button>
                                                                    <h4 class="modal-title"> Edit </h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{route('update_tmresponsemsg')}}"
                                                                          method="post" enctype="multipart/form-data">
                                                                        @csrf

                                                                        <input type="hidden" value="{{$value->id}}"
                                                                               name="response_id">

                                                                        <div class="form-group">
                                                                            <label for="service">Trademark Response<span
                                                                                    style="color:red">*</span></label>
                                                                            <input type="text" class="form-control"
                                                                                   value="{{$value->response_msg}}"
                                                                                   id="tmreponse" name="tmresponse"
                                                                                   required>
                                                                        </div>

                                                                        <button type="submit" class="btn btn-info">
                                                                            Edit
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
