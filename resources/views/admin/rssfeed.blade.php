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
                        <h3 class="panel-title"><i class="fa fa-rss"></i> Whats New</h3>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"><i
                                class="fa fa-plus" aria-hidden="true"></i> Add Whats New
                        </button>
                        <br><br>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"> Add Whats New</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('add_new_rssfeed')}}" method="post">
                                            @csrf

                                            <div class="form-group">
                                                <label for="service">Title<span style="color:red">*</span></label>
                                                <input type="text" class="form-control" id="rss_title" name="rss_title"
                                                       required>
                                            </div>

                                            <div class="form-group">
                                                <label for="service">Link<span style="color:red">*</span></label>
                                                <input type="text" class="form-control" id="rss_link" name="rss_link"
                                                       required>
                                            </div>

                                            <div class="form-group">
                                                <label for="service">Description<span style="color:red">*</span></label>
                                                <textarea rows="4" class="form-control" id="rss_detail"
                                                          name="rss_detail" required></textarea>
                                            </div>

                                            <div class="form-group">
                                                <!-- <label for="service">Date<span style="color:red">*</span></label>-->
                                                <input type="hidden" class="form-control" id="rss_date" name="rss_date"
                                                       value="{{date('Y-m-d')}}" required>
                                            </div>

                                            <button type="submit" class="btn btn-info"><i class="fa fa-edit"
                                                                                          aria-hidden="true"></i> Add
                                            </button>
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
                                    <th>Title</th>
                                    <th>Link</th>
                                    <th>Description</th>
                                    <th>Settings</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rssfeeds as $index=>$value)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{$value->rss_title}}</td>
                                        <td>{{$value->rss_link}}</td>
                                        <td>{{$value->rss_description}}</td>
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
                                                            <h4 class="modal-title"> Edit Service Process Steps</h4>
                                                        </div>
                                                        <div class="modal-body">

                                                            <form action="{{route('update_rssfeed')}}" method="post">
                                                                @csrf

                                                                <input type="hidden" id="rssfeed_id" name="rssfeed_id"
                                                                       value="{{ $value->id }}" required>

                                                                <div class="form-group">
                                                                    <label for="service">Title<span
                                                                            style="color:red">*</span></label>
                                                                    <input type="text" class="form-control"
                                                                           id="rss_title" name="rss_title"
                                                                           value="{{$value->rss_title}}" required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="service">Link</label>
                                                                    <input type="text" class="form-control"
                                                                           id="rss_link" name="rss_link"
                                                                           value="{{$value->rss_link}}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="service">Description<span
                                                                            style="color:red">*</span></label>
                                                                    <textarea rows="4" class="form-control"
                                                                              id="rss_detail" name="rss_detail"
                                                                              required>{{$value->rss_description}}</textarea>
                                                                </div>

                                                                <button type="submit" class="btn btn-info"><i
                                                                        class="fa fa-edit" aria-hidden="true"></i> Edit
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

                                            <a href="{{url('adminpanel/delete_rssfeed')}}/{{$value->id}}"
                                               class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>

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
