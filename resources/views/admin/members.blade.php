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
                        <h3 class="panel-title"><i class="lnr lnr-users"></i> Members List</h3>
                        <hr>
                    </div>
                    <div class="panel-body">

                        <a href="{{url('adminpanel/addmemberform')}}" class="btn btn-info"><i class="fa fa-plus-circle"
                                                                                              aria-hidden="true"></i>&nbsp;&nbsp;Add
                            Member</a>
                        <br><br>

                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Settings</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($members as $index=>$value)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ $value->user_code }}</td>
                                    <td>{{ $value->user_name }}</td>
                                    <td>{{ $value->email }}</td>
                                    <td>{{ $value->phone }}</td>
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

                                                        <form action="{{route('update_member')}}" method="post">
                                                            @csrf

                                                            <input type="hidden" id="member_id" name="member_id"
                                                                   value="{{ $value->id }}" required>

                                                            <div class="form-group">
                                                                <label for="service">Memebr Name <span
                                                                        style="color:red">*</span></label>
                                                                <input type="text" class="form-control" id="member_name"
                                                                       name="member_name"
                                                                       value="{{ $value->user_name }}" required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="comment">Email <span
                                                                        style="color:red">*</span></label>
                                                                <input type="text"
                                                                       class="form-control @error('member_code') is-invalid @enderror"
                                                                       id="member_email" name="member_email"
                                                                       value="{{ $value->email }}" required>

                                                                @error('member_email')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="comment">Phone (Optional):</label>
                                                                <input type="text" class="form-control"
                                                                       id="member_phone" name="member_phone"
                                                                       value="{{ $value->phone }}">
                                                            </div>


                                                            <button type="submit" class="btn btn-info"><i
                                                                    class="fa fa-edit" aria-hidden="true"></i> Edit
                                                                Member
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
                <!-- END OVERVIEW -->
            </div>
        </div>
        <!-- END MAIN CONTENT -->
    </div>
    <!-- END MAIN -->
    <div class="clearfix"></div>
@endsection
