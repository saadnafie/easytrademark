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
                            <i class="lnr lnr-users"></i>
                            Add New Member</h3>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><i class="lnr lnr-users"></i> Add New Member</div>
                                    <div class="panel-body">
                                        <form action="{{route('add_new_member')}}" method="post">
                                            @csrf

                                            <div class="form-group">
                                                <label for="service">Memebr Code <span
                                                        style="color:red">*</span></label>
                                                <input type="text"
                                                       class="form-control @error('member_code') is-invalid @enderror"
                                                       id="member_code" name="member_code"
                                                       value="{{old('member_code')}}" required>

                                                @error('member_code')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="service">Memebr Name <span
                                                        style="color:red">*</span></label>
                                                <input type="text" class="form-control" id="member_name"
                                                       name="member_name" value="{{old('member_name')}}" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="comment">Email <span style="color:red">*</span></label>
                                                <input type="text"
                                                       class="form-control @error('member_code') is-invalid @enderror"
                                                       id="member_email" name="member_email"
                                                       value="{{old('member_email')}}" required>

                                                @error('member_email')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="comment">Phone (Optional):</label>
                                                <input type="text" class="form-control" id="member_phone"
                                                       name="member_phone" value="{{old('member_phone')}}">
                                            </div>

                                            <button type="submit" class="btn btn-info"><i class="fa fa-plus-circle"
                                                                                          aria-hidden="true"></i> Add
                                                Member
                                            </button>
                                        </form>
                                    </div>
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
